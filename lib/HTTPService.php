<?php

/**
 * HTTPService class to help in HTTP-related tasks.
 *
 */
class HTTPService {

	// Change this to where your payment solution is based
	// TTPay URLs
	const TTPAY_URL_BASE = 'https://www.ttpay.com/';
	const TTPAY_URL_BASE_SANDBOX = 'https://sandbox.ttpay.com/';
	
	// Change this to where your RESTful APIs are served
	// TTPay API URLs
	const TTPAY_API_URL_BASE = 'https://www.ttpay.com/api/';
	const TTPAY_API_URL_BASE_SANDBOX = 'https://sandbox.ttpay.com/api/';

	// Use this if you have multiple versions of your API
	// TTPay API latest version
	const TTPAY_API_VERSION = '1.0';

	public function __construct($config) {
		
	}

	/**
	 * Send the actual HTTP POST to TTPay servers.
	 *
	 * @return mixed           		 Returns the result from json_decode of TTPay's response
	 * @throws TTPaymentsException   Error sending HTTP POST
	 */
	protected static function doTTPayGet($url, $fields) {

		// initialize cURL
		$ch = curl_init();

		$fields_string = http_build_query($fields);

		// set options for cURL
		curl_setopt($ch, CURLOPT_URL, $url . '?' . $fields_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// execute HTTP POST request
		$response = curl_exec($ch);
		$ch_error = curl_error($ch);
		if ($ch_error) {
			echo $ch_error;
			die();
		}

		// close connection
		curl_close($ch);

		return self::parseResult($response);
	}

	/**
	 * Send the actual HTTP POST to TTPay servers.
	 *
	 * @return mixed            Returns the result from json_decode of TTPay's response
	 * @throws TTPaymentsException   Error sending HTTP POST
	 */
	protected static function doTTPayPost($url, $fields) {

		// initialize cURL
		$ch = curl_init();

		$fields_string = http_build_query($fields);

		// set options for cURL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		// execute HTTP POST request
		$response = curl_exec($ch);
		$ch_error = curl_error($ch);
		if ($ch_error) {
			echo $ch_error;
			die();
		}

		// close connection
		curl_close($ch);

		return self::parseResult($response);
	}

	/**
	 * Send the actual HTTP PUT to TTPay servers.
	 *
	 * @return mixed            Returns the result from json_decode of TTPay's response
	 * @throws TTPaymentsException   Error sending HTTP POST
	 */
	protected static function doTTPayPut($url, $fields) {

		// initialize cURL
		$ch = curl_init();

		$fields_string = http_build_query($fields);

		// set options for cURL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		// execute HTTP POST request
		$response = curl_exec($ch);
		$ch_error = curl_error($ch);
		if ($ch_error) {
			echo $ch_error;
			die();
		}

		// close connection
		curl_close($ch);

		return self::parseResult($response);
	}

	/**
	 * Get API URL based on config.
	 * @return string URL for TTPay service
	 */
	protected static function _getURL($config, $service) {
		if (isset($config['SANDBOX']) && $config['SANDBOX']) {
			$_BASE_URL = self::TTPAY_URL_BASE_SANDBOX;
		} else {
			$_BASE_URL = self::TTPAY_URL_BASE;
		}

		switch ($service) {
			case 'account_registration':
				return $_BASE_URL . 'account_registration';
			default:
				break;
		}
	}

	/**
	 * Get API URL based on config.
	 * @return string URL for TTPay service
	 */
	protected static function _getAPIURL($config, $service) {
		if (isset($config['SANDBOX']) && $config['SANDBOX']) {
			$_BASE_URL = self::TTPAY_API_URL_BASE_SANDBOX;
		} else {
			$_BASE_URL = self::TTPAY_API_URL_BASE;
		}

		switch ($service) {
			case 'accounts':
				return $_BASE_URL . 'accounts/';
			case 'accounts_status':
				return $_BASE_URL . 'accounts/status/';
			case 'transaction':
				return $_BASE_URL . 'transactions/';
			case 'transactions':
				return $_BASE_URL . 'users/';
			case 'payments_validate':
				return $_BASE_URL . 'payments/validate/';
			default:
				break;
		}
	}

	/**
	 * Throw TTPaymentsException if there are errors.
	 *
	 * @return mixed          		 Returns the result from json_decode of TTPay's response
	 * @throws TTPaymentsException   Error sending HTTP POST
	 */
	private static function parseResult($response) {
		$result = json_decode($response);

		if (is_null($result)) {
			return $response;
		}

		return $result;
	}

}
?>