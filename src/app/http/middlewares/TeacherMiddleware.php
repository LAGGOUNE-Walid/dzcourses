<?php 

class TeacherMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {

		return ($container->get("Session")->has("type")) ? ($container->get("Session")->get("type") === "teacher") ? true : die($container->get("View")->show("en/roleError", ["error" => "You are logged in as learner , try to login as teacher ."])) : false;

	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}