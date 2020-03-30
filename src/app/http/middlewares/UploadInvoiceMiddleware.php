<?php 

class UploadInvoiceMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {
		$session 		= 	$container->get("Session");
		$collection		= 	(new MongoDB\Client)->dzcourses;
		$user			=	$collection->learners->findOne(["_id" => new MongoDB\BSON\ObjectId($session->get("id"))]);
		if ($user->activated == 1 AND (int)$user->plan > 0) {
			die("Please wait until your plan ends");
		}
	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}