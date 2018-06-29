<?php
require 'circularSensorList.php';
require 'database.php';
require 'mail.php';

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting as it comes in. */
ob_implicit_flush();

//Reporting mysql errors
mysqli_report(MYSQLI_REPORT_ALL);


//Variables
// $address = '192.168.100.150';
$address = '192.168.2.13';
$port = 15555;
$buff = new ListaCircular();
$database = new Connection();

//Constants
define("MAX_TEMPERATURE", 35);
define("MIN_TEMPERATURE", 5);
define("MAX_HUMIDITY", 100);
define("MIN_HUMIDITY", 21);


if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

do {
	try{
		if (($msgsock = socket_accept($sock)) === false) {
			echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
			break;
		}

		do {
			if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
				echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
				break;
			}
			if (!$buf = trim($buf)) {
				continue;
			}

			processInfo($buf);
			socket_write($msgsock, 'OK', 2);

		} while (true);
		socket_close($msgsock);
	} catch (Exception $e) {
		echo $e->getTraceAsString();
	}
} while (true);

socket_close($sock);


// function save($texto) {
//     $arquivo = file_put_contents('file.txt', $texto.PHP_EOL , FILE_APPEND | LOCK_EX);
// 	fwrite($arquivo, $texto);
// 	fclose($arquivo);
// }

function processInfo($content) {
	echo $content."\n";
	global $buff, $database;
	$sensor = explode(';', $content);
	$sensorInfo = [];

	foreach ($sensor as $property) {
		$property = explode(':', $property);
		//[key, value]
		$sensorInfo[$property[0]] = $property[1];
	}

	var_dump($sensorInfo);

	if (!empty($sensorInfo) &&
			!empty($id = $sensorInfo['identifier']) &&
			!empty($temp = $sensorInfo['temperature']) &&
			!empty($um = $sensorInfo['humidity'])
	) {
		echo "data is set \n";
		if (validateData($sensorInfo) && validateData($sensorInfo, 'h')) {
			echo "data is valid \n";
			$buff->inserirFim($id, $temp, $um);
			echo "Nodos = ".$buff->contarNodos()."\n";
			if ($buff->contarNodos() == 10) {
				echo "60 nodos!! \n";
				if (! $link = $database->connect()) {
					echo $link;
					echo "Não foi possível conectar!! \n";
				} else {
					$database->saveData($sensorInfo);
					echo "Salvo data \n";
				}
				$buff = new ListaCircular();
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
