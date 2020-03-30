<?php 
require "vendor/autoload.php";
use Console\Output\Classes\Output as Output;

require "src/bin/Classes/Message.php";
require "src/bin/Classes/User.php";
$output     =   new Output;
$server     =   new swoole_websocket_server("0.0.0.0", 5784);
$message    =   new Message("src/bin/MessagesClients.json", $output);
$user       =   new User((new MongoDB\Client)->dzcourses->messages);

$GLOBALS['clients'] = 0;
$server->on('open', function (swoole_websocket_server $server, $request) use ($output) {
    $output->write("Open new connection fd{$request->fd} ... ");
    $GLOBALS["clients"] = $GLOBALS["clients"]+1;
    $output->write("[+]", "green", null, false, true);
});

$server->on('message', function (swoole_websocket_server $server, $frame) use ($message, $user ,$output) {
    $data = json_decode($frame->data, true);

    if ($data["type"] === "MessageClient") {
        echo "Rgister $frame->fd ... ";
        $message->write($frame->fd, $data["client"]);
        $output->write("[+]", "green", null, false, true);
    }

    if ($data["type"] === "Message") {
        $user->saveMessage($data, $output);
        $message->push($server, $data, $output);
    }

});

$server->on('close', function ($ser, $fd) use ($message ,$output) {
    echo "Remove deconected user $fd ...";
	unset($GLOBALS["clients"][$fd]);
    $message->remove($fd);
    $output->write("[+]", "green", null, false, true);
});

echo "Starting server ... ";
$output->write("[+]", "green", null, false, true);
$server->start();
