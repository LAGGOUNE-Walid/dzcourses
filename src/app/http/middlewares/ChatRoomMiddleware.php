<?php 

class ChatRoomMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {
		if(!$container->get("Session")->has("loggedIn")) {
			$container->get("Helper")->r($container, "learnerLogin");
			exit;
		}
		if ($container->get("Session")->get("type") == "learner") {
			$container->get("Middleware")
						->run("BEFORE", "ActivatedMiddleware", $baseUrl, $httpMethod, $params, $container);
		}
		return true;
	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}