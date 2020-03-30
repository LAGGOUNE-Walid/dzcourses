<?php 

use src\app\http\Controllers\CourseController as CourseController;

final class HomeController {

	use CourseController;

	protected $token;

	public function __construct() {
		$container 		= 	new src\app\http\Controllers\Container;
		$this->token 	= 	$container->get("Helper")->token($container);
	}

	final public function home(array $params, object $container) {
		$collection						= 	(new MongoDB\Client)->dzcourses;
		$courses 						= 	$this->getCourses($collection);
		$date							= 	new Carbon\Carbon;
		$helper 						=	$container->get("Helper");
		$session 						=	$container->get("Session");
		$highRatedCourseInThisMonth		=	$helper->getHighRatedCourseInThisMonth($collection, $date);
		foreach ($highRatedCourseInThisMonth as $c) {
			$highRatedCourseInThisMonth = $collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($c["_id"])]);
		}
		$data 	= [
			"container" 					=> 		$container, 
			"courses" 						=> 		$courses, 
			"collection"					=> 		$collection, 
			"highRatedCourseInThisMonth"	=> 		$highRatedCourseInThisMonth
		];
           
		if($session->get("lang") == "eng") {
			$container->get("View")->show("en/index", $data);
			exit;
		}
		$session->set("lang", "ar");
		$container->get("View")->show("ar/index", $data);
	}

	final public function terms(array $params, object $container) {
		$session 	=	$container->get("Session");
		$data = ["container" => $container];
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/terms", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/terms", $data);
	}

	final public function getFile(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$file 			=	$collection->files->findOne(["_id" => new MongoDB\BSON\ObjectId($params["id"])]);
		if (is_null($file)) {
			return $container->get("View")->show("errors/404");
			exit;
		}
		if(!file_exists($file->path)) {
			return $container->get("View")->show("errors/404");
			exit;
		}
		$uploadedBy 	= 	$collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($file->user_id)]);
		$filename 		= 	explode("/", $file->path);
		$data = [
			"user" 			=> 		$uploadedBy->firstname." ".$uploadedBy->lastname,
			"filename" 		=> 		$filename[4],
			"size"			=> 		round(filesize($file->path)/pow(1024, 2)),
			"downloads" 	=> 		$file->downloads,
			"id"			=> 		$params["id"],
			"created_at"	=> 		$file->created_at
		];
		return $container->get("View")->show("en/file", ["data" => $data]);
	}

	final public function fetchFile(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$file 			=	$collection->files->findOne(["_id" => new MongoDB\BSON\ObjectId($params["id"])]);
		if (is_null($file)) {
			return $container->get("View")->show("errors/404");
			exit;
		}
		if(!file_exists($file->path)) {
			return $container->get("View")->show("errors/404");
			exit;
		}
		$zip 			= 	new \Zipper\Classes\Zip;
		$location 		= 	$file->path;
		$contentType 	=	mime_content_type($location);
		header('Content-Description: File Transfer');
        header('Content-Type: '.$contentType);
        header('Content-Disposition: attachment; filename="'.$params["id"].'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($location));
        readfile($location);
        $collection->files->updateOne(["_id" => new MongoDB\BSON\ObjectId($params["id"])], ['$set' => ["downloads" => $file->downloads + 1]]);
        
	}

	final public function showCourses(array $params, object $container) {
		$perPage 		= 	12;
		$params["page"] = 	(int) $params["page"];
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$courses 		= 	$this->getAllCourses($collection, $container, $params, $perPage);
		if (is_null($courses)) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$currentPage 	= 	$params["page"];
		$data 			=	 [
			"currentPage"	=> 		(int) $currentPage,
			"courses" 		=> 		$courses, 
			"container" 	=> 		$container, 
			"collection"	 => 	$collection, 
			"pages" 		=> 		$container->get("Helper")->getCoursesPages($collection, $perPage),
			"courseController"	=> $this
		];
		$session = $container->get("Session");
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/courses", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/courses", $data); 
	}

	final public function showCoursesApi(array $params, object $container) {
		header('Content-Type: application/json');
		echo json_encode((new MongoDB\Client)->dzcourses->courses->find(["activated" => 1])->toArray());
	}

	final public function showCourse(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		strip_tags($params["title"]);
		$helper 		=	$container->get("Helper");	
		if (!$helper->courseExists($params["title"], $collection)) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$session 				=	$container->get("Session");
		$course 				= 	$helper->courseExists($params["title"], $collection);
		if($course->activated == 1) {
			$courseTakes 			= 	$helper->getTotalCourseLearners($collection, (string) $course->_id);
			$rate 					=	$this->getCourseRate((string)$course->_id, $collection);
			$courseTime				=	$course->courseTime;
			$helper->addCourseView($course, $collection, new Carbon\Carbon);

			$data 					=	[
				"rate" 			=>		 $rate ,
				"course" 		=> 		$course, 
				"courseTime" 	=> 		$courseTime,
				"collection" 	=>	 	$collection, 
				"container" 	=> 		$container, 
				"courseTakes" 	=> 		$courseTakes
			];
			if($session->get("lang") == "ar") {
				$container->get("View")->show("ar/course", $data);
				exit;
			}
			$session->set("lang", "eng");
			$container->get("View")->show("en/course", $data); 
			exit;
		}
		http_response_code(404);
		$container->get("View")->show("errors/404");
		exit();
	}

	final public function watch(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		= 	$container->get("Helper");
		$session 		=	$container->get("Session");
		strip_tags($params["title"]);
		strip_tags($params["video"]);
		$params["video"] = (int)$params["video"];
		if ($params["video"] == 0) {
			$params["video"] = 1;
		}
		$course 		= 	$helper->courseExists($params["title"], $collection);
		if (!$course) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		if ($params["video"] >= 3) {
			if(!$helper->theCourseOwner($collection, (string)$course->user_id, (string) $session->get("id"))) {
				if(!$helper->checkIfUserRegisterdInCourse($collection, (string)$course->_id, (string) $session->get("id"))) {
					if (!$helper->checkUserPlan($container, $collection)) {
						exit;
					}else {
						$helper->addMoneyToTeacher($course, $collection, new Carbon\Carbon);
						$helper->registerUserInCourse($container, $collection, $course, new Carbon\Carbon);
						$helper->editUserPlan($container, $collection);
						$helper->pushJoinCourseNotification($container, $collection, $course, new Carbon\Carbon);
						$helper->addCourseTakes($course, $collection, new Carbon\Carbon);
					}
				}
			}	
			$showFiles 		= 	true;
			$showChatRoom 	= 	true;
		}else {
			$showFiles 		= 	false;
			$showChatRoom 	= 	false;
		}
		
		if($params["video"] > $course->videosNumber) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$params["video"] 	= 	(int)round($params["video"]);
		$bucket 			= 	$collection->selectGridFSBucket();
		$video 				= 	$collection->coursesVideos->findOne(["course_id" => (string)$course->_id, "number" => $params["video"]]);
		$videoName 			=	explode("/", $video->origin);
		$videoName 			=	$videoName[1];
		$otherVideos 		=	$collection->coursesVideos->find(["course_id" => (string)$course->_id]);
		$videosNumber		=	$course->videosNumber;
		$percentage 		=	$helper->calculatePercentage($params["video"], $videosNumber, $container, $course, $collection, new Carbon\Carbon);
		$completedVideos 	= 	$helper->getCompletedVideos($percentage, $videosNumber);
		$comments 			=	$collection->comments->find(["course_id" => (string)$course->_id], ['sort' => ["_id" => -1]]);

		$getCertificate 	= 	false;
		if ($percentage == 100) {
			$getCertificate = true;
		}

		$data 				=	[
				"video"				=> 		$video,
				"videoName"			=>		$videoName,
				"comments" 			=> 		$comments, 
				"token" 			=> 		$this->token,
				"attachedFiles" 	=> 		$course->filesLink ,
				"showFiles" 		=> 		$showFiles, 
				"showChatRoom" 		=> 		$showChatRoom,
				"chatRoomLink" 		=>		$course->chatRoomLink,
				"session" 			=>  	$container->get("Session"), 
				"course_id" 		=> 		(string)$course->_id,
				"completedVideos" 	=> 		$completedVideos, 
				"percentage" 		=> 		$percentage, 
				"container"		 	=> 		$container, 
				"otherVideos" 		=> 		$otherVideos, 
				"title" 			=> 		$course->title, 
				"page" 				=> 		(int)$params["video"] , 
				"collection" 		=> 		$collection,
				"getCertificate"	=>		$getCertificate,
				"container"			=>		$container
		];	
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/courseBord", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/courseBord", $data);
	}

final public function watchFree(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		= 	$container->get("Helper");
		$session 		=	$container->get("Session");
		strip_tags($params["title"]);
		strip_tags($params["video"]);
		$params["video"] = (int)$params["video"];
		if ($params["video"] == 0) {
			$params["video"] = 1;
		}
		$course 		= 	$helper->courseExists($params["title"], $collection);
		if (!$course) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$showFiles 		= 	false;
		$showChatRoom 	= 	false;
		$canComment 	= 	false;
		
		if($params["video"] > $course->videosNumber) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$params["video"] 	= 	(int)round($params["video"]);
		$video 				= 	$collection->coursesVideos->findOne(["course_id" => (string)$course->_id, "number" => $params["video"]]);
		$videoName 			=	explode("/", $video->origin);
		$videoName 			=	$videoName[1];
		$otherVideos 		=	$collection->coursesVideos->find(["course_id" => (string)$course->_id]);
		$videosNumber		=	$course->videosNumber;
		$percentage 		=	null;
		$completedVideos 	= 	null;
		$comments 			=	$collection->comments->find(["course_id" => (string)$course->_id], ['sort' => ["_id" => -1]]);

		$getCertificate 	= 	false;

		// set sssion for watch free 2 videos
		$session 		=	$container->get("Session"); 

		$data 				=	[
				"video"				=> 		$video,
				"videoName"			=>		$videoName,
				"comments" 			=> 		$comments, 
				"canComment"		=>		$canComment,
				"token" 			=> 		$this->token,
				"attachedFiles" 	=> 		$course->filesLink ,
				"showFiles" 		=> 		$showFiles, 
				"showChatRoom" 		=> 		$showChatRoom,
				"chatRoomLink" 		=>		$course->chatRoomLink,
				"session" 			=>  	$session, 
				"course_id" 		=> 		(string)$course->_id,
				"completedVideos" 	=> 		$completedVideos, 
				"percentage" 		=> 		$percentage, 
				"container"		 	=> 		$container, 
				"otherVideos" 		=> 		$otherVideos, 
				"title" 			=> 		$course->title, 
				"page" 				=> 		(int)$params["video"] , 
				"collection" 		=> 		$collection,
				"getCertificate"	=>		$getCertificate,
				"container"			=>		$container
		];	
		if($session->get("lang") == "ar") {
			$container->get("View")->show("ar/courseBord", $data);
			exit;
		}
		$session->set("lang", "eng");
		$container->get("View")->show("en/courseBord", $data);
	}

	final public function displayVideo(array $params, object $container) {
		$folder 		= 	$params["folder"];
		$videoMd5 		=	$params["video"];
		$reading 		=	250000;
		if (is_dir("src/app/views/courses/$folder")) {
			$collection 	= 	(new MongoDB\Client)->dzcourses;
			$video 			=	$collection->coursesVideos->findOne(["md5" => $folder."/".$videoMd5]);
			if (!is_null($video)) {
				#ini_set("memory_limit", "-1");
				#ini_set("output_buffering", "3221225472");
				#set_time_limit(0);
				$newVideoMd5 	=	md5($videoMd5.time());
			    $updateResult = $collection->coursesVideos->updateOne(["md5" => $folder."/".$videoMd5], ['$set' => ["md5" => $folder."/".$newVideoMd5]]);
			    if($updateResult->getModifiedCount()) {
					$view 			=	$container->get("View");
					header("Location: ".$view->url("src/app/views/courses/").$video->origin);
				}
				exit;
			}else {
				header("Content-Type: text/html");
				echo "Video do not exsits";
				exit;
			}

		}else {
			header("Content-Type: text/html");
			echo "course not exsits";
			exit;
		}

	}

	final public function rate(array $params, object $container) {
		if(strlen($params["id"]) !== 24) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$course 		=	$collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($params["id"])]);
		$helper 		=	$container->get("Helper");
		if (is_null($course) OR method_exists($course, "isDead") AND $course->isDead()) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		if($container->get("Session")->has("loggedIn") AND $container->get("Session")->get("type") !== "admin") {
			$hasRated 		= 	$this->hasRated((string)$course->_id, $container->get("Session")->get("id"), $collection);
		}else {
			$hasRated 		= 	true;
		}
		$courseRates						= 	$collection->coursesRates->find(["course_id" => (string)$course->_id]);
		$checkIfUserRegisterdInCourse 		= 	$helper->checkIfUserRegisterdInCourse($collection, (string)$course->_id, (string) $container->get("Session")->get("id"));
		$thisCourseBelongsToThisTeacher 	= 	$helper->thisCourseBelongsToThisTeacher($collection, (string)$course->_id, (string)$container->get("Session")->get("id"));

		$data			=	[
			"checkIfUserRegisterdInCourse" 		=> 		$checkIfUserRegisterdInCourse,
			"thisCourseBelongsToThisTeacher"	=> 		$thisCourseBelongsToThisTeacher,
			"hasRated" 							=> 		$hasRated,
			"course" 							=> 		$course, 
			"courseRates" 						=> 		$courseRates, 
			"token" 							=> 		$this->token, 
			'session' 							=> 		$container->get("Session")
		];
		return $container->get("View")->show("en/courseRate", $data);
	}

	final public function postRate(array $params, object $container) {
		
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$request 		= 	$container->get("Request");
		$course_id		=	$request->get("course_id");
		$user_id 		=	$request->get("user_id");
		$validator 		= 	$container->get("ValidatorFactory");
		$helper 		=	$container->get("Helper"); 
		$course 		=	$collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($course_id)]);
		$helper 		=	$container->get("Helper");

		if (is_null($course)) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}

		$checkIfUserRegisterdInCourse 		= 	$helper->checkIfUserRegisterdInCourse($collection, (string)$course->_id, (string) $container->get("Session")->get("id"));
		$thisCourseBelongsToThisTeacher 	= 	$helper->thisCourseBelongsToThisTeacher($collection, (string)$course->_id, (string)$container->get("Session")->get("id"));

		if (!$this->hasRated($course_id, $user_id, $collection) AND !$thisCourseBelongsToThisTeacher AND $checkIfUserRegisterdInCourse) {
			$validation 	= 	$validator->make($request, [
				"rate" 	=> 	"required:true,cleanHtml:true,type:int", 
			]);
			if (sizeof($validation->errors) > 0) { 
				$hasRated 		= 	$this->hasRated((string)$course->_id, $container->get("Session")->get("id"), $collection);
				$courseRates	= 	$collection->coursesRates->find(["course_id" => (string)$course->_id]);
				$data 			=	[
					"errors" 		=> 		"The value of rate must be a number", 
					"hasRated" 		=> 		$hasRated,	
					"course" 		=> 		$course , 
					"courseRates" 	=> 		$courseRates, 
					"token" 		=> 		$this->token, 
					'session' 		=> 		$container->get("Session")
				];
				return $container->get("View")->show("en/courseRate", $data);
				exit;
			}
			if ($request->get("rate") > 10 OR $request->get("rate") < 0) {
				$hasRated 		= 	$this->hasRated((string)$course->_id, $container->get("Session")->get("id"), $collection);
				$courseRates	= 	$collection->coursesRates->find(["course_id" => (string)$course->_id]);
				$data 			=	[
					"errors" 		=> 	"The value of rate must be > 0 AND < 10", 
					"hasRated" 		=> 	$hasRated,
					"course" 		=> 	$course , 
					"courseRates" 	=> 	$courseRates, 
					"token"	 		=> 	$this->token, 
					'session' 		=> 	$container->get("Session")
				];
			 	return $container->get("View")->show("en/courseRate", $data);
			 	exit;
			 } 
			$date = new Carbon\Carbon;
			$collection->coursesRates->insertOne(
					[
						"course_id" => $course_id, 
						"user_id" => $user_id, 
						"rate" => (int)$request->get("rate"), 
						"created_at" => "$date->year/$date->month"
					]
			);
			$hasRated 		= 	$this->hasRated((string)$course->_id, $container->get("Session")->get("id"), $collection);
			$courseRates	= 	$collection->coursesRates->find(["course_id" => (string)$course->_id]);
			$data 			=	[
				"suc" 			=> 		"Thank you for your feedback", 
				"hasRated"		=> 		$hasRated,
				"course" 		=> 		$course , 
				"courseRates" 	=> 		$courseRates, 
				"token" 		=> 		$this->token, 
				'session' 		=> 		$container->get("Session")
			];
			$container->get("View")->show("en/courseRate", $data);
			$helper->pushRateNotification($container, $collection, $course, new Carbon\Carbon, (int)$request->get("rate"));
			return true;
			exit;
		}
		$data = [
			"errors" 		=> "You can't rate twice", 
			"hasRated" 		=> 		$hasRated,
			"course"	 	=> 		$course , 
			"courseRates" 	=>	 	$courseRates, 
			"token" 		=> 		$this->token, 
			'session' 		=> 		$container->get("Session")
		];
		return $container->get("View")->show("en/courseRate", $data);
		exit;

	}

	final public function postComment(array $params, object $container) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$request 		= 	$container->get("Request");
		$course_id		=	$request->get("course_id");
		if (strlen($course_id) !== 24 OR !ctype_xdigit($course_id)) {
			return $container->get("View")->show("errors/404");
			exit;
		}
		$user_id 		=	$request->get("user_id");
		$validator 		= 	$container->get("ValidatorFactory"); 
		$helper 		= 	$container->get("Helper");
		$course 		=	$collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($course_id)]);
		if (is_null($course)) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$validation = $validator->make($request, [
			"comment" => "required:true,cleanHtml:true,min:0", 
		]);
		if (sizeof($validation->errors)== 0) {
			$carbon = new Carbon\Carbon;
			$date = (string)$carbon::now();
			$collection->comments->insertOne(
				[
					"course_id" 	=> 		$course_id, 
					"teacher_id" 	=> 		$course->user_id, 
					"user_id" 		=> 		$user_id, 
					"comment" 		=> 		$request->get("comment"), 
					"created_at" 	=> 		$date
				]
			);
			$helper->pushCommentsNotification($container, $collection, $course, new Carbon\Carbon, (int)$request->get("rate"));
		}
		return header("Location: ".$request->info()["Referer"]);
	}	

	final public function showChatRoom(array $params, object $container) {
		strip_tags($params["id"]);
		$helper 		=	$container->get("Helper");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$id 			=	$params["id"];
		if($room = $helper->roomExists($id, $collection) AND $room !== false) {
			if($helper->checkIfUserRegisterdInCourse($collection, (string)$room->courseId, (string) $container->get("Session")->get("id")) OR $helper->thisCourseBelongsToThisTeacher($collection, (string)$room->courseId, (string)$container->get("Session")->get("id"))) {
				$createdBy 		= 	$helper->getChatRoomAdmin($collection, (string)$room->created_by);
				$token 			= 	$helper->createUserTokenForChatRoom();
				$cryptedToken  	= 	$helper->cryptToken($token);
				if ($helper->saveTokenToDisk($token, $container->get("Session")->get("id")) !== FALSE) {
					$user 		= 	$collection->learners->findOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
					if (is_null($user) OR method_exists($user, "is_dead") AND $user->isDead()) {
						$user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
					}
					$messages 	= 	$collection->chatRoomMessages->find(["roomId" => $id]);
					// get the messages from db
					$data = [
						"createdBy" 		=> 	$createdBy,
						"roomName" 			=>	$room->title,
						"userId"			=>	$container->get("Session")->get("id"),
						"roomId"			=> 	$params["id"],
						"user" 				=>	$user,
						"cryptedToken"		=>	$cryptedToken,
						"messages"			=> 	$messages		
					];
					return $container->get("View")->show("en/chatroom", $data);
					exit;
				}else {
					echo "Error when saving crypted token , please try again or report this page .";
					exit;
				}
			}else {
				return $container->get("View")->show("errors/404");
				exit;
			}
		}
		return $container->get("View")->show("errors/404");
		exit;
	}

	final public function getImage(array $params, object $container) {
		ob_start();
		header("Content-Type: image/jpg");
		header("Content-Transfer-Encoding:binary");
		header("Content-Disposition:inline");
		header("Cache-Control:no-cache");
		header("Accept-Ranges:bytes");
		$collection 		=		(new MongoDB\Client)->dzcourses;
		$filename 			=		$params["imageName"];
		$f = "fs.files";
		$bucket 			= 		$collection->selectGridFSBucket();
		$length  				= 	$collection->$f->findOne(["filename" => $filename])->length;
		header("Content-Length:$length");
		$stream 			= 		$bucket->openDownloadStreamByName($filename);
		$contents 			= 		stream_get_contents($stream);
		echo($contents);
		ob_end_flush();
		flush();
		exit;
	}

	final public function cobone(array $params, object $container) {
		return $container->get("View")->show("en/cobone");
	}

	final public function postCobone(array $params, object $container) {
		$request 			= 		$container->get("Request");
		$cobone 			=		trim($request->get("cobone"));
		$collection 		=		(new MongoDB\Client)->dzcourses;
		$find 				=		$collection->cobonesCodes->findOne(["code" => $cobone]);
		if (is_null($find) OR method_exists($find, "isDead") AND $find->isDead()) {
			return $container->get("View")->show("en/cobone", ["error" => "Please try again, the cobone you inserted does not exists !"]);
		}
		$collection->cobonesCodes->deleteOne(["code" => $cobone]);
		$container->get("Helper")->updateUserPlan($collection, $container->get("Session")->get("id"), 1);
		$container->get("Helper")->pushAcceptedInvoiceNotification($collection, $container->get("Session")->get("id"));
		$container->get("Helper")->r($container, "lPanel");
	}

	final public function generateCertificate(array $params, object $container) {
		$request 		=	$container->get("Request");
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$helper 		=	$container->get("Helper");
		$session 		=	$container->get("Session");

		$course 		=	$collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($request->get("course_id"))]);

		if (is_null($course) OR method_exists($course, "isDead") AND $course->isDead()) {
			die("Course not exists");
		}

		$checkIfUserRegisterdInCourse 		= 	$helper->checkIfUserRegisterdInCourse($collection, (string)$course->_id, (string) $session->get("id"));

		if (!$checkIfUserRegisterdInCourse) {
			die("you are not registerd in this course !");
		}

		$certificate 	=	$collection->certificates->findOne(["user_id" => (string) $session->get("id")]);
		$user 			=	$collection->learners->findOne(["_id" => new MongoDB\BSON\ObjectId((string)$session->get("id"))]);
		if($user->guard !== "Pro") {
			die("Your plan is not Pro");
		}
		if (is_null($certificate) OR method_exists($certificate, "isDead") AND $certificate->isDead()) {
			$date 		=	new Carbon\Carbon;
			$insert 	= $collection->certificates->insertOne([
				"firstname" 	=> 	$user->firstname,
				"lastname"		=>	$user->lastname,
				"user_id"		=> 	(string)$session->get("id"),
				"courseTitle"	=>	$course->title,
				"courseTime"	=>	$course->courseTime,
				"created_at" 	=>	$date->year."/".$date->month."/".$date->day
			]);
			$helper->r($container, "certificates/".(string)$insert->getInsertedId());
			exit;
		}
		$helper->r($container, "certificates/".(string)$certificate->_id);
	}

	final public function getCertificate(array $params, object $container) {
		if(strlen($params["id"]) !== 24) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		$certificateId 	=	(string)$params["id"];
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		$certificate 	= 	$collection->certificates->findOne(["_id" => new MongoDB\BSON\ObjectId($certificateId)]);
		if (is_null($certificate) OR method_exists($certificate, "isDead") AND $certificate->isDead()) {
			http_response_code(404);
			return $container->get("View")->show("errors/404");
			exit;
		}
		return $container->get("View")->show("en/certificate", ["certificate" => $certificate, "user_id" => $container->get("Session")->get("id")]);
	}

}
