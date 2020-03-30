<?php 

class ActivatedMiddleware {

	public function before($container, $baseUrl, $httpMethod, $params) {
		if ($container->get("Session")->has("id") === true) {
			$id = $container->get("Session")->get("id");
		}else {
			$id = $params["id"];
		}
		$find = (new MongoDB\Client)->dzcourses->learners->findOne(["_id" => new MongoDB\BSON\ObjectId($id)]);
		if (!is_null($find)) {
			if($find->activated == "0") {
				$session = $container->get("Session");
				if($session->get("lang") == "ar") {
					$container->get("View")->show("ar/notActivated", ["data" => $find, "type" => null, "container" => $container]);
					exit;
				}
				$session->set("lang", "eng");
				$container->get("View")->show("en/notActivated", ["data" => $find, "type" => null, "container" => $container]);
				exit;			
			}
		}else {
			http_response_code(404);
			$container->get("View")->show("errors/404");
			exit();
		}
		return true;
	}

	public function after($container, $baseUrl, $httpMethod, $params) {
		// do something after the application
	}

}