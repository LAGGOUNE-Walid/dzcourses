<?php 

namespace src\app\http\Controllers;
use \Zipper\Classes\Zip;
ini_set('memory_limit', '-1');

trait CourseController {

	public function verifyDate($container, $user, $carbon) {
		$ex 			= 	explode("-", $user->activated_at);
		if(is_null(@$ex[1]) OR is_null(@$ex[2])) {
			return false;
		}
		$userActivated 	= 	$carbon::create($ex[0], $ex[1], $ex[2]);
		return ($carbon::now()->diffInDays($userActivated) > 31) ? false : true;
	}

	public function verifyPlan($container, $user, $collection, $carbon) {
		$coursesCount 		= 	$collection->count(["user_id" => $container->get("Session")->get("id")]);
		$countedCourses 	= 	0;
		if ($coursesCount > 0) {
			foreach($collection->find(["user_id" => $container->get("Session")->get("id")]) as $course) {
				$ex = explode("-", $course->created_at);
				$courseDate = $carbon::create($ex[0], $ex[1], $ex[2]);
				if (!($carbon::now()->diffInDays($courseDate) > 31)) {
					$countedCourses++;
					if ($countedCourses >= $user->plan) {
						return false;
					}
				}
			}
			return true;
		}
		return true;
	}

	public function verifyInputs($container, $collection) {

		$request 		= 	$container->get("Request");
		$helper 		= 	$container->get("Helper");
		$session 		=	$container->get("Session");
		$notifications	=	$helper->getNonSeenNotifications($collection, $session);
		$validator 		= 	$container->get("ValidatorFactory"); 
		$validation 	= 	$validator->make($request, [
			"title" 			=> 	"required:true,cleanHtml:true,min:3,max:50", 
			"description" 		=> 	"required:true,cleanHtml:true,min:10,max:12000", 
			"skillsToGain" 		=> 	"required:true,cleanHtml:true,min:1,max:12000", 
			"skillsNeeded" 		=> 	"required:true,cleanHtml:true,min:1,max:12000", 
			"videosNumber" 		=> 	"required:true,cleanHtml:true,type:int", 
			"tags" 				=> 	"required:true,cleanHtml:true,min:1,max:300",
			"category" 			=> 	"required:true,cleanHtml:true",
		]);
		$validated = true;
		if (sizeof($validation->errors) > 0) {
			$validated = false;
			echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
				foreach ($validation->errors as  $input => $error) {
	                   echo $error." in ".$input."<br/>";
				}
			echo " </div>";
		}
		if (!is_null($helper->titleExists($request->get("title"), $collection))) {
			$validated = false;
			echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
				echo "Title already exists ! <br/>";
			echo "</div>";
		}

		$photo 		= 	$request->file("cover");
		if (!$helper->verfiyUploadFile($photo, ["png", "jpg", "jpeg", "gif"])) {
			$validated = false;
			echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
				echo "Cover can't be uploaded , allowed mimes is png,jpg,jepg,gif <br/>";
			echo "</div>";
		}

		$folder 		= 	$request->file("coursesFile");

		if (is_null($folder)) {
			$validated = false;
			echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
				echo "Course file size can't be null.";
			echo "</div>";
		}else {
			if (!$helper->verfiyUploadFile($folder, ["zip", "ZIP"])) {
				$validated = false;
				echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
					echo "Course file can't be uploaded , allowed mimes is zip";
				echo "</div>";
				goto errorCheck;
			}
			$folderName 		= 	md5($folder->getName().time());
			$beforeExtractSize 	= 	$folder->size()/pow(1024, 2);

			if ($beforeExtractSize > 2500) {
				$validated = false;
				echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
					echo "Course file Allowed to upload less than 2.5GB";
				echo "</div>";
			}

			$zip = new Zip;
			$zip->extract($folder->getTmp())->to("src/app/views/courses/".$folderName."/");

			$afterExtractSize = $container->get("Helper")->getFolderSize("src/app/views/courses/".$folderName);
			if ($afterExtractSize > 2500) {
				$validated = false;
				echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
					echo "Course videos Allowed to upload less than 2.5GB";
				echo "</div>";
			}
			
			if($helper->scanFolder("src/app/views/courses/".$folderName."/", ["mp4", "webm"]) === false) {
				$validated = false;

				$helper->writeToLog("/postCourse", "This user uploaded malicious files ! ");
				$helper->deleteFolder("src/app/views/courses/".$folderName);

				echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
					echo "ZIP file contains malicious files , can't be uploaded to our servers . ";
				echo "</div>";
				goto errorCheck;
			}

			if($helper->countVideos("src/app/views/courses/".$folderName."/") === false) {
				$validated = false;
				$helper->deleteFolder("src/app/views/courses/".$folderName);

				echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
					echo "Course folder Must contain at least 3 vidoes .";
				echo "</div>";
			}
		}
		$photo 			= 	$request->file("cover");
		if (is_null($photo)) {
			$validated = false;
			echo '<br/><div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">';
				echo "Course cover size can't be null.";
			echo "</div>";
		}	
		errorCheck:
		if ($validated == false) {
			exit;
		}
		/**
		$bucket 		= 	$collection->selectGridFSBucket();
		$folderPath 	= 	"src/app/views/courses/".$folderName."/";
		$dir 			= 	array_diff(scandir($folderPath), array('.','..'));
		$videNumber 	= 	1;
		foreach($dir as $file) {
			$fileStream = fopen($folderPath.$file, 'rb');
			$bucket->uploadFromStream($request->get("title")."/".$file."/".$videNumber, $fileStream);
			$videNumber++;
		}
		$helper->deleteFolder("src/app/views/courses/".$folderName);
		**/
		$folderPath 	= 	"src/app/views/courses/".$folderName."/";
		$videosNumber 	= 	sizeof(array_diff(scandir("src/app/views/courses/".$folderName."/"), array('.','..')));
		$courseTime 	= 	$helper->calculateCourseTime("src/app/views/courses/".$folderName."/");

		
		$coverPath 		= 	"src/app/views/images/".md5($photo->getName()).".".$photo->getExtension();
		move_uploaded_file($photo->getTmp(), $coverPath);

		$folder 		= 	$request->file("coursesFile");
		$date 			= 	new \Carbon\Carbon;
		if (empty($request->get("filesLink")) OR is_null($request->get("filesLink"))) {
			$filesLink = null;
		}else {
			$filesLink = $request->get("filesLink");
		}

		$data = [
			"user_id" 		=> 		$container->get("Session")->get("id"), 
			"title" 		=> 		$request->get("title"),
			"description" 	=> 		$request->get("description"),
			"skillsNeeded" 	=> 		$request->get("skillsNeeded"),
			"skillsToGain" 	=> 		$request->get("skillsToGain"),
			"videosNumber" 	=> 		$videosNumber,
			"tags" 			=> 		$request->get("tags"),
			"category" 		=> 		$request->get("category"),
			"cover" 		=> 		$coverPath,
			"created_at" 	=> 		$date::now()->format("Y-m-d"),
			"chatRoomLink"	=>		"",
			"activated" 	=> 		0,
			"courseTime" 	=>		$courseTime,
			"filesLink"		=>		$filesLink,
			"notifications"	=>		$notifications,
			"folder"		=> 		$folderPath
		];
		return $data;

	}

	public function saveCourse(array $data, $collection) {
		$insertResults =  $collection->courses->insertOne($data);
		if($this->saveCourseVideos($collection, $data["folder"], (string)$insertResults->getInsertedId())) {
			return $insertResults;
		}
		return false;
		// get the course id 
		// insert every video with a hash
		// courseFolder/488951246.mp4 => courseFolder/first.mp4
		// 324kj1l3/2131231.mp4 => 324kj1l3/first.mp4
	}

	public function saveCourseVideos(object $collection, string $folder, string $courseId) {
		$files 			= 	array_diff(scandir($folder), array('.','..')); 
		$folder 		=	explode("/", $folder);
		$folderMd5 		=	$folder[4];
		$videoNumber 	=	1;
		foreach($files as $file) {
			$insertResults = $collection->coursesVideos->insertOne([
				"course_id" 	=> 	$courseId,
				"md5"			=>	$folderMd5."/".md5($file.time()),
				"origin"		=>	$folderMd5."/".$file,
				"number"		=>	$videoNumber
			]);
			$videoNumber++;
		}
		return $insertResults;
	}

	public function getUserCourses($collection, $container) {
		return $collection->courses->count(["user_id" => $container->get("Session")->get("id")]);
	}

	public function getCourses($collection) {
		return $collection->courses->find(["activated" => 1], ["sort" => ["_id" => -1], "limit" => 3]);
	}

	public function getAllTeacherCourses(object $collection, object $session) {
		return $collection->courses->find(["user_id" => $session->get("id")], ["sort" => ["_id" => -1]]);
	}

	public function getAllCourses($collection, $container, $params, $perPage) {
		if ($params["page"] > 1) {
			$find 			= 	$container->get("Helper")->getCoursesFormPage($collection, $perPage, (($params["page"] > 1) ? ($params["page"] * $perPage) - $perPage : 0));
			return $find;
		}else {
			$find 		= 	$container->get("Helper")->getCourses($collection);
			return $find;
		}
	}

	public function hasRated(string $course_id, string $user_id, object $collection) {
		return !is_null($collection->coursesRates->findOne(["user_id" => $user_id, "course_id" => $course_id]));
	}

	public function getCourseRate(string $course_id, object $collection) {
		$courseRates 	= 	$collection->coursesRates->find(["course_id" => $course_id]);
		if (($courseRates)->isDead()) {
			return 0;
		}
		$times 	= 	0;
		$rates 	= 	0;
		foreach ($courseRates as $courseRate) {
			$times++;
			$rates 	= 	$courseRate->rate + $rates;
		}
		return $rates/$times;
	}

	public function ifThisCourseExists(string $url, object $collection, object $helper) {
		$url 		= 	explode("/", $url);
		$title 		= 	$url[sizeof($url)-1];
		if ($helper->courseExists($title, $collection)) {
			return true;
		}
		return false;
	}

	public function courseBelongsToUser(object $collection, object $session, string $url) {
		$url 		= 	explode("/", $url);
		$title 		= 	$url[sizeof($url)-1];
		$course 	=	$collection->courses->findOne(["title" => str_replace("-", " ", $title)]);
		if ($course->user_id == $session->get("id")) {
			return true;
		}
		return false;
	}

	public function courseHasChatRoom(object $collection, string $url) {
		$url 		= 	explode("/", $url);
		$title 		= 	$url[sizeof($url)-1];
		$course 	=	$collection->courses->findOne(["title" => str_replace("-", " ", $title)]);
		if (empty($course->chatRoomLink)) {
			return true;
		}
		return false;
	}

	public function updateCourseChatRoomLink(object $collection, string $url, string $chatUrl){
		$url 		= 	explode("/", $url);
		$title 		= 	$url[sizeof($url)-1];

		return $collection->courses->updateOne(
			["title" => str_replace("-", " ", $title)],
			['$set' => ["chatRoomLink" => $chatUrl]]
		);
	}


	final public function getCourseId(object $collection, string $url) {
		$url 		= 	explode("/", $url);
		$title 		= 	$url[sizeof($url)-1];
		$course 	=	$collection->courses->findOne(["title" => str_replace("-", " ", $title)]);
		return (string)$course->_id;
	}

	final public function activated(object $collection, string $url) {
		$url 		= 	explode("/", $url);
		$title 		= 	$url[sizeof($url)-1];
		$course 	=	$collection->courses->findOne(["title" => str_replace("-", " ", $title)]);
		return ($course->activated == 1) ? true : false;
	}

	final public function getNoActivated(object $collection) {
		return $collection->courses->find(["activated" => 0]);
	}

	final public function countNoActivated(object $collection) {
		return $collection->courses->count(["activated" => 0]);
	}

	final public function countActivated(object $collection) {
		return $collection->courses->count(["activated" => 1]);
	}
}
