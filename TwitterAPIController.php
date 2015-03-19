<?php
class TwitterAPIController
{
    /* Variables */
    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;
    private $getfield;
    protected $oauth;
    public $url;

    /* Methods */
    //Set the getfield string
    public function setGetfield($string) {
        $this->getfield = $string;
        return $this;
    }

    //Get the getfield string
    public function getGetfield() {
        return $this->getfield;
    }

    //Assign Keys and Tokens from array to create the access object
    public function __construct(array $authentication) {
        $this->consumer_key = $authentication['consumer_key'];
        $this->consumer_secret = $authentication['consumer_secret'];
        $this->oauth_access_token = $authentication['oauth_access_token'];
        $this->oauth_access_token_secret = $authentication['oauth_access_token_secret'];
    }

    //Build the base string to be used by cURL
    private function buildBaseString($baseURI, $method, $params) {
        $return = array();
        ksort($params);//sort the array by key

        //loops through the keys and returns
        foreach ($params as $key => $value) {
            $return[] = "$key=" . $value;
        }
        //returns the built string
        //encodes the raw url and joins array elements
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return));
    }

    //Build the authorisation to be used by cURL
    private function buildAuthorizationHeader($oauth) {
        $return = 'Authorization: OAuth ';//start of header string
        $values = array();

        //loops through all values: url, keys and signature
        foreach ($oauth as $key => $value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }

        //joins array elements and returns
        $return .= implode(', ', $values);
        return $return;
    }

    //Build the Oauth request with keys, tokens, url and getfields query
    public function buildOauth($url, $requestMethod) {
        //assign keys called earlier
        $consumer_key = $this->consumer_key;
        $consumer_secret = $this->consumer_secret;
        $oauth_access_token = $this->oauth_access_token;
        $oauth_access_token_secret = $this->oauth_access_token_secret;

        //parameters for authorisation
        $oauth = array( 
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),//Creates request token
            'oauth_signature_method' => 'HMAC-SHA1',//Twitter's signature method is HMAC-SHA1
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time()//Indicates request made
        );

        //get request query
        $getfield = $this->getGetfield();

        //finds ? (start of string), replaces spaces and breaks it into an array
        $getfields = str_replace('?', '', explode('&', $getfield));
        foreach ($getfields as $g) {
            $split = explode('=', $g);
            $oauth[$split[0]] = $split[1];
        }

        //Call base string function with parameters
        $base_info = $this->buildBaseString($url, $requestMethod, $oauth);
        //Set other authorization headers
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('SHA1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        //Find final built objects and return
        $this->url = $url;
        $this->oauth = $oauth;
        
        return $this;
    }

    //Retrieve Data as JSON string from API
    public function performRequest($return = true) {

        //call authorization header function with parameters
        $header = array($this->buildAuthorizationHeader($this->oauth), 'Expect:');

        //get request query
        $getfield = $this->getGetfield();

        //Array of cURL options
        $options = array(
            CURLOPT_HTTPHEADER => $header,//Array of header fields to set
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url,//Fetch the URL
            CURLOPT_RETURNTRANSFER => true,//Return as string
            CURLOPT_TIMEOUT => 10,//number of seconds to execute
        );

        //if request is not blank, fetches URL
        if ($getfield !== '') {
            //appends url to request query
            $options[CURLOPT_URL] .= $getfield;
        }

        //initialises cURL request and sets the multiple options
        $s = curl_init();
        curl_setopt_array($s, $options);
        //performs the cURL session
        $json = curl_exec($s);
        //closes session
        curl_close($s);

        //returns data
        if ($return) { return $json; }
    }
}
?>