<?php

namespace Thorazine\Hack\Classes\Tools;

use Exception;
use Request;
use Cache;
use Log;

// Examples:
// dd($location->coordinatesToAddress(52.3828617, 4.8907602)->get());
// dd($location->addressToCoordinates(['country' => 'Netherlands', 'city' => 'Amsterdam', 'region' => ''])->get());
// dd($location->ipToLocation('217.195.116.157')->get());
// dd($location->ipToLocation('217.195.116.157')->coordinatesToAddress()->get());

class Location {
	
	/**
	 * If there is an error it'll be in here
	 */
	public $error = null;

	/**
	 * Default values
	 */
	private $default = [
		'latitude' => null,
		'longitude' => null,
		'country' => '',
		'city' => '',
		'region' => '',
	];

	/**
	 * The request url
	 */
	private $url;

	/**
	 * The array that holds the data
	 */
	private $array = [];
	
	/**
	 * If you have a large amount of requests to do
	 */
	private $googleKey = '';
	
	/**
	 * How many tries we get
	 */
	private $tries = 3;
	
	/**
	 * How many tries have been done
	 */
	private $tried = 0;
	
	/**
	 * Time in between requests
	 */
	private $tryTimeout = 1; // in seconds


	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->array = $this->default;
	}


	/**
	 * Switch to detect if its a chain or a direct call
	 *
	 * @param float (optional for chaining)
	 * @param float (optional for chaining)
	 * @return $this
	 */
	public function coordinatesToAddress($latitude = false, $longitude = false)
	{
		if(! $latitude || ! $longitude) {
			$latitude = $this->array['latitude'];
			$longitude = $this->array['longitude'];
		}
		else {
			$this->array['latitude'] = $latitude;
			$this->array['longitude'] = $longitude;
		}

		return $this->runCoordinatesToAddress($latitude, $longitude);
	}


	/**
	 * Get an address from coordinates
	 *
	 * @param float (optional for chaining)
	 * @param float (optional for chaining)
	 * @return $this
	 */
	private function runCoordinatesToAddress($latitude, $longitude)
	{
		$this->url = $this->addKey('http://maps.google.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude);
 
		$response = $this->jsonToArray($this->gateway());

		if(array_key_exists('status', $response) && $response['status'] != 'ZERO_RESULTS') {
			$this->array['city'] = $this->findInGoogleSet($response, ['locality', 'administrative_area_level_2']);
			$this->array['country'] = $this->findInGoogleSet($response, ['country']);
			$this->array['region'] = $this->findInGoogleSet($response, ['administrative_area_level_1']);
		}
		else {
			$this->tried++;

			$this->error = 'Could not get data from service.';

			if($this->tryAgain()) {
				sleep($this->tryTimeout);

				$this->coordinatesToAddress($latitude, $longitude);
			}
		}

		return $this;
	}


	/**
	 * Get coordinates from address data
	 *
	 * @param array (country, city, region)
	 * @return $this
	 */
	public function addressToCoordinates(array $attributes = [])
	{

		// build the url
		$this->url = 'http://maps.google.com/maps/api/geocode/json?address=';

		if(array_key_exists('country', $attributes) && array_key_exists('city', $attributes)) {
			$this->url .= urlencode($attributes['city'].','.$attributes['country']);
		}
		else {
			$this->url .= urlencode($attributes['city'].$attributes['country']);
		}

		if(array_key_exists('region', $attributes)) {
			$this->url .= '&region='.urlencode($attributes['region']);
		}

		$this->array = array_merge($this->array, $attributes);

		$this->addKey($this->url);

		$response = $this->jsonToArray($this->gateway());

		if(array_key_exists('status', $response) && $response['status'] != 'ZERO_RESULTS') {
			$this->array['latitude'] = @$response['results'][0]['geometry']['location']['lat'];
			$this->array['longitude'] = @$response['results'][0]['geometry']['location']['lng'];
		}
		else {
			$this->tried++;

			$this->error = 'Could not get data from service';

			if($this->tryAgain()) {
				sleep($this->tryTimeout);

				$this->addressToCoordinates($attributes);
			}
		}

		return $this;
	}


	/**
	 * Get coordinates from an ip
	 *
	 * @param string (ip)
	 * @return $this
	 */
	public function ipToLocation($ip = false)
	{
		if(! $ip) {
			$ip = Request::ip();
		}
		$this->url = 'http://ipinfo.io/'.$ip.'/geo';

		$response = $this->jsonToArray($this->gateway());

		list($latitude, $longitude) = explode(',', $response['loc']);

		$this->array['latitude'] = $latitude;
		$this->array['longitude'] = $longitude;

		return $this;
	}


	/**
	 * Get the data
	 *
	 * @param string (url)
	 * @return mixed
	 */
	private function gateway()
	{
		try {
			// store request for a week
			$data = Cache::tags(['location', 'tools', 'cms'])->remember(sha1($this->url), 10800, function() {
	        	return Curl::get($this->url);
	        });

	        return $data;
	    }
	    catch(Exception $e) {
	    	Log::error('Could not get location. There was an error.', [
	            'data' => $this->url,
	            'error' => $e->getMessage(),
	        ]);
	    	$this->error = $e;
	    }
	}


	/**
	 * Add the google key if there is one
	 *
	 * @param string (url)
	 * @return string (url)
	 */
	private function addKey($url)
	{
		if($this->googleKey) {
			return $url.'&key='.$this->googleKey;
		}
	}


	/**
	 * Check to see if we need to request again
	 *
	 * @return boolean
	 */
	private function tryAgain()
	{
		if($this->tried < $this->tries) {
			return true;
		}
	}


	/**
	 * Convert json string to an array if the syntax is right
	 *
	 * @param string (json)
	 * @return array|null
	 */
	private function jsonToArray($json)
	{
		try {
			$data = json_decode($json, true);
			if(is_array($data)) {
				return $data;
			}
			else {
				$this->error = 'The given data string was not json';
				return [];
			}
		}
		catch(Exception $e) {
			$this->error = $e;
		}
	}


	/**
	 * Find a value in a response from google
	 *
	 * @param array (googles response)
	 * @param array (attributes to find)
	 * @return string
	 */
	private function findInGoogleSet($response, array $find = [])
	{
		try {
			foreach($response['results'][0]['address_components'] as $data) {
				foreach($data['types'] as $key) {
					if(in_array($key, $find)) {
						return $data['long_name'];
					}
				}
			}
			return '';
		}
		catch(Exception $e) {
			$this->error = $e;
			return '';
		}
		
	}


	/**
	 * Return the data and reset the class
	 *
	 * @param boolean (optional)
	 * @return array|object
	 */
	public function get($object = false)
	{
		if($object) {
			return json_decode(json_encode($this->array));
		}

		if($this->error) {
			Log::error('Could not get location. There was an error.', [
	            'error' => $this->error,
	        ]);
		}

		$return = $this->array;
		$this->array = $this->default;
		$this->tried = 0;
		$this->url = null;

		return $return;
	}
}