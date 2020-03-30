<?php 

use src\app\http\Controllers\CourseController as CourseController;

final class UserController {

	use CourseController;

	protected $token;
	protected $profitFromOneCourse = 300;

	public function __construct() {
		$container 			= 	new src\app\http\Controllers\Container;
		$this->token 		= 	$container->get("Session")->token();
		$this->user 		=	$container->get("Helper")->user((new MongoDB\Client)->dzcourses, $container->get("Session"));
	}

	final public function teacherSignup(array $params, object $container) {
		$session 	=	$container->get("Session");
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherSignup", ["token" => $this->token, "container" => $container]);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherSignup", ["token" => $this->token, "container" => $container]);
	}
	
	final public function postTeacherSignup(array $params, object $container) {

		$validator 		= 	$container->get("ValidatorFactory"); 
		$session 		= 	$container->get("Session");
		$request 		= 	$container->get("Request");
		$helper 		= 	$container->get("Helper");

		$validation 	= 	$validator->make($request, [
			"firstname" 	=> 	"required:true,cleanHtml:true,min:1,max:30,type:string", 
			"lastname" 		=> 	"required:true,cleanHtml:true,min:1,max:30,type:string", 
			"email" 		=> 	"required:true,cleanHtml:true,type:email", 
			"address" 		=> 	"required:true,cleanHtml:true,min:1,max:150",
			"phone" 		=> 	"required:true,cleanHtml:true,min:9",
			"description" 	=>  "required:true,cleanHtml:true,min:3,max:250",
			"ccp" 			=> 	"required:true",
			"key" 			=> 	"required:true",
			"password" 		=> 	"required:true,cleanHtml:true,min:3,max:250",
		]);
		if (sizeof($validation->errors) > 0) {
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/teacher/teacherSignup", ["errors" => $validation->errors, "token" => $this->token, "container" => $container]);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/teacherSignup", ["errors" => $validation->errors, "token" => $this->token, "container" => $container]); 
		}

		$collection = (new MongoDB\Client)->dzcourses;

		if ($helper->userExists(["phone" => $request->get("phone"), "ccp" => $request->get("ccp")], $collection->users)) {
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/teacher/teacherSignup", ["errors" => ["our website" => "There is a user with this phone number or/and ccp "], "token" => $this->token, "container" => $container]);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/teacherSignup", ["errors" => ["our website" => "There is a user with this phone number or/and ccp "], "token" => $this->token, "container" => $container]);
		}

		$photo 		= 	$request->file("photo");

		if (!$helper->verfiyUploadFile($photo, ["png", "jpg", "jpeg", "gif"])) {
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/teacher/teacherSignup", ["errors" => ["photo" => "file can't be uploaded, Accepted images formats : png, jpg, jpeg, gif"], "token" => $this->token, "container" => $container]);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/teacherSignup", ["errors" => ["photo" => "file can't be uploaded !"], "token" => $this->token, "container" => $container]); 
		}

		$date = new Carbon\Carbon;
		if ((string) $insert = $helper->saveUser([
				"firstname" 	=> 	$request->get("firstname"),
				"lastname" 		=> 	$request->get("lastname"),
				"email" 		=> 	$request->get("email"),
				"address"	 	=> 	$request->get("address"),
				"phone" 		=> 	$request->get("phone"),
				"description" 	=> 	$request->get("description"),
				"photo" 		=> 	$photo,
				"ccp" 			=> 	$request->get("ccp"),
				"key" 			=> 	$request->get("key"),
				"created_at" 	=> 	$date::now()->format("Y-m-d"),
				"role" 			=> 	"teacher",
				"password" 		=> 	password_hash($request->get("password"), PASSWORD_BCRYPT, ["salt" => random_bytes(32)])
			], $collection->users) AND $insert !== false) {
				$id = (string) $insert;
				$session->set("loggedIn", true);
				$session->set("type", "teacher");
				$session->set("id", $id);
				return $helper->r($container, "tPanel");
		}

		$data = [
			"errors" => [
				"Not defined" => "Some problems in the website ... retry again"
			], 
			"token" => $this->token,
			"container" => $container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherSignup", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherSignup", $data); 

	}

	final public function teacherLogin(array $params, object $container) {
		$data = [
			"token" => $this->token,
			"container" => $container
		];
		$session = $container->get("Session");
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherLogin", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherLogin", $data); 
	}

	final public function postTeacherLogin(array $params, object $container) {
		$session 			= 		$container->get("Session");
		$request 			=		$container->get("Request");
		$collection 		= 		(new MongoDB\Client)->dzcourses->users;
		$helper 			=		$container->get("Helper");
		strip_tags($request->get("email"));
		strip_tags($request->get("phone"));
		strip_tags($request->get("password"));
		if($data = $helper->canLogin($request->get("email"), $request->get("phone"), $request->get("password"), $collection) AND $data !== false) {
				$id 		= 	(string) $data->_id;
				$session->set("loggedIn", true);
				$session->set("type", "teacher");
				$session->set("id", $id);
				return $helper->r($container, "tPanel");
		}else {
			$data = [
				"errors" => "Verify your data please", 
				"token" => $this->token,
				"container" => $container
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/teacher/teacherLogin", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/teacherLogin", $data); 
		}
	}

	final public function teacherPanel(array $params, object $container) {
		
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$courses 		= 		$this->getUserCourses($collection, $container);
		$carbon 		= 		new Carbon\Carbon;
		$helper 		=		$container->get("Helper");
		$session 		=		$container->get("Session");
		$sum 			=		$helper->calculateTeacherMoney($collection, $session, $carbon);
		$moneyThisYear 	= 		$helper->calculateTeacherMoneyForThisYear($collection,  $session, $carbon);
		$takes 			=		$helper->calculateCoursesTakes($collection,  $session, $carbon);
		$visits 		=		$helper->calculateVisits($collection, $session, $carbon);
		$comments		=		$helper->getSomeComments($collection, $session);
		$user 			=		$this->user;
		$messages 		=		$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$invoices 		=		$helper->getTeacherInvoices($collection, $session);

		$data 			=		[
			"collection" 		=> 		$collection, 
			"container"			=>		$container,
			"comments" 			=> 		$comments, 
			"date" 				=> 		$carbon,
			"takes" 			=> 		$takes,
			"allMoney" 			=> 		$sum,
			"money" 			=> 		$moneyThisYear,
			"token" 			=>		$this->token, 
			"courses" 			=> 		$courses,
			"visits" 			=> 		$visits ,
			"user" 				=> 		$user, 
			"messages" 			=> 		$messages,
			"notifications" 	=> 		$notifications,
			"invoices"			=>		$invoices,
			"dzcoursesCCP"		=>		575118524525
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherPanel", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherPanel", $data); 
	}

	final public function teacherSettings(array $params, object $container) {
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$session 		=		$container->get("Session");
		$helper 		=	 	$container->get("Helper");
		$user 			=		$this->user;
		$messages 		=		$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$data 			= 		[
			"token" 			=> 		$this->token, 
			"user" 				=> 		$this->user, 
			"messages" 			=> 		$messages,
			"notifications"		=> 		$notifications,
			"container"			=>		$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherSettings", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherSettings", $data); 
	}


	final public function postTeacherSettings(array $params, object $container) {
		$helper 		=	 	$container->get("Helper");
		$session 		= 		$container->get("Session");
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$user 			=		$this->user;
		$helper->updateUser($container->get("Request"), $session, $user, $container->get("ValidatorFactory"), $container, $collection, $this->token);
		$messages 		=		$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$data 			=		[
			"suc" 			=> 		"Updated" ,
			"token" 		=> 		$this->token, 
			"user" 			=> 		$user, 
			"messages" 		=> 		$messages,
			"notifications"	=> 		$notifications
		];
		if($session->get("lang") == "ar") {
			$data["suc"]	= "تم التحديث";
			$container->get("View")->show("ar/teacher/teacherSettings", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherSettings", $data); 
	}

	final public function teacherAccount(array $params, object $container) {
		$helper 		=	 	$container->get("Helper");
		$session 		= 		$container->get("Session");
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$user 			= 		$this->user;
		$messages 		= 		$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$data 			=  		[
			"token" 		=> 	$this->token, 
			"user" 			=> 	$this->user, 
			"messages" 		=> 	$messages,
			"notifications"	=> 	$notifications,
			"container"		=>	$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherProfile", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherProfile", $data); 
	}

	final public function showProfile(array $params, object $container) {
		if (strlen($params["id"]) !== 24 OR !ctype_xdigit($params["id"])) {
			return $container->get("View")->show("errors/404");
			exit;
		}
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$helper 		= 		$container->get("Helper");
		$user 			= 		$helper->getProfile($collection, $params["id"], "teacher");
		$courses		= 		$collection->courses->count(["user_id" => $params["id"]]);
		if(is_null($user)) {
			$learner = $helper->getProfile($collection, $params["id"], "learner");
			if(is_null($learner)) {	
				return $container->get("View")->show("errors/404");
				exit;
			}
			$coursesTaken 	=	 $collection->coursesProgress->find(["user_id" => $container->get("Session")->get('id')]);
			$helper->saveVisit($collection, $params["id"], new Carbon\Carbon);
			return $container->get("View")->show("en/profile", ["user" => $learner, "coursesTaken" => $coursesTaken, "courseCollection" => $collection->courses]);
		}
		$helper->saveVisit($collection, $params["id"], new Carbon\Carbon);

		$data = [
			"user" 		=> 	$user,
			"courses" 	=> 	$courses
		];
		return $container->get("View")->show("en/profile", $data);
	}

	final public function sendMessage(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$user 			= 	$helper->getProfile($collection, $params["id"], "teacher");
		if(is_null($user)) {
			$user = $helper->getProfile($collection, $params["id"], "learner");
			if(is_null($user)) {	
				return $container->get("View")->show("errors/404");
				exit;
			}
		}

		$data = [
			"user" => $user
		];
		return $container->get("View")->show("en/sendMessage", $data);
	}

	final public function messages(array $params, object $container) {
		$perPage 		= 	10;
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		=	$container->get("Session");
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);
		$userId 		= 	$session->get("id");
		$count 			= 	$collection->messages->count(["user_id" => $userId, "read" => "0"]);
		$allMsgsCount 	= 	$collection->messages->count(["user_id" => $userId]);
		
		$collection->messages->updateMany(["user_id" => $userId, "read" => 0], ['$set' => ["read" => 1]]);

		if ($params["page"] > 1) {
			$find 			= 	$helper->getMessagesFormPage($collection, $perPage, (($params["page"] > 1) ? ($params["page"] * $perPage) - $perPage : 0), $userId);
			if($session->get("type") == "teacher") {

				$data = [
					"token" 			=> 		$this->token ,
					"pages" 			=> 		$helper->getPages($collection->messages, $session->get("id"), $perPage) ,
					"allMsgsCount" 		=> 		$allMsgsCount, 
					"messages" 			=> 		$find, 
					"count" 			=> 		$count, 
					"notifications"		=> 		$notifications,
					"user" 				=> 		$this->user,
					"container"			=>		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/teacher/teacherMessages", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/teacher/teacherMessages", $data);
				return true;

			}else {
				$pages 		= $helper->getPages($collection->messages, $container->get("Session")->get("id"), $perPage);
				$data 		= 	[
					"token" 		=> 		$this->token , 
					"pages" 		=> 		$pages,
					"allMsgsCount" 	=> 		$allMsgsCount, 
					"messages" 		=> 		$find, 
					"count" 		=> 		$count,
					"notifications"	=> 		$notifications, 
					"user" 			=> 		$this->user,
					"container"		=>		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/learner/learnerMessages", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/learner/learnerMessages", $data);
				return true;
			}
		}else {
			$find 		= 	$container->get("Helper")->getMessages($collection, $userId);
			if($container->get("Session")->get("type") == "teacher") {
				$data 	=	[
					"token" 		=> 		$this->token ,
					"pages" 		=> 		$helper->getPages($collection->messages, $userId, $perPage) ,
					"allMsgsCount" 	=> 		$allMsgsCount, 
					"messages" 		=> 		$find, 
					"count" 		=> 		$count,
					"notifications"	=> 		$notifications, 
					"user" 			=>		$this->user,
					"container"			=>		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/teacher/teacherMessages", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/teacher/teacherMessages", $data);
				return true;
			}else {
				$data = [
					"token" 		=> 		$this->token, 
					"pages" 		=> 		$helper->getPages($collection->messages, $userId, $perPage) ,
					"allMsgsCount" 	=> 		$allMsgsCount, 
					"messages" 		=> 		$find, 
					"count" 		=> 		$count,
					"notifications"	=> 		$notifications, 
					"user" 			=> 		$this->user,
					"container"		=>		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/learner/learnerMessages", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/learner/learnerMessages", $data);
				return true;
			}
		}
	}

	final public function notifications(array $params, object $container) {
		$perPage 		= 		10;
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$helper 		=		$container->get("Helper");
		$session 		=		$container->get("Session");
		$messages 		=		$helper->teacherMessages($collection, $session);	

		$userId 		= 	$session->get("id");
		$count 			=	$collection->messages->count(["user_id" => $userId, "read" => "0"]);
		$countN 		= 	$collection->notifications->count(["to" => $userId, "seen" => 0]);
		$allNotfsCount 	= 	$collection->notifications->count(["to" => $userId]);
		$collection->notifications->updateMany(["to" => $userId, "seen" => 0], ['$set' => ["seen" => 1]]);

		if ($params["page"] > 1) {
			$find 			= 	$helper->getNotificationsFormPage($collection, $perPage, (($params["page"] > 1) ? ($params["page"] * $perPage) - $perPage : 0), $userId);
			if($session->get("type") == "teacher") {

				$data = [
					"token" 			=> 		$this->token ,
					"pages" 			=> 		$helper->getNotfPages($collection->notifications, $session->get("id"), $perPage) ,
					"allNotfsCount" 	=> 		$allNotfsCount, 
					"notifications" 	=> 		$find, 
					"count" 			=> 		$count,
					"countN" 			=> 		$countN, 
					"messages"			=>		$messages, 
					"user" 				=> 		$this->user,
					"container"			=>		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/teacher/teacherNotifications", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/teacher/teacherNotifications", $data);
				return true;

			}else {
				$pages 		= $helper->getNotfPages($collection->notifications, $container->get("Session")->get("id"), $perPage);
				$data 		= 	[
					"token" 			=> 		$this->token , 
					"pages" 			=> 		$pages,
					"allNotfsCount" 	=> 		$allNotfsCount, 
					"notifications" 	=> 		$find, 
					"count" 			=> 		$count,
					"countN" 			=> 		$countN,  
					"messages"			=> 		$messages,
					"user" 				=> 		$this->user,
					"container"			=> 		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/learner/learnerNotifications", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/learner/learnerNotifications", $data);
				return true;
			}
		}else {
			$find 		= 	$container->get("Helper")->getNotifications($collection, $userId);
			if($container->get("Session")->get("type") == "teacher") {
				$data 	=	[
					"token" 			=> 		$this->token ,
					"pages" 			=> 		$helper->getNotfPages($collection->notifications, $userId, $perPage) ,
					"allNotfsCount" 	=> 		$allNotfsCount, 
					"notifications" 	=> 		$find, 
					"count" 			=> 		$count,
					"countN" 			=> 		$countN,  
					"messages"			=> 		$messages,
					"user" 				=>		$this->user,
					"container"			=>		$container
				];	
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/teacher/teacherNotifications", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/teacher/teacherNotifications", $data);
				return true;
			}else {
				$data = [
					"token" 			=> 		$this->token, 
					"pages" 			=> 		$helper->getNotfPages($collection->notifications, $userId, $perPage) ,
					"allNotfsCount" 	=> 		$allNotfsCount, 
					"notifications" 	=> 		$find, 
					"count"				=>		$count,
					"countN" 			=> 		$countN, 
					"messages"			=> 		$messages,
					"user" 				=> 		$this->user,
					"container"			=>		$container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/learner/learnerNotifications", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/learner/learnerNotifications", $data);
				return true;
			}
		}

	}
	final public function lNotifications(array $params, object $container) {

	}

	final public function addCourse(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$data 			= 	[
			"token" 		=> 		$this->token,
		 	"user" 			=> 		$user, 
		 	"messages" 		=> 		$messages,
		 	"notifications"	=> 		$notifications,
		 	"container"		=>		$container
		 ];
		 if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/addCourse", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/addCourse", $data);
		return true;

	}

	final public function postCourse(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$data 			= 	($this->verifyInputs($container, $collection));
		$session 		=	$container->get("Session");
		if(!is_null($data)) {
			if($this->saveCourse($data, $collection) instanceof MongoDB\InsertOneResult) {
				 if($session->get("lang") == "ar") {
				 	echo '<br/><div class="alert alert-success" role="alert">';
					echo "تم رفع دورتك بنجاح سوف تتلقا تنبيهاً في لوحة التحكم عندما يتم قبول دورتك !";
				echo "</div>";
					exit;
				 }
				echo '<br/><div class="alert alert-success" role="alert">';
					echo "Your course added successfully , you will get a notification when it is accepted by the administration.";
				echo "</div>";
					exit;
			}
			echo "Something wrong happened , try again please .";
			exit;
		}
		return false;	
	}

	final public function showTeacherCourses(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$session 		=	$container->get("Session");
		$courses 		=	$this->getAllTeacherCourses($collection, $session);
		$helper 		=	$container->get("Helper");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);
		$data 	=	[
			"user" 					=> 		$user, 
			"token" 				=> 		$this->token,
			"messages" 				=> 		$messages,
			"notifications"			=>		$notifications,
			"courses"				=> 		$courses,
			"courseController" 		=> 		$this,
			"collection" 			=> 		$collection,
			"helper"				=> 		$helper,
			"profitFromOneCourse" 	=> 		$this->profitFromOneCourse,
			"container"				=>		$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/teacherCourses", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/teacherCourses", $data);
		return true;
	}

	final public function share(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$files 			=	$helper->getUserFiles($collection, $session);
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);
		$data 	=	[
			"files" 		=> 		$files, 
			"user" 			=> 		$user, 
			"token" 		=> 		$this->token,
			"messages" 		=> 		$messages,
			"notifications"	=>		$notifications,
			"container"		=>		$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/fileShare", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/fileShare", $data);
		return true;
	}

	final public function postFile(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$request 		= 	$container->get("Request");
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);
		$file 			= 	$request->file("file");

		if (is_null($file)) {
			$files 		= 	$helper->getUserFiles($collection, $session);
			$data 		= 	[
			"errors" 		=>	 	[ 
				"file" => "Please select a non empty zip"
			],
			"files"			=>		$files, 
			"user" 			=>	 	$user, 
			"token" 		=> 		$this->token,
			"messages" 		=> 		$messages,
			"notifications"	=> 		$notifications,
			"container"		=>		$container
			];

			if($session->get("lang") == "ar") {
				$data["errors"]["file"] = "الرجاء عدم رفع ملف فارغ";
				$container->get("View")->show("ar/teacher/fileShare", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/fileShare", $data);
			exit;
		}

		$name 	= 	md5($file->getName().time());

		if (!$helper->verfiyUploadFile($file, ["zip"])) {
			$helper->writeToLog("/postFile", "This user uploaded non zip file ! ");
			$files 		= $helper->getUserFiles($collection, $session);
			$data 		= 	[
			"errors" 		=>	 	[ 
				"file" => "Please upload your file as ZIP"
			],
			"files"			=>		$files, 
			"user" 			=>	 	$user, 
			"token" 		=> 		$this->token,
			"messages" 		=> 		$messages,
			"notifications"	=> 		$notifications,
			"container"		=>		$container
			];
			if($session->get("lang") == "ar") {
				$data["errors"]["file"] = "الرجاء رفع الملف بصيغة ZIP";
				$container->get("View")->show("ar/teacher/fileShare", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/fileShare", $data);
			return true;
		}
		if ($helper->extractAndVerify($file, $name) === false) {
			$helper->writeToLog("/postFile", "This user uploaded malicious files ! ");
			$helper->deleteFolder("src/app/views/files/".$name);
			$files = $helper->getUserFiles($collection, $session);
			$data 		= 	[
				"errors" 		=>	 	[ 
					"file" => "Extensions are not supported, or size not allowed"
				],
				"files"			=>		$files, 
				"user" 			=>	 	$user, 
				"token" 		=> 		$this->token,
				"messages" 		=> 		$messages,
				"notifications"	=> 		$notifications,
				"container"		=>		$container
			];
			if($session->get("lang") == "ar") {
				$data["errors"]["file"] = "صيغة الملف غير مدعومة";
				$container->get("View")->show("ar/teacher/fileShare", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/teacher/fileShare", $data);
			return true;
			}

		move_uploaded_file($file->getTmp(), "src/app/views/files/".$name.".zip");
		$helper->deleteFolder("src/app/views/files/".$name);
		$date 		= 	new Carbon\Carbon;
		$insert 	= 	$collection->files->insertOne([
			"user_id"		=> 		$container->get("Session")->get("id"), 
			"path"	 		=> 		"src/app/views/files/".$name.".zip", 
			"created_at" 	=> 		$date::now()->format("Y-m-d"), 
			"downloads" 	=> 		"0"
		]);
		$fileLink 	= 	$container->get("View")->url("file")."/".$insert->getInsertedId();
		$files = $helper->getUserFiles($collection, $session);

		$data 		= 	[
			"fileLink" 		=> 		$fileLink, 
			"suc" 			=> 		"File upload successfully", 
			"user" 			=> 		$user,
			"files"			=>		$files,  
			"token" 		=>		$this->token,
			"messages" 		=> 		$messages,
			"notifications"	=>		$notifications,
			"container"		=>		$container
		];
		if($session->get("lang") == "ar") {
			$data["suc"] = "تم رفع ملفك";
			$container->get("View")->show("ar/teacher/fileShare", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/fileShare", $data);
		return true;
	}

	final public function deleteFile(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$request 		= 	$container->get("Request");
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);

		$filePath = $collection->files->findOne(["_id" => new MongoDB\BSON\ObjectId($request->get("fileId"))])->path;
		$collection->files->deleteOne(["_id" => new MongoDB\BSON\ObjectId($request->get("fileId"))]);
		unlink($filePath);
		$files = $helper->getUserFiles($collection, $session);
		$data = [
			"suc" 			=> 		"File Deleted successfully", 
			"user" 			=> 		$user, 
			"files"			=>		$files,  
			"token" 		=> 		$this->token,
			"messages" 		=> 		$messages,
			"notifications"	=>		$notifications
		];
		return $container->get("View")->show("en/teacher/fileShare", $data);

	}

	final public function logout(array $params, object $container) {
		$container->get("Session")->destroy("loggedIn");
		header("Location: ".$container->get("View")->url(""));
		exit;
	}

	final public function buyOnline(array $params, object $container) {
		$collection = $collection = (new MongoDB\Client)->dzcourses;
		$user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
		if(!$this->verifyDate($container, $user, new Carbon\Carbon)) {
			if (is_null($user)) {
				$container->get("Session")->destroy("loggedIn");
				header("Location: ".$container->get("View")->url("teacherLogin"));
				exit;
			}
			return $container->get("View")->show("buyOnline", ["user" => $user, "token" => $this->token]);
			exit;
		}
		$ex 			= 	explode("-", $user->activated_at);
		$carbon 		= 	new Carbon\Carbon;
		$userActivated 	= 	$carbon::create($ex[0], $ex[1], $ex[2]);
		$expirat 		=	$carbon::now()->diffInDays($userActivated);
		return $container->get("View")->show("notExpired", ["user" => $user, "expirat" => $expirat]);
	}

	final public function postBuyPlan(array $params, object $container) {
		$collection = $collection = (new MongoDB\Client)->dzcourses;
		$user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
		$carbon 		= 	new Carbon\Carbon;
		if(!$this->verifyDate($container, $user, new Carbon\Carbon)) {
			if (is_null($user)) {
				$container->get("Session")->destroy("loggedIn");
				header("Location: ".$container->get("View")->url("teacherLogin"));
				exit;
			}
			$request = $container->get("Request");
			$collection->users->updateOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))], ['$set' => ["activated" => "1", "activated_at" => $carbon::now()->format("Y-m-d"), "plan" => $request->get("plan")]]);
			header("Location: ".$container->get("View")->url("tPanel"));
			exit;
		}
		$ex 			= 	explode("-", $user->activated_at);
		$userActivated 	= 	$carbon::create($ex[0], $ex[1], $ex[2]);
		$expirat 		=	$carbon::now()->diffInDays($userActivated);
		return $container->get("View")->show("notExpired", ["user" => $user, "expirat" => $expirat]);
	}

	final public function postBuyCustomPlan(array $params, object $container) {
		$collection = $collection = (new MongoDB\Client)->dzcourses;
		$user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
		$carbon 		= 	new Carbon\Carbon;
		if(!$this->verifyDate($container, $user, new Carbon\Carbon)) {
			if (is_null($user)) {
				$container->get("Session")->destroy("loggedIn");
				header("Location: ".$container->get("View")->url("teacherLogin"));
				exit;
			}
			$request = $container->get("Request");
			if ($request->get("cplan") >= 4 AND $request->get("cplan") <= 10) {
				$collection->users->updateOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))], ['$set' => ["activated" => "1", "activated_at" => $carbon::now()->format("Y-m-d"), "plan" => $request->get("cplan")]]);
				header("Location: ".$container->get("View")->url("tPanel"));
				exit;				
			}else {
				return $container->get("View")->show("buyOnline", ["err" => "Please enter a number between 4 and 10 !","user" => $user, "token" => $this->token]);
				exit;
			}
		}
		$ex 			= 	explode("-", $user->activated_at);
		$userActivated 	= 	$carbon::create($ex[0], $ex[1], $ex[2]);
		$expirat 		=	$carbon::now()->diffInDays($userActivated);
		return $container->get("View")->show("notExpired", ["user" => $user, "expirat" => $expirat]);
	}

	final public function learnerSignup(array $params, object $container) {
		$session = $container->get("Session");
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/learner/learnerSignup", ["token" => $this->token, "container" => $container]);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerSignup", ["token" => $this->token, "container" => $container]);

	}

	final public function postLearnerSignup(array $params, object $container) {
		$helper 		=	$container->get("Helper");
		$validator 		= 	$container->get("ValidatorFactory"); 
		$session 		= 	$container->get("Session");
		$request 		= 	$container->get("Request");
		$validation 	= 	$validator->make($request, [
			"firstname" 	=> 	"required:true,cleanHtml:true,min:1,max:30,type:string", 
			"lastname" 		=> 	"required:true,cleanHtml:true,min:1,max:30,type:string", 
			"email" 		=> 	"required:true,cleanHtml:true,type:email", 
			"address" 		=> 	"required:true,cleanHtml:true,min:1,max:150",
			"phone" 		=> 	"required:true,cleanHtml:true,min:9",
			"description" 	=>  "required:true,cleanHtml:true,min:3,max:250",
			"password" 		=> 	"required:true,cleanHtml:true,min:3,max:250",
			"plan" 			=> 	"required:true,cleanHtml:true",
		]);
		if (sizeof($validation->errors) > 0) {
			$data =  [
				"errors" 	=> 		$validation->errors,
				"token" 	=> 		$this->token,
				"container"	=>		$container
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/learner/learnerSignup", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/learner/learnerSignup", $data);
		}

		$collection = (new MongoDB\Client)->dzcourses->learners;
		if ($helper->learnerExists(["phone" => $request->get("phone"), "email" => $request->get("email")], $collection)) {
			$data = [
				"errors" 	=> 	[
					"our website" => "There is a user with this phone number or/and phone number "
				], 
				"token" 	=> 	$this->token,
				"container"	=>	$container
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/learner/learnerSignup", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/learner/learnerSignup", $data);
		}
		$photo 			= 	$request->file("photo");
		if (!$helper->verfiyUploadFile($photo, ["png", "jpg", "jpeg", "gif"])) {
			$data 		=  [
				"errors" => [
					"photo" => "file can't be uploaded, Accepted images formats : png jpg jpeg gif"
					], 
				"token" => $this->token,
				"container"	=> $container
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/learner/learnerSignup", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/learner/learnerSignup", $data);
		}
		$date 	= 	new Carbon\Carbon;
		$guard 	= 	null;
		if ($request->get("plan") == 1) {
			$guard 		= 	"basic";
		}elseif ($request->get("plan") == 2) {
			$guard 		= 	"plus";
		}elseif ($request->get("plan") == 3) {
			$guard 		=	"pro";
		}else{
			die("Undifiend plan number : ".$request->get("plan"));
		}
		if ((string) $insert = $container->get("Helper")->saveUser([
				"firstname" 	=> 	$request->get("firstname"),
				"lastname" 		=> 	$request->get("lastname"),
				"email" 		=> 	$request->get("email"),
				"address"	 	=> 	$request->get("address"),
				"phone" 		=> 	$request->get("phone"),
				"description" 	=> 	$request->get("description"),
				"photo" 		=> 	$photo,
				"created_at" 	=> 	$date::now()->format("Y-m-d"),
				"role" 			=> 	"learner",
				"plan" 			=> 	$request->get("plan"),
				"guard"			=>	$guard,
				"activated" 	=> 		0,
				"activated_at" 	=> 		0,
				"password" 		=> 	password_hash($request->get("password"), PASSWORD_BCRYPT, ["salt" => random_bytes(32)])
			], $collection) AND $insert !== false) {
				$id = (string) $insert;
				$session->set("loggedIn", true);
				$session->set("type", "learner");
				$session->set("guard", $guard);
				$session->set("id", $id);
				return $container->get("Helper")->r($container, "lPanel");
		}
		$data = [
			"errors" => [
				"Not defined" => "Some problems in the website ... retry again"
			], 
			"token" => $this->token,
			"container"	=> $container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/learner/learnerSignup", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerSignup", $data);
	}

	final public function learnerLogin(array $params, object $container) {
		$session = $container->get("Session");
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/learner/learnerLogin", ["token" => $this->token, "container" => $container]);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerLogin", ["token" => $this->token, "container" => $container]);
	}

	final public function postLearnerLogin(array $params, object $container) {
		$session 			= 		$container->get("Session");
		$request 			=		$container->get("Request");
		$collection 		= 		(new MongoDB\Client)->dzcourses->learners;
		if($data = $container->get("Helper")->canLogin($request->get("email"), $request->get("phone"), $request->get("password"), $collection) AND $data !== false) {
				$id 		= 	(string) $data->_id;
				$session->set("loggedIn", true);
				$session->set("type", "learner");
				$session->set("id", $id);
				return $container->get("Helper")->r($container, "lPanel");
		}else {
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/learner/learnerLogin", ["errors" => "Verify your data please", "token" => $this->token, "container" => $container]);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/learner/learnerLogin", ["errors" => "Verify your data please", "token" => $this->token, "container" => $container]);
		}
	}

	final public function learnerPanel(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$userCourses 	=	$collection->coursesProgress->find(["user_id" => $session->get('id')],  ['limit' => 10,'sort' => ["_id" => -1]]);	
		$invoices 		=	$collection->learnerInvoices->find(["userId" => $session->get("id")], ['sort' => ["_id" => -1]]);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);

		$data 			=	[
			'collection' 		=> 		$collection, 
			"userCourses" 		=> 		$userCourses, 
			"token" 			=>		$this->token, 
			"user" 				=> 		$user, 
			"messages" 			=> 		$messages,
			"invoices"			=> 		$invoices,
			"notifications" 	=> 		$notifications,
			"container"			=>		$container
		];

		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/learner/learnerPanel", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerPanel", $data);
	}

	final public function learnerAccount(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$userCourses 	=	$collection->coursesProgress->count(["user_id" => $container->get("Session")->get('id')]);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);

		$data			=	 [
			"token" 		=> 		$this->token, 
			"courses" 		=> 		$userCourses,
			"user" 			=>		$user, 
			"messages" 		=> 		$messages,
			"notifications"	=>		$notifications,
			"container"		=>		$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/learner/learnerProfile", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerProfile", $data);
	}

	final public function learnerSettings(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);

		$data  			= 	[
			"token"	 			=> 		$this->token, 
			"user" 				=> 		$user,
			"messages" 			=> 		$messages,
			"notifications"		=> 		$notifications,
			"container"			=>		$container
		 ];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/learner/learnerSettings", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerSettings", $data);
	}

	final public function postLearnerSettings(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);

		$helper->updateUser($container->get("Request"), $session, $user, $container->get("ValidatorFactory"), $container, $collection, $this->token);

		$data = [
				"suc" 			=> 		"Updated successfully",
				"token" 		=> 		$this->token, 
				"user" 			=> 		$user, 
				"messages" 		=> 		$messages,
				"notifications"	=>		$notifications,
				"container"		=>		$container
		];
		if($session->get("lang") == "ar") {
			$data["suc"] = "تم التعديل";
			$container->get("View")->show("ar/learner/learnerSettings", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerSettings", $data);
	}

	final public function courses(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		= 	$container->get("Session");
		$user 			= 	$this->user;
		$messages 		= 	$helper->teacherMessages($collection, $session);
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);
		$userCourses 	=	$collection->coursesProgress->find(["user_id" => $container->get("Session")->get('id')],  ['sort' => ["_id" => -1]]);
		$data			=	[
			'collection' 	=> 		$collection, 
			"userCourses" 	=> 		$userCourses, 
			"user" 			=>	 	$user,
			"messages" 		=>	 	$messages,
			"notifications"	=>		$notifications,
			"container"		=>		$container,
			"token"			=>		$this->token
		];
		if($session->get("lang") == "ar") {
			$data["suc"] = "تم التعديل";
			$container->get("View")->show("ar/learner/learnerCourses", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/learner/learnerCourses", $data);
	}

	final public function chatRoom(array $params, object $container) {
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$session 		=		$container->get("Session");
		$helper 		=	 	$container->get("Helper");
		$user 			=		$this->user;
		$messages 		=		$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
		$data 			= 		[
			"token" 			=> 		$this->token, 
			"user" 				=> 		$this->user, 
			"messages" 			=> 		$messages,
			"notifications"		=> 		$notifications,
			"createdRooms" 		=> 		$createdRooms,
			"container"			=>		$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/teacher/createChatRoom", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/teacher/createChatRoom", $data);
	}

	final public function postCreateChatRoom(array $params, object $container) {
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$request 		=		$container->get("Request");
		$validator 		= 		$container->get("ValidatorFactory"); 
		$helper 		=	 	$container->get("Helper");
		$session 		=		$container->get("Session");
		$validation 	= 		$validator->make($request, [
			"title" 		=> 	"required:true,cleanHtml:true,min:0", 
			"courseUrl" 	=> 	"required:true,cleanHtml:true,type:url", 
		]);
		if (sizeof($validation->errors) > 0) { 
			$messages 		=		$helper->teacherMessages($collection, $session);
			$notifications	=		$helper->getNonSeenNotifications($collection, $session);
			$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
			$data 			= 		[
				"token" 			=> 		$this->token, 
				"user" 				=> 		$this->user, 
				"messages" 			=> 		$messages,
				"notifications"		=> 		$notifications,
				"errors" 			=> 		$validation->errors,
				"createdRooms"		=> 		$createdRooms,
				"container"			=>		$container
			];

			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/teacher/createChatRoom", $data);
				exit;
			}
			$session->set("lang", "eng");
			return $container->get("View")->show("en/teacher/createChatRoom", $data);
		}

		if(!$this->ifThisCourseExists($request->get("courseUrl"), $collection, $helper)) {
			$messages 		=		$helper->teacherMessages($collection, $session);
			$notifications	=		$helper->getNonSeenNotifications($collection, $session);
			$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
			$data 			= 		[
				"token" 			=> 		$this->token, 
				"user" 				=> 		$this->user, 
				"messages" 			=> 		$messages,
				"notifications"		=> 		$notifications,
				"error" 			=> 		"The course link does not exist !",
				"createdRooms"		=> 		$createdRooms,
				"container"			=>		$container
			];
			if($session->get("lang") == "ar") {
				$data["error"] 	= "رابط الدورة غير موجود !";
				$container->get("View")->show("ar/teacher/createChatRoom", $data);
				exit;
			}
			return $container->get("View")->show("en/teacher/createChatRoom", $data);
		}

		if (!$this->courseBelongsToUser($collection, $session, $request->get("courseUrl"))) {
			$messages 		=		$helper->teacherMessages($collection, $session);
			$notifications	=		$helper->getNonSeenNotifications($collection, $session);
			$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
			$data 			= 		[
				"token" 			=> 		$this->token, 
				"user" 				=> 		$this->user, 
				"messages" 			=> 		$messages,
				"notifications"		=> 		$notifications,
				"error" 			=> 		"This course does not belong to you !",
				"createdRooms"		=> 		$createdRooms,
				"container"			=>		$container
			];
			if($session->get("lang") == "ar") {
				$data["error"]	=	"هذه الدورة ليست ملكك!";
				$container->get("View")->show("ar/teacher/createChatRoom", $data);
				exit;
			}
			$session->set("lang", "eng");
			return $container->get("View")->show("en/teacher/createChatRoom", $data);
		}
		
		if (!$this->courseHasChatRoom($collection, $request->get("courseUrl"))) {
			$messages 		=		$helper->teacherMessages($collection, $session);
			$notifications	=		$helper->getNonSeenNotifications($collection, $session);
			$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
			$data 			= 		[
				"token" 			=> 		$this->token, 
				"user" 				=> 		$this->user, 
				"messages" 			=> 		$messages,
				"notifications"		=> 		$notifications,
				"error" 			=> 		"This course already have a chat room !",
				"createdRooms"		=> 		$createdRooms,
				"container"			=>		$container
			];
			if($session->get("lang") == "ar") {
				$data["error"]	=	"لهذه الدورة غرفة دردشة مسبقا";
				$container->get("View")->show("ar/teacher/createChatRoom", $data);
				exit;
			}
			$session->set("lang", "eng");
			return $container->get("View")->show("en/teacher/createChatRoom", $data);
		}

		if (!$this->activated($collection, $request->get("courseUrl"))) {
			$messages 		=		$helper->teacherMessages($collection, $session);
			$notifications	=		$helper->getNonSeenNotifications($collection, $session);
			$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
			$data 			= 		[
				"token" 			=> 		$this->token, 
				"user" 				=> 		$this->user, 
				"messages" 			=> 		$messages,
				"notifications"		=> 		$notifications,
				"error" 			=> 		"This course is not activated yet",
				"createdRooms"		=> 		$createdRooms,
				"container"			=>		$container
			];
			if($session->get("lang") == "ar") {
				$data["error"] 	=	"هذه الدورة ليست مفعلة بعد";
				$container->get("View")->show("ar/teacher/createChatRoom", $data);
				exit;
			}
			$session->set("lang", "eng");
			return $container->get("View")->show("en/teacher/createChatRoom", $data);
		}

		$carbon 	= 		new Carbon\Carbon;
		$id 		=		md5(time());
		$courseId 	=		$this->getCourseId($collection, $request->get("courseUrl"));
		$collection->chatrooms->insertOne([
			"title" 		=> $request->get("title"), 
			"users" 		=> 0, 
			"created_at" 	=> $carbon->year."/".$carbon->month."/".$carbon->day, 
			"id" 			=> $id,
			"courseId"		=> $courseId,
			"created_by" 	=> $session->get("id")
		]);

		$url 			=		$container->get("View")->url("chat")."/".$id;
		$this->updateCourseChatRoomLink($collection, $request->get("courseUrl"), $url);
		$session 		=		$container->get("Session");
		$helper 		=	 	$container->get("Helper");
		$user 			=		$this->user;
		$messages 		=		$helper->teacherMessages($collection, $session);
		$notifications	=		$helper->getNonSeenNotifications($collection, $session);
		$createdRooms 	=		$helper->getCreatedChatdRooms($collection, $session);
		$data 			= 		[
			"token" 			=> 		$this->token, 
			"user" 				=> 		$this->user, 
			"messages" 			=> 		$messages,
			"notifications"		=> 		$notifications,
			"suc" 				=> 		"Chat room created successfully",
			"url"				=> 		$url,
			"createdRooms" 		=> 		$createdRooms,
			"container"			=>		$container
		];
		if($session->get("lang") == "ar") {
			$data["suc"]		=	"تم إنشاء الغرفة";
			$container->get("View")->show("ar/teacher/createChatRoom", $data);
			exit;
		}
		$session->set("lang", "eng");
		return $container->get("View")->show("en/teacher/createChatRoom", $data);
	}

	final public function uploadInvoices(array $params, object $container) {
		$collection 	= 		(new MongoDB\Client)->dzcourses;
		$session 		=		$container->get("Session");
		$user 			=		$collection->learners->findOne(["_id" =>  new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
		$data 			= 		[
			"user" 			=> 	$user,
			"container" 	=> 	$container
		];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/uploadInvoices", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/uploadInvoices", $data);
	}

	final public function postUploadedInvoices(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$request 		=	$container->get("Request");
		$password 		=	$request->get("password");
		$session 		=	$container->get("Session");
		$user 			=	$collection->learners->findOne(["_id" =>  new MongoDB\BSON\ObjectId($session->get("id"))]);
		if (password_verify($password, $user->password) == false) {
			$data 			= 		[
				"user" 		=> 	$user,
				"error"		=>	"Password wrong",
				"container"	=> $container
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/uploadInvoices", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/uploadInvoices", $data);
			exit;
		}
		$email 		= 	(empty($request->get("email"))) ? $user->email : $request->get("email");
		$firstname 	= 	(empty($request->get("firstname"))) ? $user->firstname : $request->get("firstname");
		$lastname 	= 	(empty($request->get("lastname"))) ? $user->lastname : $request->get("lastname");
		$address 	= 	(empty($request->get("address"))) ? $user->address : $request->get("address");
		$plan 		= 	(empty($request->get("plan"))) ? $user->plan : $request->get("plan");
		$phone 		= 	(empty($request->get("phone"))) ? $user->phone : $request->get("phone");

		if (empty($request->get("money"))) {
			$data 			= 		[
					"user" 		=> 	$user,
					"error"		=>	"Please type the sended money in money input !",
					"container"	=> 	$container
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/uploadInvoices", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/uploadInvoices", $data);
			exit;
		}
		$allows 	= 	["jpg", "jpeg", "png"];
		$helper 	=	$container->get("Helper");
		$bucket 	= 	$collection->selectGridFSBucket();

		$filesNames = [
			"image1" 	=> 		null,
			"image2" 	=> 		null,
			"image3" 	=> 		null,
			"id" 		=> 		null
		];

		foreach($_FILES as $key => $file) {
			if (!$helper->verfiyUploadFile($file["name"], $allows, $file["tmp_name"])) {
				$data 			= 		[
					"user" 		=> 	$user,
					"error"		=>	$file["name"]." not allowed in images",
					"container"	=> $container
				];
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/uploadInvoices", $data);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/uploadInvoices", $data);
				exit;
			}
			$filename 			= 	explode(".", $file["name"]);
			$filename 			= 	md5($filename[0]).".".$filename[1];
			$filesNames[$key] 	= 	$filename;
			$fileStream 		= 	fopen($file["tmp_name"], 'rb');
			$bucket->uploadFromStream($filename, $fileStream);
		}

		$date = new Carbon\Carbon;
		$collection->learners->updateOne(["_id" =>  new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))], 
			['$set' =>
				["activated" => 1, "plan" => 0, "guard" => null]
			]
		);

		$collection->learnerInvoices->insertOne([
			"userId" 		=> 		(string)$user->_id,
			"firstname" 	=> 		strip_tags($firstname),
			"lastname" 		=> 		strip_tags($lastname),
			"email" 		=> 		strip_tags($email),
			"address" 		=> 		strip_tags($address),
			"plan" 			=> 		strip_tags($plan),
			"phone" 		=> 		strip_tags($phone),
			"image1" 		=> 		$filesNames["image1"],
			"image2" 		=> 		$filesNames["image2"],
			"image3" 		=> 		$filesNames["image3"],
			"id" 			=> 		$filesNames["id"],
			"status" 		=> 		"Pending",
			"sended" 		=> 		strip_tags($request->get("money")),
			"subject"		=>		"Buy a learning plan",
			"created_at" 	=> 		$date::now()->format("Y-m-d"),
			"modified_at" 	=>		null
		]);
		$panelLink 		=	$container->get("View")->url("lPanel");

		if($session->get("lang") == "ar") {
			$data = [
				"user" 			=> 	$user,
				"suc" 			=>	"تم إرسال فواتيرك إلى الإدارة ، وستتلقى إشعارًا في <a href=".$panelLink.">لوحة تحكم حساب</a> عند تنشيط حسابك.",
				"container"		=> 	$container
			];
			$container->get("View")->show("ar/uploadInvoices", $data);
			exit;
		}
		$data 			= 		[
			"user" 		=> 		$user,
			"suc"		=>		"Great ! Your invoices has sended to the administration , you will get a notification in your <a href=".$panelLink.">panel</a> when your account activated.",
			"container"	=> 		$container
		];
		$session->set("lang", "eng");
		$container->get("View")->show("en/uploadInvoices", $data);
		exit;
	}

	final public function getInvoiceImage(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
	}

}