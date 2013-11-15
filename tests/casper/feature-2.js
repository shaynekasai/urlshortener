/* 
 * Test error
 */
/*
 * 1. Go to http://dev-urlshortener.rhcloud.com
 * 2. Enter loremipsum
 * 3. Click Shorten
 * 4. Assert error box
 */

var casper = require('casper').create();
var test_url = 'loremipsum';
var test_key = 'db85f073'

casper.start('http://dev-urlshortener.rhcloud.com/', function() {

});

casper.then(function() {
	this.echo('initializing ... ' + test_url);
	this.fillSelectors('.ui-shorten-form', {
		'#url': test_url
	});
});
		
casper.then(function() {
	this.echo('clicking shorten button...');
	this.click("#btn-shorten");
});

casper.then(function() {
	this.waitUntilVisible('.url-shorten-error', function() {
		//.url-shorten-status span
		this.echo('... found element ' + this.getHTML('.url-shorten-error') );
	});
});
	
	

casper.run();
