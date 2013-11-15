<?php
/**
 * URL
 *
 * This class is really meant to perform different types of shortening, gets called in by other classes or can be used standalone.
 *
 * @package    urlshortener
 * @subpackage 
 * @author     
 */
namespace lib\UrlShortener;

class URL {


	/**
	 *  I want to support more but crc32 for now, returns an 8 character rep of the url
	 *
	 *	@return string
	 *	@param $url  
	 */
	public function shortenCRC($url) {
		return( hash('crc32', $url) ); 
	}	
	
	/**
	 * Maybe we can get something smaller than crc32
	 */
	public function customOrd($url) {
		
	}
}
?>
