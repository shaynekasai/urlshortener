<?php
/*
 * This is my 0MQ test server, doesn't do anything special yet, ie no backpressure/error handling... sorry
 */
$f3 = require_once('lib/base.php');
require_once("lib/urlshortener/URLService.php");
require_once("lib/urlshortener/Dispatch.php");

use lib\UrlShortener\URLService as URLService;

/* pulled from http://code.hootsuite.com/parallel-processing-task-distribution-with-php/ */

$objService = new URLService();

$context = new ZMQContext();
$socket = new ZMQSocket($context, ZMQ::SOCKET_ROUTER);
$socket->bind('tcp://*:15000');
$poll = new ZMQPoll();
$poll->add($socket, ZMQ::POLL_IN);
$readable = $writeable = array();


echo "Initializing...\n";
while(true) {
	$events = $poll->poll($readable, $writeable, 1000);
  	foreach($readable as $s) {
   		$message = $socket->recvmulti();
		print_r($message);
		
		$url = $message[1];
		$hash =	$objService->shorten($url);
		
		$package = array("status" => "success", "hash" => $hash);
		
  	  	$socket->sendmulti(array($message[0], json_encode($package) ));
  	}
}


?>
