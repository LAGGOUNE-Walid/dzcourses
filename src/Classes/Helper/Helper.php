<?php 

namespace src\Classes\Helper;

final class Helper {

	public $filePath 	= null;
	protected $key 		= "QQAsRRIeoFO6XJbGp2af6MHStHmUsnJA3ME4fjFmyBwlbW18sWUsaUwex3y010FsrOwJtfRLlaZ73pTc+9J03I6DvK4TH3qXSiJvmk1cByJk+WUxZgxmFRElLdSFl2boFv4rffCAFhnyASPI8IzwEhYsfgzJ4uxFP6hXIQhe1xxWhGgE41tzZ4NcoEjgTObEKvLqaJNfZtrkdWJT8sG0gSTDN/0K5HhivQzVb4dsawbWmSB3MgKHCOY7Uq6fRd/7SShVPB/uh5OSEe5zXm/5ICjdOlzYpX4rHa+1Ie8Nxq+lBPs/DE1GUOo5beiXr60Ueh93fLDAIdKEtSy5xdledA==
	";
	protected $iv = "1LR0VkAzqfZjvZV+B7EbEw==";

	final public function verfiyUploadFile($file, $allows, $path = null) {
		if (method_exists($file, "size")) {
			if ($file->size() == 0) {
				return false;
			}
			$ext = $file->getExtension();
			if (in_array($ext, $allows)) {
				$handle 	= 	fopen($file->getTmp(), "r");
				$content 	= 	fread($handle, filesize($file->getTmp()));
				if (strpos($content, "exec") OR strpos($content, "shell_exec") OR strpos($content, "eval") OR substr($content, 0, strlen("<?")) === "<?" OR substr($content, 0, strlen("<?php")) === "<?php" OR substr($content, 0, strlen("<=")) === "<=") {
					return false;
				}else {
					return true;
				}
			}
		}else {
			if(!is_null($path)) {
				if(file_exists($path.$file) or file_exists($path."/".$file)) {
					if (filesize($path.$file) == 0) {
						return false;
					}
					$ext = $this->getExtension($file);
					if (in_array($ext, $allows)) {
						$handle 	= 	fopen($path.$file, "r");
						$content 	= 	fread($handle, filesize($path.$file));
						if (strchr($content, "exec") OR strchr($content, "shell_exec") OR strchr($content, "eval") OR substr($content, 0, strlen("<?php")) === "<?php") {
								return false;
							}else {
								return true;
							}
					}
					return false;
				}else {
					if (is_file($path)) {
						if (filesize($path) == 0) {
							return false;
						}
						$ext = $this->getExtension($file);
						if (in_array($ext, $allows)) {
							$handle 	= 	fopen($path, "r");
							$content 	= 	fread($handle, filesize($path));
							if (strchr($content, "exec") OR strchr($content, "shell_exec") OR strchr($content, "eval") OR substr($content, 0, strlen("<?php")) === "<?php") {
									return false;
								}else {
									return true;
								}
						}
						return false;
					}
					return false;
				}		
			}else {
				return false;
			}		

		}

	}

	final public function token(object $container) {
		return $container->get("Session")->token();
	}

	final public function uploadFile($data) {
		$filePath = "src/app/views/images/".md5($data->getName()).".".$data->getExtension();
		$this->filePath = $filePath;
		return move_uploaded_file($data->getTmp(), $filePath);
	}

	final public function userExists(array $data, object $collection) {
		return ($collection->findOne(["phone" => $data["phone"]]) OR $collection->findOne(["ccp" => $data["ccp"]])) ? true : false;
	}

	final public function learnerExists(array $data, object $collection) {
		return ($collection->findOne(["phone" => $data["phone"]]) OR $collection->findOne(["email" => $data["email"]])) ? true : false;
	}

	final public function saveUser(array $data, object $collection) {
		if($this->uploadFile($data["photo"])) {
			$data["photo"] = $this->filePath;
			if ($insertResult = $collection->insertOne($data)) {
				return $insertResult->getInsertedId();
			}
			return false;
		}
		return false;
	}

	final public function canLogin(string $email, string $phone, string $password, object $collection) {
		if ($data = $collection->findOne(["email" => $email, "phone" => $phone])) {
			if (password_verify($password, $data->password)) {
				return $data;
			}
			return false;
		}
		return false;
	}

	final public function updateUser(object $request, object $session, object $user, object $validator, object $container, object $collection, string $token) {

		$update 	= 	false;
		$role 		=	$user->role;
		if($role == "teacher") {
			if($session->get("lang") == "ar") {
				$page = "ar/teacher/teacherSettings";
			}else {
				$page = "en/teacher/teacherSettings";
			}
		} else {
			if($session->get("lang") == "ar") {
				$page = "ar/learner/learnerSettings";
			}else {
				$page = "en/learner/learnerSettings";
			}
		}
		$messages 		= 	$this->getNonSeenNotifications($collection, $session);
		$notifications 	= 	$this->getNonSeenNotifications($collection, $session);
		$data = [
			"notifications" => 		$messages,
			"messages" 		=> 		$notifications,
			"user" 			=> 		$user,  
			"token" 		=> 		$token,
			"container"		=>		$collection
		];

		if ($request->get("firstname") !== $user->firstname) {
			$validation 	= 	$validator->make($request, [
				"firstname" 	=> 	"required:true,cleanHtml:true,min:1,max:30,type:string", 
			]);
			if (sizeof($validation->errors) > 0) { 
				$data["errors"] = $validation->errors;
				return $container->get("View")->show($page, $data);
				exit;
			}
			if ($role == "teacher") {
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["firstname" => $request->get("firstname")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}elseif($role == "learner") {
				if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["firstname" => $request->get("firstname")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}

		}

		if ($request->get("lastname") !== $user->lastname) {
			$validation 	= 	$validator->make($request, [
				"lastname" 	=> 	"required:true,cleanHtml:true,min:1,max:30,type:string", 
			]);
			if (sizeof($validation->errors) > 0) {
				$data["errors"] = $validation->errors; 
				return $container->get("View")->show($page, $data);
				exit;
			}
			if ($role == "teacher") {
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["lastname" => $request->get("lastname")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}elseif($role == "learner") {
				if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["lastname" => $request->get("lastname")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}

		}

		if ($request->get("email") !== $user->email) {
			$validation 	= 	$validator->make($request, [
				"email" 		=> 	"required:true,cleanHtml:true,type:email",
			]);
			if (sizeof($validation->errors) > 0) {
				$data["errors"] = $validation->errors; 
				return $container->get("View")->show($page, $data);
				exit;
			}
			if ($role == "teacher") {
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["email" => $request->get("email")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}elseif($role == "learner") {
				if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["email" => $request->get("email")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}
		}

		if ($request->get("address") !== $user->address) {
			$validation 	= 	$validator->make($request, [
				"address" 		=> 	"required:true,cleanHtml:true,min:1,max:30",
			]);
			if (sizeof($validation->errors) > 0) { 
				$data["errors"] = $validation->errors;
				return $container->get("View")->show($page, $data);
				exit;
			}
			if ($role == "teacher") {
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["address" => $request->get("address")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}elseif($role == "learner") {
				if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["address" => $request->get("address")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}
		}
		if($role == "teacher") {
			if ($request->get("ccp") !== $user->ccp) {
				$validation 	= 	$validator->make($request, [
					"ccp" 			=> 	"required:true",
				]);
				if (sizeof($validation->errors) > 0) { 
					$data["errors"] = $validation->errors;
					return $container->get("View")->show($page, $data);
					exit;
				}
				if (!is_null($collection->users->findOne(["ccp" => $request->get("ccp")]))) {
					$data["errors"] = "There is a user with this CCP number";
					return $container->get("View")->show($page, $data);
					exit;
				}
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["ccp" => $request->get("ccp")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}
		}

		if ($request->get("phone") !== $user->phone) {
			$validation 	= 	$validator->make($request, [
				"phone" 		=> 	"required:true,cleanHtml:true,min:15,max:17",
			]);
			if (sizeof($validation->errors) > 0) { 
				$data["errors"] = $validation->errors;
				return $container->get("View")->show($page, $data);
				exit;
			}
			if($role == "teacher") {
				if (!is_null($collection->users->findOne(["phone" => $request->get("phone")]))) {
					$data["errors"] = ["our website" => "There is a user with this phone number "];
					return $container->get("View")->show($page, $data);
					exit;
				}
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["phone" => $request->get("phone")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}elseif($role == "learner") {
				if (!is_null($collection->learners->findOne(["phone" => $request->get("phone")]))) {
					$data["errors"] = ["our website" => "There is a user with this phone number"];
					return $container->get("View")->show($page, $data);
					exit;
				}
				if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["phone" => $request->get("phone")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}
		}

		if ($request->get("description") !== $user->description) {
			$validation			= 	$validator->make($request, [
				"description" 	=>  "required:true,cleanHtml:true,min:3,max:250",
			]);
			if (sizeof($validation->errors) > 0) { 
				$data["errors"] = $validation->errors;
				return $container->get("View")->show($page, $data);
				exit;
			}
			if ($role == "teacher") {
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["description" => $request->get("description")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}elseif($role == "learner") {
				if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["description" => $request->get("description")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}
		}
		if($role == "teacher"){
			if ($request->get("key") !== $user->key) {
				$validation			= 	$validator->make($request, [
					"key" 	=>  "required:true,cleanHtml:true",
				]);
				if (sizeof($validation->errors) > 0) { 
					$data["errors"] = $validation->errors;
					return $container->get("View")->show($page, $data);
					exit;
				}
				if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["key" => $request->get("key")]])->getModifiedCount() > 1) {
					$update = true;
				}
			}
		}

		if($request->get("password") !== "") {
			if (!password_verify($request->get("password"), $user->password)) {
				$validation 	= 	$validator->make($request, [
					"password" 		=> 	"required:true,cleanHtml:true,min:3,max:250",
				]);
				if (sizeof($validation->errors) > 0) { 
					$data["errors"] = $validation->errors;
					return $container->get("View")->show($page, $data);
					exit;
				}
				if($role == "teacher") {
					if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["password" => password_hash($request->get("password"), PASSWORD_BCRYPT, ["salt" => random_bytes(32)])]])->getModifiedCount() > 1) {
						$update = true;
					}
				}elseif($role == "learner") {
					if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["password" => password_hash($request->get("password"), PASSWORD_BCRYPT, ["salt" => random_bytes(32)])]])->getModifiedCount() > 1) {
						$update = true;
					}
				}
			}
		}

		if (!is_null($request->file("photo"))) {
			if($this->verfiyUploadFile($request->file("photo"), ["png", "jpg", "jpeg", "gif", "JPG", "JPEG", "PNG"])) {
				if ($this->uploadFile($request->file("photo"))) {
					if($role == "teacher") {
						if ($collection->users->updateOne(["_id" => ($user->_id)], ['$set' => ["photo" => $this->filePath]])->getModifiedCount() > 1) {
							$update = true;
						}
					}elseif($role == "learner") {
						if ($collection->learners->updateOne(["_id" => ($user->_id)], ['$set' => ["photo" => $this->filePath]])->getModifiedCount() > 1) {
							$update = true;
						}
					}
				}
			}
		}

		return $update;

	}

	final public function getMessages(object $collection, string $userId) {
		return $this->getMessagesFormPage($collection, 10, 0, $userId);
	}

	final public function getMessagesFormPage(object $collection, int $limit, int $skip, string $userId) {
		return ($collection->messages->count(["user_id" => $userId]) === 0) ? 0 : $collection->messages->find(["user_id" => $userId], ["sort" => ["_id" => -1], "limit" => $limit, "skip" => $skip]);
	}

	final public function getPages(object $collection, string $userId,int $limit) {
		$p = [];
		for ($i = 1; $i <= ceil($collection->count(["user_id" => $userId]) / $limit) ; $i++) {
			$p[$i] =  $i;
		}
		return ($p);
	}

	final public function getNotifications(object $collection, string $userId) {
		return $this->getNotificationsFormPage($collection, 10, 0, $userId);
	}

	final public function getNotificationsFormPage(object $collection, int $limit, int $skip, string $userId) {
		return ($collection->notifications->count(["to" => $userId]) === 0) ? 0 : $collection->notifications->find(["to" => $userId], ["sort" => ["_id" => -1], "limit" => $limit, "skip" => $skip]);
	}

	final public function getNotfPages(object $collection, string $userId,int $limit) {
		$p = [];
		for ($i = 1; $i <= ceil($collection->count(["to" => $userId]) / $limit) ; $i++) {
			$p[$i] =  $i;
		}
		return ($p);
	}


	final public function saveVisit(object $collection, string $userId, $date) {
		$date = $date::now();
		$find = $collection->visits->findOne(["user_id" => $userId]);
		if (is_null($find)) {
			$collection->visits->insertOne(["user_id" => $userId, "profileVisits" => 1, "coursesVisits" => 0, "coursesTakes" => 0, "created_at" => "$date->year/$date->month"]);
			return true;
		}
		
		if ($date->year > explode("/", $find->created_at)[0]) {
			$collection->visits->deleteOne(["user_id" => $userId]);
			$collection->visits->insertOne(["user_id" => $userId, "profileVisits" => 1, "coursesVisits" => 0, "coursesTakes" => 0, "created_at" => "$date->year/$date->month"]);
			return true;
		}

		$profileVists = $find->profileVisits + 1;

		$collection->visits->updateOne(["user_id" => $userId], ['$set' => ["profileVisits" => $profileVists]]);
		return true;
	}

	final public function r(object $container, string $to) {
		return header("Location: ".$container->get("View")->url($to));
		exit;
	}

	final public function scanFolder(string $path, array $allows) {
  		$dir = array_diff(scandir($path), array('.','..')); 
		foreach($dir as $file) {
			if(!$this->verfiyUploadFile($file, $allows, $path)) {
				return false;
			}
		}
		return true;
	}

	final public function extractAndVerify(object $file, string $name) {
		$beforeExtractSize = $file->size()/pow(1024, 2);
		if ($beforeExtractSize > 100) {
			return false;
		}
		$zip = new \Zipper\Classes\Zip;
		$zip->extract($file->getTmp())->to("src/app/views/files/".$name."/");

		$afterExtractSize = $this->getFolderSize("src/app/views/files/".$name."/");
		if ($afterExtractSize > 100) {
			return false;
		}

		return true;

	}

	final public function countVideos(string $path) {
		return (sizeof(array_diff(scandir($path), array('.','..'))) <= 2) ? false : true;
	}

	final public function writeToLog(string $routeName, string $message) {
		$file = "src/app/http/logs/".date("F j, Y").".txt";
		if (file_exists($file)) {
			$data = file_get_contents($file);
			$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Visited: ".$routeName.PHP_EOL.
            "     [IMPORTANT MESSAGE] ========> ".$message.PHP_EOL.
            "________________________________________________________________________".PHP_EOL;
			return file_put_contents($file, $log.$data);
		}
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Visited: ".$routeName.PHP_EOL.
            "     [IMPORTANT MESSAGE] ========> ".$message.PHP_EOL.
            "________________________________________________________________________".PHP_EOL;
		return file_put_contents($file, $log);
	}

	final public function deleteFolder(string $path) {
		$dir = array_diff(scandir($path), array('.','..')); 
		foreach($dir as $file) {
			if (is_dir($path."/".$file)) {
				$this->deleteFolder($path."/".$file);
			}else {
				unlink($path."/".$file);
			}
		}
		rmdir($path);
		return true;
	}

	final public function getFolderSize(string $path) {
		if(file_exists($path)) { 
			$dir = array_diff(scandir($path), array('.','..')); 
			$size = 0;
			foreach($dir as $file) {
				$s = filesize($path."/".$file);
				$size = $size + $s;
			}
			return $size/pow(1024, 2);
		}
		return 0;	
	}

	final public function getExtension($fileName) {
		$ex	= explode(".", $fileName);
		return end($ex);
	}
	
	final public function getMessagesForTeacher(object $container, array $params, $collection) {
		$perPage 		= 	10;
		$userId 		= 	$container->get("Session")->get("id");
		$count 			= 	$collection->messages->count(["user_id" => $userId, "read" => "0"]);
		$allMsgsCount 	= 	$collection->messages->count(["user_id" => $userId]);
		$collection->messages->updateMany(["user_id" => $userId, "read" => 0], ['$set' => ["read" => 1]]);

		if ($params["page"] > 1) {

			$params["page"] = (int) $params["page"];
			$find 			= 	$this->getMessagesFormPage($collection, $perPage, (($params["page"] > 1) ? ($params["page"] * $perPage) - $perPage : 0), $userId, "teacher");
			$container->get("View")->show("teacherMessages", ["pages" => $this->getPages($collection->messages, $container->get("Session")->get("id"), $perPage) ,"allMsgsCount" => $allMsgsCount, "messages" => $find, "count" => $count, "user" => $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId($userId)])]);
			return true;

		}else {

			$find 		= 	$container->get("Helper")->getMessages($collection, $userId, "teacher");
			$container->get("View")->show("teacherMessages", ["pages" => $this->getPages($collection->messages, $userId, $perPage) ,"allMsgsCount" => $allMsgsCount, "messages" => $find, "count" => $count, "user" => $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId($userId)])]);
			return true;

		}
	}

	final public function getMessagesForLearner(object $container, array $params, $collection) {
		$perPage 		= 	10;
		$userId 		= 	$container->get("Session")->get("id");
		$count 			= 	$collection->messages->count(["user_id" => $userId, "read" => "0"]);
		$allMsgsCount 	= 	$collection->messages->count(["user_id" => $userId]);
		$collection->messages->updateMany(["user_id" => $userId, "read" => 0], ['$set' => ["read" => 1]]);

		if ($params["page"] > 1) {
			$params["page"] = (int) $params["page"];
			$find 			= 	$this->getMessagesFormPage($collection, $perPage, (($params["page"] > 1) ? ($params["page"] * $perPage) - $perPage : 0), $userId, "learner");
			$container->get("View")->show("learnerMessages", ["pages" => $this->getPages($collection->messages, $container->get("Session")->get("id"), $perPage) ,"allMsgsCount" => $allMsgsCount, "messages" => $find, "count" => $count, "user" => $collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($userId)])]);
			return true;

		}else {

			$find 		= 	$container->get("Helper")->getMessages($collection, $userId, "learner");
			$container->get("View")->show("learnerMessages", ["pages" => $this->getPages($collection->messages, $userId, $perPage) ,"allMsgsCount" => $allMsgsCount, "messages" => $find, "count" => $count, "user" => $collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($userId)])]);
			return true;

		}
	}

	final public function getCourses($collection) {
		return $this->getCoursesFormPage($collection, 12, 0);
	}

	final public function getCoursesFormPage(object $collection, int $limit, int $skip) {
		return ($collection->courses->count(["activated" => 1]) === 0) ? 0 : $collection->courses->find(["activated" => 1], ["sort" => ["_id" => -1], "limit" => $limit, "skip" => $skip]);
	}

	final public function getCoursesPages(object $collection,int $limit) {
		$p = [];
		for ($i = 1; $i <= ceil($collection->courses->count(["activated" => 1]) / $limit) ; $i++) {
			$p[$i] =  $i;
		}
		return ($p);
	}

	final public function titleExists(string $title, object $collection) {
		return $collection->courses->findOne(["title" => $title]);
	}

	final public function calculateCourseTime(string $path) {
		$courseTime = 0;
		require_once('src/Classes/getid3/getid3.php');
		$getID3 = new \getID3;
		if(!is_dir($path)) {
			echo "Course folder don't exists ... [-]";
			exit;
		}
		$dir = array_diff(scandir($path), array('.','..')); 
		foreach($dir as $file) {
			$ThisFileInfo = $getID3->analyze($path.$file);
			\getid3_lib::CopyTagsToComments($ThisFileInfo);
			$courseTime = $courseTime + $ThisFileInfo["playtime_seconds"];
		}
		return $courseTime;
	}

	final public function courseExists(string $courseTitle, object $collection) {
		$course = $collection->courses->findOne(["title" => str_replace("-", " ", $courseTitle)]);
		return (is_null($course) ? false : $course);
	}

	final public function addCourseView(object $course, object $collection, object $date) {
		$userId 	= 	$course->user_id;
		$date 		= 	$date::now();
		$find 		= 	$collection->visits->findOne(["user_id" => $userId]);
		
		if (is_null($find)) {
			$collection->visits->insertOne(["user_id" => $userId, "profileVisits" => 0, "coursesVisits" => 1, "coursesTakes" => 0, "created_at" => "$date->year/$date->month"]);
			return true;
		}
		
		if ($date->year > explode("/", $find->created_at)[0]) {
			$collection->visits->deleteOne(["user_id" => $userId]);
			$collection->visits->insertOne(["user_id" => $userId, "profileVisits" => 0, "coursesVisits" => 1, "coursesTakes" => 0, "created_at" => "$date->year/$date->month"]);
			return true;
		}

		$coursesVisits = $find->coursesVisits + 1;

		$collection->visits->updateOne(["user_id" => $userId], ['$set' => ["coursesVisits" => $coursesVisits]]);
		return true;

	}

	final public function getTitles(string $path) {
		$files = scandir($path);
		unset($files[0]);
		unset($files[1]);
		ksort($files);
		$videosTitlesAndExtensions = [];
		foreach ($files as $key => $file) {
			$info = explode("-", $file);
			unset($info[0]);
			array_push($videosTitlesAndExtensions, implode(" ", $info));
		}
		$videosTitles = [];
		foreach($videosTitlesAndExtensions as $key => $title) {
			$title = explode(".", $title);
			unset($title[array_key_last($title)]);
			array_push($videosTitles, implode(" ", $title));
		}
		return $videosTitles;
	}

	final public function registerUserInCourse(object $container, object $collection, object $course, object $date) {
		$user_id = (string) $container->get("Session")->get("id");
		$course_id = (string) $course->_id;
		return $collection->registredUsersInCourses->insertOne(["course_id" => $course_id, "user_id" => $user_id, "created_at" => "$date->year/$date->month"]);
	}

	final public function theCourseOwner(object $collection, string $course_user_id, string $user_id) {
		return $course_user_id == $user_id;
	}

	final public function checkIfUserRegisterdInCourse(object $collection, string $course_id, string $user_id) {
		return !is_null($collection->registredUsersInCourses->findOne(["course_id" => $course_id , "user_id" => $user_id]));
	}

	final public function thisCourseBelongsToThisTeacher(object $collection, string $course_id, string $user_id) {
		return !is_null($collection->courses->findOne(["_id" =>  new \MongoDB\BSON\ObjectId($course_id) , "user_id" => $user_id]));
	}

	final public function checkUserPlan(object $container, object $collection) {
		$find = $collection->learners->findOne(["_id" =>  new \MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
		if ($find->plan == 0) {
			$session = $container->get("Session");
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/notActivated", ["data" => $find, "type" => null, "container" => $container]);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/notActivated", ["data" => $find, "type" => null, "container" => $container]);
				exit;
		}
		return true;
	}

	final public function editUserPlan(object $container, object $collection) {
		$plan = (int) $collection->learners->findOne(["_id" =>  new \MongoDB\BSON\ObjectId($container->get("Session")->get("id"))])->plan;
		if ($plan == 0) {
			return true;
		}
		if ($plan - 1 == 0) {
			$this->editLearnerGuard($collection, $container->get("Session")->get("id"));
		}
		return $collection->learners->updateOne(['_id' => new \MongoDB\BSON\ObjectId($container->get("Session")->get("id"))], ['$set' => ['plan' => $plan-1]]);

	}

	final public function editLearnerGuard(object $collection, string $id) {
		return $collection->learners->updateOne(["_id" => new \MongoDB\BSON\ObjectId($id)], ['$set' => ["guard" => null]]);
	}

	final public function addCourseTakes(object $course, object $collection, object $date) {
		$date 				= 	$date::now();
		$courseStatistics 	= 	$collection->coursesStatistics->findOne(["course_id" => (string) $course->_id]);
		if (is_null($courseStatistics)) {
			return $collection->coursesStatistics->insertOne(["course_id" => (string) $course->_id, "user_id" => $course->user_id,"takes" => 1, "created_at" => "$date->year/$date->month"]);
		}
		return $collection->coursesStatistics->updateOne(["course_id" => (string) $course->_id], ['$set' => ["takes" => $courseStatistics->takes + 1]]);
	}

	final public function getTotalCourseLearners(object $collection, string $courseId) {
		return (is_null($collection->coursesStatistics->findOne(["course_id" => $courseId]))) ? 0 : $collection->coursesStatistics->findOne(["course_id" => $courseId])->takes;
	}

	final public function addMoneyToTeacher(object $course , object $collection, object $date) {
		$moneyToTeacher 	= 	300;
		$teacherMonies 		= 	$collection->usersMoney->find(["user_id" => $course->user_id]);
		if ($teacherMonies->isDead()) {
			return $collection->usersMoney->insertOne([
				"user_id" 		=> 		$course->user_id , 
				"money" 		=> 		$moneyToTeacher, 
				"created_at" 	=> 		"$date->year/$date->month/$date->day",
				"paid" 			=> 		false
			]);
		}
		foreach ($teacherMonies as $teacherMoney) {
			$created_at			=	$teacherMoney->created_at;
			$created_at 		=	explode("/", $created_at);
			$created_month 		= 	$created_at[1];
			$created_day 		=	$created_at[2];
			if ($created_month == $date->month) {
				return $collection->usersMoney->updateOne([
					"user_id" => $course->user_id, 
					"created_at" => "$date->year/$date->month/$created_day"], 
					[
						'$set' => [
							"money" => $teacherMoney->money + $moneyToTeacher
						]
					]
				);
			}else {
				return $collection->usersMoney->insertOne([
					"user_id" 		=> 		$course->user_id , 
					"money" 		=> 		$moneyToTeacher, 
					"created_at" 	=> 		"$date->year/$date->month/$date->day",
					"paid" 			=> 		false
				]);
			}	
		}
	}

	final public function getVideoPath(string $path, $videoNumber) {
		$files = scandir($path);
		unset($files[0]);
		unset($files[1]);
		ksort($files);
		$videosPath 	=  [];
		if ($videoNumber >= 1 AND $videoNumber < 10) {
			$videoNumber = "0".$videoNumber;
		}
		foreach ($files as $key => $file) {
			$info = explode("-", $file);
			if ((int)$videoNumber === (int)$info[0]) {
				return $path.$file;
			}
		}
		return null;
	}

	final public function calculatePercentage($video, int $videosNumber, object $container, object $course, object $collection, object $date) {
		$percentage 		= 	$video / $videosNumber * 100;
		$userPercentage 	= 	$collection->coursesProgress->findOne(["user_id" => $container->get("Session")->get("id"), "course_id" => (string) $course->_id]);
		$date 				= 	$date::now();
		if(is_null($userPercentage)) {
			$collection->coursesProgress->insertOne(["user_id" => $container->get("Session")->get("id"), "course_id" => (string) $course->_id, "percentage" => $percentage, "created_at" => "$date->year/$date->month"]);
		}else {
			if($percentage > $userPercentage->percentage) {
				$updateResult = $collection->coursesProgress->updateOne(["user_id" => $container->get("Session")->get("id"), "course_id" => (string) $course->_id], ['$set' => ['percentage' => $percentage]]);
				$percentage = $percentage;
			}else {
				$percentage = $userPercentage->percentage;
			}
		}
		return (int)$percentage;
	}

	final public function getCompletedVideos(int $percentage, int $videosNumber) {
		return $percentage/100*$videosNumber;
	}

	final public function calculateTeacherMoney(object $collection, object $session, object $carbon) {
		$money 			= 	$collection->usersMoney->find(["user_id" => $session->get("id")]);
		$allMoney 		= 	$collection->usersMoney->find(["user_id" => $session->get("id")]);
		$sum 			=	 0;
		foreach ($allMoney as $user) {
			$sum = $sum + $user->money;
		}
		return $sum;
	}

	final public function calculateTeacherMoneyForThisYear(object $collection, object $session, object $carbon) {
		$moneyThisYear 	= 	[];
		$money 			= 	$collection->usersMoney->find(["user_id" => $session->get("id")]);
		foreach($money as $m) {
			$ex = explode("/", $m->created_at);
			$moneyDate = $carbon::create($ex[0], $ex[1]);
			if($carbon::now()->diffInMonths($moneyDate) <= 12) {
				array_push($moneyThisYear, $m);
			}
		}
		return $moneyThisYear;
	}

	final public function calculateCoursesTakes(object $collection, object $session, object $carbon) {
		$coursesStatistics 	= 	$collection->coursesStatistics->find(["user_id" => $session->get("id")]);
		$takes 				= 	0;

		foreach($coursesStatistics as $coursesStatistic) {
			$ex 						= 	explode("/", $coursesStatistic->created_at);
			$coursesStatisticDate 		= 	$carbon::create($ex[0], $ex[1]);
			if($carbon::now()->diffInMonths($coursesStatisticDate) <= 12) {
				$takes = $takes + $coursesStatistic->takes;
			}
		}
		return $takes;
	}

	final public function calculateVisits(object $collection, object $session, object $carbon) {
		$visits =  $collection->visits->findOne(["user_id" => $session->get("id")]);
		if(!is_null($visits)) {
			$ex 			= 	explode("/", $visits->created_at);
			$visitsDate		= 	$carbon::create($ex[0], $ex[1]);
			if($carbon::now()->diffInMonths($visitsDate) > 12) {
				$visits = null;
			}
		}else {
			$visits = null;
		}
		return $visits;
	}

	final public function getSomeComments(object $collection, object $session) {
		return $collection->comments->find(
			["teacher_id" 	=> $session->get("id")], 
			["limit" 		=> 4, 'sort' => ["created_at" => -1]]
		);
	}

	final public function user(object $collection, object $session) {
		if ($session->get("type") == "teacher") {
			return $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId($session->get("id"))]);
		}elseif($session->get("type") == "learner") {
			return $collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($session->get("id"))]);
		}
		
	}

	final public function teacherMessages(object $collection, object $session) {
		return $collection->messages->count(["user_id" => $session->get("id"), "read" => 0], ['sort' => ["date" => -1]]);
	}

	final public function getProfile(object $collection, string $id, string $type) {
		if($type === "teacher") {
			return $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId(@$id)]);
		}elseif($type === "learner"){ 
			return $collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId(@$id)]);
		}else {
			die("undefined profile type");
		}
	}

	final public function getUserFiles(object $collection, object $session) {
		return $collection->files->find(["user_id" => $session->get("id")], ["sort" => ['created_at' => -1]]);
	}

	final public function getHighRatedCourseInThisMonth(object $collection, object $date) {
		return $collection->coursesRates->aggregate(
			[
				['$match' => [
					"created_at" => "$date->year/$date->month"
					]
				], 
				['$group' => 
					["_id" => 
					'$course_id',"total" => 
						['$sum' => '$rate']
					]
				],
				['$limit' => 1]
			]
			);
	}

	final public function pushJoinCourseNotification(object $container, object $collection, object $course, object $date) {
		$view 			=	$container->get("View");
		$session 		= 	$container->get("Session");
		$learner 		=	$collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($session->get("id"))]);
		$userLink 		=	$view->url("p")."/".$session->get("id");
		$courseLink		=	$view->url("course")."/".str_replace(' ', '-', $course->title);

		return $collection->notifications->insertOne([
			"from" 				=> 	$container->get("Session")->get("id"),
			"to"				=>	$course->user_id,
			"notification" 		=> 	"<a href='".$userLink."'>".$learner->firstname." ".$learner->lastname.",<a/> joined your course: <a href='".$courseLink."'>".$course->title."</a>",
			"seen"				=>	0,
			"created_at" 		=>	$date->year."/".$date->month."/".$date->day
		]);
	}
	final public function pushCommentsNotification(object $container, object $collection, object $course, object $date) {
		$view 			=	$container->get("View");
		$session 		= 	$container->get("Session");
		$learner 		=	$collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($session->get("id"))]);
		if (is_null($learner)) {
			$learner = $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId($session->get("id"))]);
		}
		$userLink 		=	$view->url("p")."/".$session->get("id");
		$courseLink		=	$view->url("course")."/".str_replace(' ', '-', $course->title);

		return $collection->notifications->insertOne([
			"from" 				=> 	$container->get("Session")->get("id"),
			"to"				=>	$course->user_id,
			"notification" 		=> 	"<a href='".$userLink."'>".$learner->firstname." ".$learner->lastname.",<a/> commented in your course: <a href='".$courseLink."'>".$course->title."</a>",
			"seen"				=>	0,
			"created_at" 		=>	$date->year."/".$date->month."/".$date->day
		]);
	}

	final public function pushRateNotification(object $container, object $collection, object $course, object $date, int $rate) {
		$view 			=	$container->get("View");
		$session 		= 	$container->get("Session");
		$learner 		=	$collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($session->get("id"))]);
		$userLink 		=	$view->url("p")."/".$session->get("id");
		$courseLink		=	$view->url("course")."/".str_replace(' ', '-', $course->title);

		return $collection->notifications->insertOne([
			"from" 				=> 	$container->get("Session")->get("id"),
			"to"				=>	$course->user_id,
			"notification" 		=> 	"<a href='".$userLink."'>".$learner->firstname." ".$learner->lastname.",<a/> rated your course: <a href='".$courseLink."'>".$course->title."</a> with : ".$rate."/10",
			"seen"				=>	0,
			"created_at" 		=>	$date->year."/".$date->month."/".$date->day
		]);
	}

	final public function pushNewInvoiceNotification(object $collection, object $container, object $date, string $to) {
		$view 			=	$container->get("View");
		$panelLink 		=	$view->url("tPanel");
		return $collection->notifications->insertOne([
			"from" 				=> 	null,
			"to"				=>	$to,
			"notification" 		=> 	"<strong>Congratulation !</strong> Dz-courses sended your profits of this month to your CCP account , go and see <a href=".$panelLink.">invoices table</a> for more inforrmations .",
			"seen"				=>	0,
			"created_at" 		=>	$date->year."/".$date->month."/".$date->day
		]);
	}

	final public function getNonSeenNotifications(object $collection, object $session) {
		return $collection->notifications->count(["seen" => 0 , "to" => $session->get('id')]);
	}

	final public function getCreatedChatdRooms(object $collection, object $session) {
		return $collection->chatrooms->find(["created_by" => $session->get("id")], ["sort" => ["created_at" => -1]]);
	}

	final public function roomExists(string $id, object $collection) {
		$room = $collection->chatrooms->findOne(["id" =>  $id]);
		return (is_null($room)) ? false : $room;
	}

	final public function getChatRoomAdmin(object $collection, string $id) {
		return $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId($id)]);
	}

	final public function createUserTokenForChatRoom() {
		return uniqid();
	}

	final public function cryptToken(string $token) {
		return openssl_encrypt($token, "aes-256-cbc", $this->key, 0, base64_decode($this->iv));
	}

	final public function saveTokenToDisk(string $token, string $userId) {
		$tokens = json_decode(file_get_contents("src/bin/chatRoomsTokens/tokens.json"), TRUE);
		$tokens[$userId] = $token;
		return file_put_contents("src/bin/chatRoomsTokens/tokens.json", json_encode($tokens));
	}

	final public function countAllTeacher(object $collection) {
		return $collection->users->count();
	}

	final public function getAllTeachers(object $collection) {
		return $collection->users->find();
	}

	final public function countAllLearners(object $collection) {
		return $collection->learners->count();
	}

	final public function getAllLearners(object $collection) {
		return $collection->learners->find();
	}

	final public function countNewLearnersInvoices(object $collection) {
		return $collection->learnerInvoices->count(["status" => "Pending"]);
	}

	final public function countLearnersInvoices(object $collection) {
		return $collection->learnerInvoices->count(["status" => "Done"]);
	}

	final public function getNewSubmitedLearnersPayments(object $collection) {
		return $collection->learnerInvoices->find(["status" => "Pending"]);
	}

	final public function getSubmitedLearnersPayments(object $collection) {
		return $collection->learnerInvoices->find(["status" => "Done"], ['sort' => ["created_at" => -1]]);
	}

	final public function updateUserPlan(object $collection, string $userId, int $plan) {
		$currentPlan 	=	(int)$collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($userId)])->plan;	
		$guard 			= 	null;
		if ($currentPlan + $plan == 1) {
			$guard = "Basic";
		}elseif ($currentPlan + $plan == 2) {
			$guard = "Plus";
			// save to cobones
			$find = $collection->cobones->findOne(["user_id" => $userId]);
			if (is_null($find) or method_exists($find, "isDead") AND $find->isDead()) {
				$collection->cobones->insertOne([
					"user_id" 	=> 	$userId,
					"sended"	=>	false
				]);
			}
		}elseif ($currentPlan + $plan >= 3) {
			$guard = "Pro";
			$find = $collection->cobones->findOne(["user_id" => $userId]);
			if (is_null($find) or method_exists($find, "isDead") AND $find->isDead()) {
				$collection->cobones->insertOne([
					"user_id" 	=> 	$userId,
					"sended"	=>	false
				]);
			}
		}
		$updateResult 	= 	$collection->learners->updateOne(
		    ['_id' => new \MongoDB\BSON\ObjectId($userId)],
		    ['$set' => ['plan' => $currentPlan + $plan, 'guard' => $guard]]
		);
		return ($updateResult->getModifiedCount() > 0) ? true : false;
	}

	final public function changeInvoiceStatus(object $collection, string $invoiceId) {
		$date = new \Carbon\Carbon;
		$updateResult = $collection->learnerInvoices->updateOne(
		    ['_id' => new \MongoDB\BSON\ObjectId($invoiceId)],
		    ['$set' => [
		    	'status' 		=> 	"Done",
		    	"modified_at" 	=>	$date->year."/".$date->month."/".$date->day." ".$date->hour.":".$date->minute
		    ]]
		);
		return ($updateResult->getModifiedCount() > 0) ? true : false;
	}

	final public function pushAcceptedInvoiceNotification(object $collection, string $userId) {
		$date 		= 	new \Carbon\Carbon;
		$user 		= 	$collection->learners->findOne(["_id" => new \MongoDB\BSON\ObjectId($userId)]);
		$guard 		=	$user->guard;
		$plan 		=	$user->plan;	
		$collection->notifications->insertOne([
			"from" 				=> 	null,
			"to"				=>	$userId,
			"notification" 		=> 	"Congratulation, your plan has been updated to <strong>$guard with $plan courses</strong>! you can start taking courses",
			"seen"				=>	0,
			"created_at" 		=>	$date->year."/".$date->month."/".$date->day." ".$date->hour.":".$date->minute
		]);
		return true;
	}

	final public function getTeacherInvoices(object $collection, object $session) {
		return $collection->teachersInvoices->find(["to" => $session->get("id")], ["sort" => ["_id" => -1]]);
	}

	final public function deleteNonActivatedLearnersAccounts(object $collection) {
		$nonActivatedLearners 	=	$collection->learners->find(["activated" => 0]);
		$date 					= 	new \Carbon\Carbon;
		$now 					=	$date::now();
		foreach ($nonActivatedLearners as $learner) {
			if($now->diffInHours($learner->created_at) > 168) {
				$collection->learners->deleteOne(["_id" => $learner->_id]);
			}
		}
	}
}
