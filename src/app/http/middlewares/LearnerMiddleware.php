<?php 

class LearnerMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {

		return ($container->get("Session")->has("type")) ? ($container->get("Session")->get("type") === "learner") ? true : die($container->get("View")->show("en/roleError", ["error" => "You are logged in as teacher , try to login as learner ."])) : false;

	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}