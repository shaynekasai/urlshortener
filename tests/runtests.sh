#!/bin/sh

phpunit CRC32Test
phpunit restTest.php

casperjs test casper/feature-1.js
casperjs test casper/feature-2.js

# Quick API tests
#curl -i -H "Accept: application/json" -X POST -d "url=helloworld" http://localhost/urlshortener/shorten  
#curl -i -H "Accept: application/json" -X POST -d "url=http://www.google.com" http://localhost/urlshortener/shorten  
#curl -i -H "Accept: application/json" -G -d "id=db85f073" http://localhost/urlshortener/fetch

# These are just stress tests using ab
#ab -n 100 -c 10 http://localhost/urlshortener > ab-general-1.log
#ab -n 100 -c 10 -p 0mqpost.txt http://localhost/urlshotener/0mqshorten > ab-shorten-1.log
