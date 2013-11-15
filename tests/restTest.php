<?php
/*
 * TODO: use provider
 */
 
require('vendor/autoload.php');

use Guzzle\Http\Client;



class RestTest extends PHPUnit_Framework_TestCase
{

	
	public function testShorten() {
	    $client = new Client('http://dev-urlshortener.rhcloud.com/');
	    $request = $client->post('api/v1/shorten', null, [
	    	'url' => 'http://www.google.com',
	    ]);
	    
	    $response = $request->send();
	    $decodedResponse = $response->json();
	    $this->assertEquals($decodedResponse['status'], 'success');
	    $this->assertEquals($decodedResponse['hash'], 'db85f073');
	}
    
	public function testFetch() {
	 	$client = new Client('http://dev-urlshortener.rhcloud.com/');
	    $request = $client->get('api/v1/fetch?id=db85f073');
	    $response = $request->send();
	    $decodedResponse = $response->json();
	    $this->assertEquals($decodedResponse['url'], 'http://www.google.com');
	   
	  
	}
	
	// 
	// TODO, list method should return success or error. We need to put something in that class for that
	// This is just here for posteriety
	//
	public function testList() {
	 	$client = new Client('http://dev-urlshortener.rhcloud.com/');
	    $request = $client->get('api/v1/list');
	    $response = $request->send();
	    $decodedResponse = $response->json();
	    
	    $this->assertGreaterThan(1, count($decodedResponse));
	   
	  
	}
   

}