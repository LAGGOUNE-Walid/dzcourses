<?php 

class ChatRoom {

	public function acceptConnection(string $roomId, int $fd) {
		$acceptedConnections = json_decode(file_get_contents("src/bin/chatRoomsTokens/acceptedConnections.json"), true);
		if (!array_key_exists($roomId, $acceptedConnections)) {
			$acceptedConnections[$roomId] = [];
		}
		array_push($acceptedConnections[$roomId], $fd);
		return file_put_contents("src/bin/chatRoomsTokens/acceptedConnections.json", json_encode($acceptedConnections));
	}

	public function removeConnectionFromAcceptedConnections(int $fd, object $server) {
		$acceptedConnections = json_decode(file_get_contents("src/bin/chatRoomsTokens/acceptedConnections.json"), true);
		foreach ($acceptedConnections as $key => $ids) {
			foreach ($ids as $key2 => $id) {
				if ($id == $fd) {
					unset($acceptedConnections[$key][$key2]);
					file_put_contents("src/bin/chatRoomsTokens/acceptedConnections.json", json_encode($acceptedConnections));
					$this->pushMessage(["roomId" => $key, "onlineUsers" => $this->getOnlineUsers($key)], $server, $fd);
				}
			}
		}
	}

	public function getOnlineUsers(string $roomId) {
		$acceptedConnections = json_decode(file_get_contents("src/bin/chatRoomsTokens/acceptedConnections.json"), true);
		if (!array_key_exists($roomId, $acceptedConnections)) {
			return 0;
		}
		return count($acceptedConnections[$roomId]);
	}

	public function addOnlineUserForChatRoom(string $roomId, int $fd) {
		$acceptedConnections = json_decode(file_get_contents("src/bin/chatRoomsTokens/onlineUsers.json"), true);
		if (!array_key_exists($roomId, $acceptedConnections)) {
			$acceptedConnections[$roomId] = 1;
		}else {
			$acceptedConnections[$roomId] = $acceptedConnections[$roomId] + 1;
		}
		return file_put_contents("src/bin/chatRoomsTokens/onlineUsers.json", json_encode($acceptedConnections));
	}

	public function saveMessage(array $data, object $collection) {
		return $collection->insertOne([
			"roomId" 		=>		$data["roomId"],
			"userId" 		=> 		$data["userId"],
			"firstname"	 	=> 		$data["firstname"],
			"lastname" 		=> 		$data["lastname"],
			"message"		=> 		$data["message"],
			"image" 		=> 		$data["image"]	
		]);
	}

	public function pushMessage(array $data, object $server, int $fd) {
		$acceptedConnections = json_decode(file_get_contents("src/bin/chatRoomsTokens/acceptedConnections.json"), true);
		foreach ($acceptedConnections as $savedRoomId => $users) {
			if ($savedRoomId === $data["roomId"]) {
				foreach($users as $user) {
					if($user !== $fd) {
						$server->push($user, json_encode($data));
					}
				}
			}
		}
	}
}