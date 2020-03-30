<?php 

class VerifyTokenMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {
		return $container->get("Session")->verifyToken();
	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}