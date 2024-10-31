<?php

class PicsmizeClient {

	const API_ENDPOINT = "https://api.picsmize.com";


	/**
	* Client constructor
	*
	* @param {Array} options
	*/
	
	public function __construct($options){

	   /**
	   * Initialize a new cURL session
	   */

	   $this->curl = curl_init();
	   $this->options = $options;

	   return $this;
	}

	/**
	* Sends HTTPS request to the Picsmize API
	*
	* @param {Object} callback
	*/

	public function request() {

		/*
		* Client Error Checker
		*/

		$this->errorHandler();
		
		/**
		* Define empty headers array
		* wich will be injected together with cURL parameters
		*/

		$requestHeaders = array();

		/**
		* Use JSON request for fetch() mode
		*/

		if(!isset($this->options['timeout']))
			$this->options['timeout'] = 60;

		if (isset($this->options['inputFetch'])) {
			
			$data = [
				'apiKey' => $this->options['apiKey'],
				'inputFetch' => 1,
				'img_url' => $this->options['img_url'],
				'process' => $this->options['process'],
				'toJSON' => 1,
				'timeout' => $this->options['timeout'],
			];
			array_push($requestHeaders, 'Content-Type: application/json');
		}
		array_push($requestHeaders, "apikey: {$this->options['apiKey']}");
		array_push($requestHeaders, "User-Agent: {$this->getUserAgent()}");
		
		/**
		* Set curl options
		*/
		$postBody = array(
		    'method'      => 'POST',
	        'timeout'     => $this->options['timeout'],
	        'sslverify'  => false,
	        'httpversion' => CURL_HTTP_VERSION_1_1,
		    /*'timeout'     => 0,*/
		    'data_format' => 'body',
	        'redirection' => 10,
	        'httpversion' => '1.0',
	        'blocking'    => true,
	        'headers'     => ['apikey' => $this->options['apiKey'],'Content-Type' => 'application/json'],
		    'body'        => isset($data) ? json_encode($data) : []
		);
		$response = wp_remote_post( self::API_ENDPOINT . '/image/process', $postBody);
		/*list($messageHeaders, $messageBody) = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);*/

		if ( is_wp_error( $response ) ) {
	        $error = $response->get_error_message();
	        
	    } else {
	        $messageBody = $response['body'];
	        $this->lastResponseHeaders = $response['headers'];
	    }
		
		/**
		* Parse the response body when dealing with toJSON() requests
		* and return the data to the user
		*/
		if (isset($this->options['toJSON'])) {

			if(!empty($error))
				throw new Exception($error);

			try {
				$response = json_decode($messageBody, true);
			} catch (Exception $e) {
				throw new Exception('Unable to parse JSON response from the Picsmize API');
			}

			if (!isset($response) || empty($response)){
				throw new Exception('Unable to parse JSON response from the Picsmize API');
			}

			if ($response['status'] !== true) {
				throw new Exception($response['message']);
			}
			
			return ($response);
		}
	}

	/**
	* Get Response Header Value
	* 
	* @param {String} Header Name
	*/

	public function getHeader($index) {
		
		if(!isset($this->lastResponseHeaders) || $this->lastResponseHeaders == null)
			throw new Exception('Cannot be called before an API call.');

		if(isset($this->lastResponseHeaders[$index]))
			return $this->lastResponseHeaders[$index];
		return null;
	}

	private function getUserAgent() {
		return 'Picsmize/' . VERSION . ' PHP/' . PHP_VERSION . ' CURL/1.0';
	}

	private function errorHandler(){

		if(isset($this->options['errorMessage'])){
			throw new Exception($this->options['errorMessage']);
		}

	   	/**
	   	* Check a API Key
	   	*/

	   	if (!isset($this->options['apiKey']) || $this->options['apiKey'] == '') {
	   		throw new Exception('Requires a valid API key for image processing.');
	   	}

	    /**
	    * Check a cURL version
	    */

	    if(!function_exists('curl_version')) {
	    	throw new Exception('cURL is not enabled. Use fallback method.');
	    }
	    
	    return $this;
	}
}