<?php

$client = new Mosquitto\Client();
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');

function pub($data) {
	global $client;
	$client->connect("192.168.100.150", 15200);
	$client->publish('sensor', $data, 1, 0);
	$client->loop();

	sleep(2);

	$client->disconnect();
}

function connect($r) {
	echo "Returned code: {$r}\n";
}
function subscribe() {
	echo "Subscribed to a topic\n";
}
function message($message) {
// 	printf("Got a message ID %d on topic %s with payload:\n%s\n\n", $message->mid, $message->topic, $message->payload);
}
function disconnect() {
	echo "Disconnected cleanly\n";
}

?>
