<?php
/**
 * URLService
 *
 * This class does the gruntwork for the REST and Web APIs, mainly calling the CRC32 functionality
 * and fetching the URL / hash
 *
 * @package    urlshortener
 * @subpackage 
 * @author     
 */
 
namespace lib\UrlShortener;

require_once("URL.php"); 
use lib\UrlShortener\URL as URL;
use DB as DB;

class URLService {
	private $objURL = null;
	private $DBH = null;
	
	/**
	 * Setup DB and URL functionality
	 */
	function __construct() {
		$host   = $_ENV["OPENSHIFT_MONGODB_DB_HOST"];
		$user   = $_ENV["OPENSHIFT_MONGODB_DB_USERNAME"];
		$passwd = $_ENV["OPENSHIFT_MONGODB_DB_PASSWORD"];
		$port   = $_ENV["OPENSHIFT_MONGODB_DB_PORT"];

		$uri = "mongodb://" . $user . ":" . $passwd . "@" . $host . ":" . $port;
	
		$this->objURL = new URL();
		$this->DBH = new DB\Mongo($uri,'urlshortener');
	}
	
	/**
	 *  Looks up $hash in the DB, doesn't execute the shortening.
	 *	@return  
	 *	@param $hash  
	 */
	public function getURL($hash) {
		
		
		$urls=new DB\Mongo\Mapper($this->DBH,'urls');
		
		$urlList = $urls->find(array('hash'=> $hash));
		
		// no findOne in fat free?
		if (count($urlList > 0)) {
			$objURL = $urlList[0];
			return($objURL);
		} 
		
		
		return false;
	}
	
	/**
	 *  Dumps all of the URLs into one big array
	 *	@return  
	 *	@param $hash  
	 */
	public function getURLs() {
		
		
		$urls=new DB\Mongo\Mapper($this->DBH,'urls');
		
		$urlList = $urls->find();
		$arrJson = array();
		
		// no findOne in fat free?
		foreach($urlList as $obj) {
			array_push($arrJson, array("hash" => $obj->hash, "url" => $obj->url));
		}
		
		if (count($arrJson > 0)) {
			return($arrJson);
		} 
		
		
		return false;
	}
	
	
	/**
	 * Just a quick implementation, could do something a little more tightly knit with mongo. This will also insert into the DB 
	 *
	 * @return
	 * @param $url 
	 */
	public function shorten($url, $type="crc32") {
		$hash = $this->objURL->shortenCRC($url);
		
		// look up hash in the db
		$urls=new DB\Mongo\Mapper($this->DBH,'urls');
		
		// hey not in the db, insert it and go
		$urlList = $urls->find(array('hash'=> $hash));
		if(count($urlList) <= 0) {
			// do an insert, need some error handling in here
			$urls->reset();
			$urls->hash=$hash;
			$urls->url=$url;
			$urls->save();
		} 		
		return($hash);
	}

}
/*
$objTest = new URLService();
$hash = $objTest->shorten('http://www.google.com');
echo $hash . "<br/>";
echo $objTest->getURL($hash)->url;
*/



?>