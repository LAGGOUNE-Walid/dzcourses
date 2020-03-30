<?php

require "vendor/autoload.php";
use Carbon\Carbon;
use src\app\http\Controllers\Container;


$collection 	= 	(new MongoDB\Client)->dzcourses;
$n 				=	$collection->cobones->count();
if ($n !== 0) {
	find:
		$r 				=	random_int(0, $n);
		$user 			=	$collection->cobones->findOne([], ['limit' => 1, 'skip' => $r]);
		if (is_null($user)) {
			goto find;
		}
		$user_id 		= 	$user->user_id;
		$code 			=	 trim(md5(uniqid()));
		$collection->cobonesCodes->insertOne(["code" => $code]);
		$date 			=	new Carbon;
		$container 		=	new Container;
		$collection->notifications->insertOne([
			"from" 				=> 	null,
			"to"				=>	$user_id,
			"notification" 		=> 	"<strong>Congratulation! You have received a cobone code {$code}</strong>",
			"code"				=>	$code,
			"seen"				=>	0,
			"created_at" 		=>	$date->year."/".$date->month."/".$date->day
		]);
		$collection->cobones->deleteOne(["user_id" => $user_id]);
}
