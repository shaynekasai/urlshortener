<?php
require('../lib/UrlShortener/URL.php');

use lib\UrlShortener\URL as URL;

class CRC32Test extends PHPUnit_Framework_TestCase
{
	/**
         * @dataProvider provider
         */
	public function testCRC32($url,$hash) {
		$objURL = new URL();
		$this->assertEquals( $hash, $objURL->shortenCRC($url) );
	}
	public function provider() {
		return array(
			array('http://www.google.com','db85f073'),
			array('http://www.google.ca','a2959861'),
			array('http://www.facebook.com','c6c371ec')
		);
	}
}

?>
