<?php
//////////////////////////////////////////////////
//
// Main Driver 
// Author: Shayne Kasai <shaynekasai@gmail.com>
//
/////////////////////////////////////////////////
$f3=require('lib/base.php');
require_once("lib/UrlShortener/URLService.php");
require_once("lib/UrlShortener/Dispatch.php");
require_once("lib/UrlShortener/TestList.php");

use lib\UrlShortener\URLService as URLService;


$f3->set('DEBUG',1);
$f3->config('config.ini');

// Disabled this because it was causing openshift to kack
//if ((float)PCRE_VERSION < 7.9) {
//	trigger_error('PCRE version is out of date');
//}

//////////////////////////////////////////////////
// General UI 
//////////////////////////////////////////////////
$f3->route('GET /',
	function() {
		echo View::instance()->render('index.html');
	}
);

$f3->route('GET /@hash', 
	function($f3, $params) {
		$objDispatch = new Dispatch();
		$json = json_decode($objDispatch->get($params));
		
		// this is so not safe... would be nice to have some checking in place
		header('Location: ' . $json->url);
		exit;
		
	}
);
//
// End General UI
//

//////////////////////////////////////////////////
// 0MQ client DO NOT USE (but it works locally)
// Took out of mapping scheme for now
//////////////////////////////////////////////////

$f3->route('GET /0mq',
	function($f3, $params) {
		echo View::instance()->render('0mq.html');
	}
);

$f3->route('POST /api/v1/0mqshorten',
	function($f3, $params) {
		/* This is so brute force but it's proof of concept */
		if (isset($_POST['url'])) {
			$context = new ZMQContext();
			$socket = new ZMQSocket($context, ZMQ::SOCKET_DEALER);
			$socket->connect('tcp://localhost:15000');
		
			$package = array("method" => "shorten", "url" => (string)$_POST['url']);
			$socket->send(json_encode($package));
			echo $socket->recv() . "\n";
			

		}
	}
);
//
// End 0MQ version
//


//////////////////////////////////////////////////
// REST functionality: this is how F3 does it, but ideally we would dedicate a resource to just this functionality rather than 
// combining it in here.
//////////////////////////////////////////////////
$f3->map('/api/v1/shorten','Dispatch');
$f3->map('/api/v1/fetch','Dispatch');
//
// add your own like this: $f3->map('/remove', 'Dispatch');
$f3->map('/api/v1/list', 'TestList'); // this is just to show how to set up a new rest call
//
// End of REST functionality
//

$f3->run();

?>
