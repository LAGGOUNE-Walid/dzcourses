<?php 
use src\app\http\Controllers\CourseController as CourseController;
use Carbon\Carbon;

final class AdminController {

	use CourseController;

	protected $username 	=	"walid2000";	
	protected $password 	= 	'$2y$10$nIvGaEZNjFfLBhLhvwvMdu/JFSXSA4OAbAO2JPvjpGODYt.61mC.2';
	protected $token 		=	null;
	// batatama9lia4321

	public function __construct() {
		$container 			= 	new src\app\http\Controllers\Container;
		$this->token 		= 	$container->get("Helper")->token($container);
	}

	final public function login(array $params, object $container) {
		return $container->get("View")->show("admin/adminLogin");
	}

	final public function postAdminLogin(array $params, object $container) {
		$request 	= 	$container->get("Request");
		$username 	= 	$request->get("username");
		$password 	= 	$request->get("password");
		if ($username == $this->username AND password_verify($password, $this->password)) {
			$session = $container->get("Session");
			$session->set("loggedIn", true);
			$session->set("type", "admin");
			return $container->get("Helper")->r($container, "adminPanel");
		}else {
			exit("Username or password is wrong ");
		}
	}

	final public function panel(array $params, object $container) {
		$collection 			= 		$collection = (new MongoDB\Client)->dzcourses;
		$submitedCourses 		= 		$this->countNoActivated($collection);
		$activatedCourses 		= 		$this->countActivated($collection);
		$helper 				=		$container->get("Helper");
		$teachers 				=		$helper->countAllTeacher($collection);
		$learnersNumber 		=		$helper->countAllLearners($collection);
		$newInvoices 			=		$helper->countNewLearnersInvoices($collection);
		$learnersInvoices 		=		$helper->countLearnersInvoices($collection);

		// delete mom activated larner accounts
		$helper->deleteNonActivatedLearnersAccounts($collection);	

		$data 					= 		[
			"submitedCourses" 	=> 		$submitedCourses,
			"activatedCourses" 	=> 		$activatedCourses,
			"teachers" 			=> 		$teachers,
			"learner" 			=> 		$learnersNumber,
			"newInvoices"		=> 		$newInvoices,
			"learnersInvoices"	=>		$learnersInvoices,
			"token" 			=>		$this->token
		];
		return $container->get("View")->show("admin/adminPanel", $data);
	}

	final public function getSubmitedCourses(array $params, object $container) {
		$collection 		= 		$collection = (new MongoDB\Client)->dzcourses;
		$courses 			=		$this->getNoActivated($collection);
		$submitedCourses 	= 		$this->countNoActivated($collection);
		if($courses->isDead()) {
			echo "There is no courses need to be activated ";
			exit;
		}
		$data = [
			"courses" 			=> 		$courses,
			"collection" 		=> 		$collection,
			"submitedCourses" 	=> 		$submitedCourses,
			"token"				=>		$this->token
		];
		return $container->get("View")->show("admin/submitedCourses", $data);
	}

	final public function rejectCourse(array $params, object $container) {
		$request 		= 	$container->get("Request");
		$reason 		= 	$request->get("reason");
		$id 			= 	$request->get("courseId");
		$userId 		=	$request->get("userId");
		$title 			=	$request->get("courseTitle"); 	
		$collection		=	$collection = (new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");

		$date = new Carbon;
		
		$collection->notifications->insertOne([
			"from" 				=> 		null, 
			"to" 				=> 		$userId, 
			"notification" 		=> 		"Your course {$title} is rejected and deleted. Reasons : <br/> {$reason} <br/><small>Dz-courses administration.</small>", 
			"seen" 				=> 		0,
			"created_at" 		=>		$date->year."/".$date->month."/".$date->day
		]);

		$helper->deleteFolder($collection->courses->findOne(["_id" =>  new MongoDB\BSON\ObjectId($id)])->folder);
		$collection->courses->deleteOne(["_id" =>  new MongoDB\BSON\ObjectId($id)]);

		return $container->get("Helper")->r($container, "submitedCourses");
	}

	final public function acceptCourse(array $params, object $container) {
		$request 		= 	$container->get("Request");
		$userId 		=	$request->get("userId");
		$id 			= 	$request->get("courseId");
		$title 			=	$request->get("courseTitle"); 	
		$collection		=	$collection = (new MongoDB\Client)->dzcourses;

		$collection->courses->updateOne(
			["_id" => new MongoDB\BSON\ObjectId($id)],
			['$set' => [
					'activated' => 1
				]
			]
		);

		$date = new Carbon;
		$collection->notifications->insertOne([
			"from" 				=> 		null, 
			"to" 				=> 		$userId, 
			"notification" 		=> 		"Congratulation ! your course {$title} accepted by Dz-courses administration .", 
			"seen" 				=> 		0,
			"created_at" 		=>		$date->year."/".$date->month."/".$date->day
		]);
		return $container->get("Helper")->r($container, "submitedCourses");
	}

	final public function allCourses(array $params, object $container) {
		$collection		=	$collection = (new MongoDB\Client)->dzcourses;
		$courses 		=	$collection->courses->find(["activated" => 1], ["sort" => ["created_at" => -1]]);
		$data 			=	[
			"courses" 				=> 		$courses,
			"collection" 			=> 		$collection,
			"CourseController" 		=> 		$this,
			"token"					=> 		$this->token
		];
		return $container->get("View")->show("admin/AdminShowAllCourses", $data);
	}

	final public function deleteCourse(array $params, object $container) {
		$request 		= 	$container->get("Request");
		$id 			=	$request->get("id");
		$reason 		= 	$request->get("reason");
		$userId 		=	$request->get("userId");
		$title 			=	$request->get("courseTitle"); 	
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");

		$date = new Carbon;
		$collection->notifications->insertOne([
			"from" 				=> 		null, 
			"to" 				=> 		$userId, 
			"notification" 		=> 		"Your course {$title} is deleted. Reasons : <br/> {$reason} <br/><small>Dz-courses administration.</small>", 
			"seen" 				=> 		0,
			"created_at" 		=>		$date->year."/".$date->month."/".$date->day
		]);
		
		$helper->deleteFolder($collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($id)])->folder);
		$collection->courses->deleteOne(["_id" =>  new MongoDB\BSON\ObjectId($id)]);

		return $container->get("Helper")->r($container, "allCourses");
	}

	public function allTeachers(array $params, object $container) {
		$helper 		= 	$container->get("Helper");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$allTeachers 	= 	$helper->getAllTeachers($collection);
		$data			=	[
			"token" 		=> 	$this->token,
			"teachers" 		=> 	$allTeachers,
			"collection"	=> 	$collection
		];
		return $container->get("View")->show("admin/allTeacher", $data);
	}

	public function allLearners(array $params, object $container) {
		$helper 		= 	$container->get("Helper");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$allLearners 	= 	$helper->getAllLearners($collection);
		$data			=	[
			"token" 		=> 	$this->token,
			"learners" 		=> 	$allLearners,
			"collection"	=> 	$collection
		];
		return $container->get("View")->show("admin/allLearners", $data);
	}

	final public function newSubmitedLearnersPayments(array $params, object $container) {
		$helper 		= 	$container->get("Helper");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$invoices 		= 	$helper->getNewSubmitedLearnersPayments($collection);
		$data			=	[
			"token" 		=> 	$this->token,
			"invoices" 		=> 	$invoices,
			"collection"	=> 	$collection
		];
		return $container->get("View")->show("admin/learnersInvoices", $data);
	}

	final public function acceptLearnerInvoice(array $params, object $container) {
		$request 		=	$container->get("Request");
		$userId 		=	$request->get("user_id");
		$plan 			=	$request->get("plan");
		$invoiceId 		=	$request->get("id");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");

		if(!$helper->updateUserPlan($collection, $userId, (int)$plan)) {
			echo 'Probleme happend when updateUserPlan() ';
			exit;
		}
		if (!$helper->changeInvoiceStatus($collection, $invoiceId)) {
			echo 'Probleme happend when changeInvoiceStatus() ';
			exit;
		}
		if (!$helper->pushAcceptedInvoiceNotification($collection, $userId)) {
			echo 'Probleme happend when pushAcceptedInvoiceNotification() ';
			exit;
		}

		return $helper->r($container, "newSubmitedLearnersPayments");

	}

	final public function allSubmitedLearnersPayments(array $params, object $container) {
		$helper 		= 	$container->get("Helper");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$invoices 		= 	$helper->getSubmitedLearnersPayments($collection);
		$data			=	[
			"token" 		=> 	$this->token,
			"invoices" 		=> 	$invoices,
			"collection"	=> 	$collection
		];
		return $container->get("View")->show("admin/allLearnersInvoices", $data);
	}

	final public function createPayment(array $params, object $container) {
		$collection 			= 	(new MongoDB\Client)->dzcourses;
		$allUsers 				= 	$collection->usersMoney->find(["paid" => false]);
		$usersToPayToday 		= 	[];
		foreach($allUsers as $user) {
			$paymentDay = Carbon::create($user->created_at)->addMonth();
			if ($paymentDay->isSameDay(Carbon::now())) {
				array_push($usersToPayToday, $user);
			}
		}
		$data = [
			"allUsers" 		=> 		$collection->usersMoney->find(["paid" => false]),
			"todayUsers" 	=> 		$usersToPayToday,
			"collection"	=>		$collection,
			"token"			=> 		$this->token
		];

		return $container->get("View")->show("admin/createPayments", $data);
	}

	public function postCreateInvoice(array $params, object $container) {
		$helper 		= 	$container->get("Helper");
		$request 		=	$container->get("Request");
		foreach($_FILES as $file)  {
			if (!$helper->verfiyUploadFile($file["name"], ["png", "jpg", "jpeg", "gif"], $file['tmp_name'])) {
				die("Extension not allowed in : ".$file["name"]);
			}
		}
		$collection 			= 	(new MongoDB\Client)->dzcourses;
		$collection->usersMoney->updateOne(
			[
				"_id" =>  new MongoDB\BSON\ObjectId($request->get("id"))
			],
			[
				'$set' => [
					"paid"	=> true
				]
			]
		);
		// upload images
		$bucket 		= 	$collection->selectGridFSBucket();
		$imagesNames 	= [];
		foreach($_FILES as $file) {
			$fileStream 	= 	fopen($file["tmp_name"], 'rb');
			$filename 		=	md5($file["name"].time());
			array_push($imagesNames, $filename);
			$bucket->uploadFromStream($filename, $fileStream);
		}
		// add invoice to db
		$date = Carbon::now();
		$collection->teachersInvoices->insertOne([
			"to"			=>	$request->get("to"),
			"image1"		=>	$imagesNames[0],
			"image2"		=>	$imagesNames[1],
			"image3"		=>	$imagesNames[2],
			"sum"			=>	$request->get("sum"),
			"created_at"	=>	$date->year."/".$date->month."/".$date->day
		]);
		// add notification to user;
		$helper->pushNewInvoiceNotification($collection, $container, $date, $request->get("to"));
		return $helper->r($container, "createPayment");
	}


	public function showLogs(array $params, object $container) {
		$files = (scandir("src/app/http/logs"));
		unset($files[0]);
		unset($files[1]);
		usort($files, function($file1, $file2) {
			return filemtime("src/app/http/logs/".$file1) < filemtime("src/app/http/logs/".$file2);
		});
		foreach ($files as $file) {
			echo "<a href='src/app/http/logs/$file'>".$file."</a><br/>";
		}
	}

	final public function adminLogout(array $params, object $container) {
		$container->get("Session")->destroy("loggedIn");
		$container->get("Session")->destroy("type");
		header("Location: ".$container->get("View")->url(""));
		exit;
	}

}
