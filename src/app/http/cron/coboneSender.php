<?php

require "vendor/autoload.php";
use Carbon\Carbon;
use src\app\http\Controllers\Container;


$collection 	= 	(new MongoDB\Client)->dzcourses;
$results 		=	$collection->cobones->aggregate([
	['$sample' => ["size" => 1]]
]);
// fetch the user id 
$user_id 		=	null;
foreach($results as $result) {
	$user_id = $result->user_id;
}

if (is_null($user_id)) {
	exit;
}
// when new learner sign up with plan > 1 , check if he exists in this table before you ad dit
$code 			=	 md5(uniqid());
$collection->cobonesCodes->insertOne(["code" => $code]);
$date 			=	new Carbon;
$container 		=	new Container;
$collection->notifications->insertOne([
	"from" 				=> 	null,
	"to"				=>	$user_id,
	"notification" 		=> 	"<strong>You have received a cobone , {$code} .</strong>",
	"code"				=>	$code,
	"seen"				=>	0,
	"created_at" 		=>	$date->year."/".$date->month."/".$date->day
]);

$collection->cobones->deleteOne(["user_id" => $user_id]);
