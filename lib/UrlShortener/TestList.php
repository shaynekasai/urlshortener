<?php
/**
 * Custom REST class as per F3 - THIS IS JUST A DEMO
 *
 * You just need to have a class with get, post, put and delete
 *
 * Header types:
 * GET -> get()
 * POST -> post()
 * PUT -> put()
 * 
 * and so on
 */

use lib\UrlShortener\URLService as URLService;

class TestList {
    private  $Service;
	
    function __construct() {
        $this->Service =  new URLService();
    }
	
    /* 
     * This is just a demo
     */
    function get($params='') {
    	$objURLs = $this->Service->getURLs();
    	echo $objURLs == false ? json_encode(array("status" => "error"))  : json_encode($objURLs);
    }
    
    function post() {}
    function put() {}
    function delete() {}
}
?>
