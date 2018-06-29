<?php

// function mqttSend($data) {
// 	$c = new Mosquitto\Client;
// 	$c->onConnect(function() use ($c, $data) {
// 		$c->publish('sensor', $data, 0);
// 		$c->disconnect();
// 	});
	
// 	$c->connect('192.168.2.13', 15200);
// 	$c->loopForever();

// 	echo "Finished\n";
// }

// $data = 'dsjfsnfvvjbsdfnskjbfdfnsdjfosndgvojasdf';

// $c = new Mosquitto\Client;
// $c->onConnect(function() use ($c, $data) {
// 	$c->publish('sensor', $data, 0);
// 	$c->disconnect();
// });

// 	$c->connect('192.168.2.13', 15200);
// 	$c->loopForever();

// 	echo "Finished\n";
$client = new Mosquitto\Client();
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');

function pub($data) {
	global $client;
	$client->connect("192.168.2.13", 15200);
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
