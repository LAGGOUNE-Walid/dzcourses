<?php

require "vendor/autoload.php";
require "src/bin/Classes/Token.php";
require "src/bin/Classes/ChatRoom.php";

$server     =   new swoole_websocket_server("0.0.0.0", 5785);
$chatRoom 	= 	new ChatRoom;

$server->on('open', function (swoole_websocket_server $server, $request) {
});

$server->on('message', function (swoole_websocket_server $server, $frame) use ($chatRoom){
	$data 		= 	json_decode($frame->data, true);
	$token 		= 	new Token;

	if ($data["type"] == "checkIdentity") {
		if ($registredToken = $token->ifUserExists($data["userId"]) AND $registredToken !== false) {
			if ($token->verifyToken($registredToken, $data["cryptedToken"])) {
				$chatRoom->acceptConnection($data["roomId"], $frame->fd);
				$chatRoom->pushMessage(["roomId" => $data["roomId"], "onlineUsers" => $chatRoom->getOnlineUsers($data["roomId"])], $server, $frame->fd);
	 		}else {
	 			// token do not match
	 			$server->close($frame->fd);
	 		}
	 	}else {
	 		// not registerd user
	 		$server->close($frame->fd);
	 	}
	 }

	 if ($data["type"] == "getInfo") {
	 	$onlineUsers 	=	$chatRoom->getOnlineUsers($data["roomId"]); 
	 	$server->push($frame->fd, json_encode(["onlineUsers" => $onlineUsers]));
	 }

	 if ($data["type"] == "message") {
	 	$chatRoom->pushMessage($data, $server, $frame->fd);
	 	$chatRoom->saveMessage($data, (new MongoDB\Client)->dzcourses->chatRoomMessages);
	 }


});

$server->on('close', function ($server, $fd) use ($chatRoom) {
	// online - 1
	$server->close($fd);
	$chatRoom->removeConnectionFromAcceptedConnections($fd, $server, $chatRoom);
});
echo "Starting server ... ";
$server->start();
