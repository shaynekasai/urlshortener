<?php
/**
 * Default FF REST class that is passed through mapping. Here I've created something called Dispatch
 * which really just calls methods from Services.
 */

use lib\UrlShortener\URLService as URLService;

class Dispatch {
    private  $Service;
	
    function __construct() {
        $this->Service =  new URLService();
    }
	
    /* 
     * This is meant to handle any get requests for the service
     *
     * @param array
     * @returns 
     */
    function get($params='') {
    	$hash = (isset($_GET['id']) == true) ? (string)$_GET['id'] : $params['hash'];
    	$objURL = $this->Service->getURL($hash);
    	
    	if(isset($_GET['id'])) {
	    echo $objURL == false ? json_encode(array("status" => "error")) : json_encode(array("url" => $objURL->url));
        } else {
	    return $objURL == false ? json_encode(array("status" => "error"))  : json_encode(array("url" => $objURL->url));
        }
    }
    
    /* 
     * This is meant to handle any post requests for the service, but mainly to ship and shorten.
     *
     * @param 
     * @returns 
     */
    function post() {
    	
    	$url = (string)$_POST['url'];
    	if (preg_match("/^https?:\/\/.{1,70}\.[a-zA-Z.]{2,5}.{0,1000}$/", $url)) {
    	
    	    $hash = $this->Service->shorten($url);
    	    $friendly_url = 'http://' . $_SERVER["HTTP_HOST"] . '/' . $hash;
            echo json_encode(array("status" => "success", "friendly_url" => $friendly_url, "hash" => $hash, "url" => $url));
		
    	} else {
    	    echo json_encode(array("status" => "error", "message" => "Invalid URL, please enter a valid URL, example: http://www.foo.com"));
    		
        }
    }
    function put() {}
    function delete() {}
}
?>
