<?php 

class CourseOwnerMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {
		$collection 	= 	(new MongoDB\Client)->dzcourses;
		if (isset($params["folder"]) AND isset($params["video"])) {
			$course 	=	$collection->coursesVideos->findOne(["md5" => $params["folder"]."/".$params["video"]]);
			if (is_null($course)) {
				return false;
			}
			$course 	=	$collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($course->course_id)]);
			if (is_null($course)) {
				return false;
			}
			return ($container->get("Session")->get("type") == "teacher" AND $container->get("Session")->get("id") == $course->user_id);
			exit;
		}
		$request		=	$container->get("Request");
		if (isset($params["course"])) {
			str_replace(" ", "-", $params["course"]);
			$params["title"] = $params["course"];
		}
		if (!is_null($request->get("course_id"))) {
			$course 	=	$collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($request->get("course_id"))]);
			return ($container->get("Session")->get("type") == "teacher" AND $container->get("Session")->get("id") == $course->user_id);
		}
		$helper 		= 	$container->get("Helper");
		$course 		= 	$helper->courseExists($params["title"], $collection);
		if (!$course) {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}else {
			return ($container->get("Session")->get("type") == "teacher" AND $container->get("Session")->get("id") == $course->user_id);
		}
	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}