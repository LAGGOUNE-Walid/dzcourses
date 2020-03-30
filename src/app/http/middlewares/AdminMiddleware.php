<?php 

class AdminMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {
		$session = $container->get("Session");
		if ($session->get("loggedIn")) {
			if ($session->get("type") == "admin") {
				return true;
			}
			$container->get("Helper")->r($container, "adminLogin");
			exit;
		}
		$container->get("Helper")->r($container, "adminLogin");
		exit;
	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}