<?php

/**
 * Provides acccess to Account-related TTPay API.
 *
 * This requires TTPay *RESELLER* API KEY and API SECRET.
 *
 * Currently, includes:
 *  - Create new account
 *  - Get account status
 *
 */
class AccountService extends HTTPService {

	public function __construct() {
		parent::__construct();
	}

	public static function createAccount($config, $account_details) {

		if (!isset($account_details['email'])) {
			throw new Exception('Invalid email.');
		}

		// prepare HTTP POST variables
		$fields = array(
			'api_key' => $config['RESELLER_API_KEY'],
			'signature' => self::_generateSignature($config, $account_details['email'])
		);
		$fields = array_merge($account_details, $fields);

		// do the actual post to TTPay servers
		$result = self::doTTPayPost(self::_getAPIURL($config, 'accounts'), $fields);

		if (isset($result->{'API_KEY'})) {
			$result->{'complete_registration_link'} = self::_getURL($config, 'account_registration') . '/' . $result->{'API_KEY'};
		}

		return $result;
	}

	public static function getAccountStatus($config, $email) {

		if (!isset($email)) {
			throw new Exception('Invalid email.');
		}

		// prepare HTTP GET variables
		$fields = array(
			'api_key' => $config['RESELLER_API_KEY'],
			'signature' => self::_generateSignature($config, $email)
		);
		$fields['email'] = $email;

		// do the actual post to TTPay servers
		$result = self::doTTPayGet(self::_getAPIURL($config, 'accounts_status'), $fields);

		return $result;
	}

	private function _generateSignature($config, $merchant_email) {
		if (!isset($config['RESELLER_API_KEY'])) {
			throw new Exception('Invalid Reseller API KEY.');
		}
		if (!isset($config['RESELLER_API_SECRET'])) {
			throw new Exception('Invalid Reseller API SECRET.');
		}
		$signature = sha1($config['RESELLER_API_KEY'] . $config['RESELLER_API_SECRET'] . $merchant_email);
		return $signature;
	}

}
?>