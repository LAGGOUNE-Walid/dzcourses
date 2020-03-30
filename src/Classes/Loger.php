<?php 

namespace src\Classes;
ini_set('memory_limit', '-1');
class Loger {

	public function log($routeName) {
		$file = "src/app/http/logs/".date("F j, Y").".txt";
		if (file_exists($file)) {
			$data = file_get_contents($file);
			$log  = "User: ".$this->getIp().' - '.date("F j, Y, g:i a").PHP_EOL.
	            "Visited: ".$routeName.PHP_EOL.
	           "________________________________________________________________________".PHP_EOL;
			return file_put_contents($file, $log.$data);
		}
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Visited: ".$routeName.PHP_EOL.
           "________________________________________________________________________".PHP_EOL;
		return file_put_contents($file, $log);
		
	}

	public function getIp() {
			if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //ip pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}

}