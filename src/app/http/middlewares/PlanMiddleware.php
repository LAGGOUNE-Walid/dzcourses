<?php 

class PlanMiddleware  {

	public function before($container, $baseUrl, $httpMethod, $params) {
		/**
		$find = (new MongoDB\Client)->dzcourses->learners->findOne(["_id" => new MongoDB\BSON\ObjectId($container->get("Session")->get("id"))]);
		if($find->plan == 0) {
			$container->get("View")->show("notActivated", ["data" => $find, "type" => null]);
			exit;	
		}
		//*
	}

	public function after($container, $baseUrl, $httpMethod, $params) {

	}

}