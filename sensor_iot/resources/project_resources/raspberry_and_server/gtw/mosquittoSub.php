<?php
require ('applicationDatabase.php');
define('BROKER', '192.168.100.150');
define('PORT', 15200);
define('CLIENT_ID', getmypid());

$database = new Connection();

$client = new Mosquitto\Client(CLIENT_ID);
$client->onConnect('connect');
$client->onDisconnect('disconnect');
$client->onSubscribe('subscribe');
$client->onMessage('message');
$client->connect(BROKER, PORT, 60);
$client->subscribe('sensor', 1); // Subscribe to all messages

$client->loopForever();

function connect($r) {
	echo "Received response code {$r}\n";
}

function subscribe() {
	echo "Subscribed to a topic\n";
}

function message($message) {
	printf("Got a message on topic %s with payload:\n%s\n", $message->topic, $message->payload);
	processInfo($message->payload);
}

function disconnect() {
	echo "Disconnected cleanly\n";
}

function processInfo($content) {
	global $database;
	$sensor = explode(';', $content);
	$sensorInfo = [];

	foreach ($sensor as $property) {
		$property = explode(':', $property);
		//[key, value]
		$sensorInfo[$property[0]] = $property[1];
	}

	if (!empty($sensorInfo) &&
			!empty($id = $sensorInfo['id']) &&
			!empty($temp = $sensorInfo['temperature']) &&
			!empty($um = $sensorInfo['humidity'])
			) {
				echo "data is set \n";
				if (! $link = $database->connect()) {
					echo $link;
					echo "Não foi possível conectar!! \n";
				} else {
					$database->saveData($sensorInfo);
					echo "Salvo data \n";
				}
			}
}
