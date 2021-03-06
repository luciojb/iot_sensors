<?php
error_reporting(E_ALL);

echo "<h2>TCP/IP Connection</h2>\n";

$service_port = 15555;

/* Set the IP address for the target host. */
$address = gethostbyname('192.168.100.145');

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
	echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
	echo "OK.\n";
}

echo "Attempting to connect to '$address' on port '$service_port'...";
$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
	echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
	echo "OK.\n";
}

while (true) {
	$in = "HEAD / HTTP/1.1\r\n";
	$in = "humidity:45.6;temperature:20.5;identifier:s02\r\n";

	$out = '';

	echo "Sending HTTP HEAD request...";
	socket_write($socket, $in, strlen($in));
	echo "OKay\n";

	echo "Reading response:\n\n";
	$out = socket_read($socket, 2048);
	echo $out;
	sleep(1);
	
}

echo "Closing socket...";
socket_close($socket);
echo "OK.\n\n";
?>
