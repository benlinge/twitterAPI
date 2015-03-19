<?php

//Allows only this domain to have access to this file.
header('Access-Control-Allow-Origin: http://www.ehustudent.co.uk/cis21995575/cis3113/task-3/');

//Returns data as JSON
header('Content-Type: application/json');

//Includes the Controller file
require_once('TwitterAPIController.php');

//App Access Tokens and Keys as array
$authentication = array(
    'oauth_access_token' => "275658266-VXGe53hDMJIUyQlelqxXRQui7VvDCEPEgbg168Gj",
    'oauth_access_token_secret' => "oqTo9XOLWldOrtUvDB2SuFL27cdtuaIRMtOJy7DdCjBp3",
    'consumer_key' => "N1nMNzE56k4Vzzfg97uCn7jCQ",
    'consumer_secret' => "ITY4M6NRYLZA3bbvN6gtSHnCqUuaPPaeyHHmBKt5its4NRlRud"
);

/* GET request */
//Twitter API URL
$url = 'https://api.twitter.com/1.1/search/tweets.json';

//URL queries
$hashtags = '?q=%23beautytips%2BOR%2B%23bblogger%2BOR%2B%23beautyblogger%2BOR%2B%23beautynews%2BOR%2B%23beautytrends%2BOR%2B%23naturalbeauty%2BOR%2B%23lookyounger%2BOR%2B%23beautifulskin%2BOR%2B%23makeuptips%2BOR%2B%23dryskin%2BOR%2B%23lookfantastic';
$blacklist = '%2B-sex%2B-sexy%2B-fuck%2B-anal%2B-ass%2B-bitch%2B-bastard%2B-boobs%2B-dick%2B-cock%2B-penis%2B-fuck%2B-faggot%2B-fag%2B-fagot%2B-fucked%2B-fucking%2B-hoe%2B-horny%2B-knob%2B-motherfucker%2B-nigga%2B-nigger%2B-piss%2B-pissed%2B-porn%2B-pussy%2B-shit%2B-shag%2B-tit%2B-titties%2B-twat%2B-wanker%2B-whore';
$settings = '&lang=en&count=5&result_type=mixed';
$getfield = $hashtags . $blacklist . $settings;

//Define the Get request
$requestMethod = 'GET';

//New API Request and uses the Authentication array as parameter
$twitter = new TwitterAPIController($authentication);

//Compose API response
$api_response = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();

//Echo the API response
echo $api_response
?>
