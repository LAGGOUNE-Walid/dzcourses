<?php 

final class User {

	public function __construct($collection) {
		$this->collection = $collection;
	}

	final public function saveMessage(array $data, $output) {
		if (empty($data["name"]) OR empty($data["email"]) OR empty($data["message"])) {
			$output->write("Not saving empty message ");
			$output->write("[-]", "red", null, false, true);
			return true;
		}
		$output->write("save message to database ... ");
		$this->collection->insertOne(["user_id" => $data["to"], "from" => strip_tags($data["name"]), "email" => strip_tags($data["email"]), "message" => strip_tags($data["message"]), "date" => $data["date"],"read" => 0]);
		$output->write("[+]", "green", null, false, true);
		return true;
	}

}