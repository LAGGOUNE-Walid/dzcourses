<?php 

final class Message {

	public $file = null;
	public $output = null;

	public function __construct(string $file, $output) {
		$this->output = $output;
		$collection = (new MongoDB\Client)->dzcourses->users;
		$this->file = $file;
		if(!file_exists($file)) {
			$output->write("File not exists [-]", "red", null, false, true);
			exit;
		}
	}

	final public function write(int $fd, string $userId) {
		if(is_null($this->file)) {
			$this->output->write("Variable file cant be empty [-]", "green", null, false, true);
			exit;
		}
		$data 		= 	$this->openFile($this->file);
		$data[] 	= 	["userId" => $userId, "fd" => $fd];
		return file_put_contents($this->file, json_encode($data));
	}

	final public function openFile(string $file) {
		return json_decode(file_get_contents($file), true);
	}

	final public function remove(int $fd) {
		$data = $this->openFile($this->file);
		foreach($data as $arrayKey => $array) {
			if((array_search($fd, $array))) {
				unset($data[$arrayKey]);
				return file_put_contents($this->file, json_encode($data));
			}
		}
	}

	final public function push($server, array $data, $output) {
		if (empty($data["name"]) OR empty($data["email"]) OR empty($data["message"])) {
			$this->output->write("Not sending empty message ");
			$this->output->write("[-]", "red", null, false, true);
			return true;
		}
		$json = $this->openFile($this->file);
		foreach ($json as $users) {
			if (array_search($data["to"], $users)) {
				$this->output->write("sending to ".$users["fd"]." (".$data["to"].") ".$data["message"]." from ".$data["name"]."/".$data["email"]." ");
				$server->push($users["fd"], json_encode($data));
				$this->output->write("[+]", "green", null, false, true);
			}
		}
	}

}