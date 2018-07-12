<?php
require 'circularSensorList.php';
require 'database.php';
require 'mail.php';
require 'mosquittoPub.php';

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting as it comes in. */
ob_implicit_flush();

//Reporting mysql errors
mysqli_report(MYSQLI_REPORT_ALL);


//Variables
$address = '192.168.100.150';
// $address = '192.168.100.145';
$port = 15555;
$buff = [];
$database = new Connection();

//Constants
define("MAX_TEMPERATURE", 35);
define("MIN_TEMPERATURE", 1);
define("MAX_HUMIDITY", 100);
define("MIN_HUMIDITY", 21);

// create a streaming socket, of type TCP/IP
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);

socket_bind($sock, $address, $port);

socket_listen($sock);

// create a list of all the clients that will be connected to us..
// add the listening socket to this list
$clients = array($sock);

while (true) {

	// create a copy, so $clients doesn't get modified by socket_select()
	$read = $clients;
    $write = null;
    $except = null;

    // get a list of all the clients that have data to be read from
    // if there are no clients with data, go to next iteration
    if (socket_select($read, $write, $except, NULL) < 1)
        continue;

    // check if there is a client trying to connect
    if (in_array($sock, $read)) {
        $clients[] = $newsock = socket_accept($sock);

        socket_write($newsock, "There are ".(count($clients) - 1)." client(s) connected to the server\n");
        socket_getpeername($newsock, $ip, $port);
        echo "New client connected: {$ip}\n";

        $key = array_search($sock, $read);
        unset($read[$key]);
    }
    // loop through all the clients that have data to read from
    foreach ($read as $read_sock) {

        // read until newline or 2048 bytes
        // socket_read while show errors when the client is disconnected, so silence the error messages
        $data = @socket_read($read_sock, 2048, PHP_BINARY_READ);
        // check if the client is disconnected
        if ($data === false) {
            // remove client for $clients array
            $key = array_search($read_sock, $clients);
            unset($clients[$key]);
            echo "client disconnected.\n";
            continue;
        }

        $data = trim($data);
        if (!empty($data)) {
            processInfo($data);
            socket_write($read_sock, 'OK', 2);
        }
	}
}
socket_close($sock);

function processInfo($content) {
	echo $content."\n";
	global $buff, $database, $client;
	$sensor = explode(';', $content);
	$sensorInfo = [];

	foreach ($sensor as $property) {
		error_log($property);
		$property = explode(':', $property);
		//[key, value]
		$sensorInfo[$property[0]] = $property[1];
	}

	if (!empty($sensorInfo) &&
			!empty($id = $sensorInfo['identifier']) &&
			!empty($temp = $sensorInfo['temperature']) &&
			!empty($um = $sensorInfo['humidity'])
			) {
				echo "data is set \n";
				if (validateData($sensorInfo) && validateData($sensorInfo, 'h')) {
					echo "data is valid \n";
					if (empty($buff[$id])) {
						$buff[$id] = new ListaCircular();
					}
					$buff[$id]->inserirFim($id, $temp, $um);
					echo "Nodos = ".$buff[$id]->contarNodos()."\n";
					if ($buff[$id]->contarNodos() == 60) {
						echo "60 nodos!! \n";
						//Calcular média e salvar em $data
						$data = $buff[$id]->calculaMédia();
						pub($data);
						$buff[$id] = new ListaCircular();
					}
					if (! $link = $database->connect()) {
						echo $link;
						echo "Não foi possível conectar!! \n";
					} else {
						$database->saveData($sensorInfo);
						echo "Salvo data \n";
					}
				}
			}
}

function validateData($sensor, $type = 't') {
	$return = true;

	if ($type == 't'){
		if($sensor['temperature'] < MIN_TEMPERATURE  || $sensor['temperature'] > MAX_TEMPERATURE) {
			$return = false;
			mountSendMail('Arduino **'.$sensor['identifier'].'** Invalid Temperature Alert', "Registered temperature of {$sensor['temperature']}ºC. Verify your Arduino");
		}
	} else {
		if($sensor['humidity'] < MIN_HUMIDITY  || $sensor['humidity'] > MAX_HUMIDITY) {
			$return = false;
			mountSendMail('Arduino **'.$sensor['identifier'].'** Invalid Humidity Alert', "Registered humidity of {$sensor['humidity']}%. Verify your Arduino");
		}
	}
	return $return;
}
?>
