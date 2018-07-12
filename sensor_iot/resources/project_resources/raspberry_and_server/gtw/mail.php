<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

set_include_path("/home/pi/pear/share/pear");
require_once "Mail.php";

$host = "ssl://smtp.gmail.com";
$username = "aulaiot1@gmail.com";
$password = "querocafe";
$port = "465";
$to = "luciojbeiraoo@gmail.com";
$email_from = "aulaiot1@gmail.com";

function mountSendMail($email_subject, $email_body) {
	global $email_from, $to, $port, $host, $username, $password;

	$headers = array ('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_from);
	$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));

	$mail = $smtp->send($to, $headers, $email_body);

}
?>
