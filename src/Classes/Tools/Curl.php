<?php 

namespace Thorazine\Hack\Classes\Tools;

class Curl {
	
	// provide a default user agent
	private static $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36';
	

	// get curl request
	public static function get($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, self::$userAgent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}


	// post curl request
	public static function post($url, $postArray = []) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postArray);
		curl_setopt($ch, CURLOPT_USERAGENT, self::$userAgent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}


	// post curl SOAP request
	public static function soap($url, $xml_data) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
		curl_setopt($ch, CURLOPT_USERAGENT, self::$userAgent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}
}