<?php

/**
 * Provides acccess to Transaction-related TTPay API.
 *
 * This requires TTPay *RESELLER* API KEY and API SECRET.
 *
 * Currently, includes:
 *  - Create new account
 *  - Get account status
 *
 */
class TransactionService extends HTTPService {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * With the merchant API Key and Secret, you can obtain a list (max 50 at a
	 * time) of the transactions related to the merchant and informations
	 * regarding them.
	 *
	 * @param mixed $config
	 * @param mixed $fields
	 * @return mixed
	 * @throws Exception
	 */
	public static function getMerchantTransactions($config, $fields) {

		// Required Configurations
		if (!isset($config['API_KEY'])) {
			throw new Exception('Invalid API Key.');
		}
		if (!isset($config['API_SECRET'])) {
			throw new Exception('Invalid API Secret.');
		}

		$params = array(
			'api_key' => $config['API_KEY'],
			'signature' => self::_generateSignature($config)
		);
		if (isset($fields['filter'])) {
			$params['filter'] = $fields['filter'];
		}
		if (isset($fields['before_id'])) {
			$params['before_id'] = $fields['before_id'];
		}

		// do the actual post to TTPay servers
		$result = self::doTTPayGet(self::_getAPIURL($config, 'transactions'), $params);

		return $result;
	}

	public static function getTransaction($config, $fields) {

		if (!isset($config['API_KEY'])) {
			throw new Exception('Invalid API Key.');
		}

		if (!isset($config['API_SECRET'])) {
			throw new Exception('Invalid API Secret.');
		}

		if (!isset($fields['txn_id'])) {
			throw new Exception('Invalid TTPay Transaction ID.');
		}

		// prepare HTTP POST variables
		$params = array(
			'api_key' => $config['API_KEY'],
			'signature' => self::_generateSignature($config)
		);

		// do the actual post to TTPay servers
		$result = self::doTTPayGet(self::_getAPIURL($config, 'transaction') . $fields['txn_id'], $params);

		if ($result == 'Invalid transaction') {
			throw new Exception('Invalid transaction');
		}

		return $result;
	}

	public static function updateTransaction($config, $fields) {

		if (!isset($config['API_KEY'])) {
			throw new Exception('Invalid API Key.');
		}

		if (!isset($config['API_SECRET'])) {
			throw new Exception('Invalid API Secret.');
		}

		if (!isset($fields['txn_id'])) {
			throw new Exception('Invalid TTPay Transaction ID.');
		}

		if (!isset($fields['status'])) {
			throw new Exception('Invalid TTPay Transaction Status.');
		}

		// prepare HTTP POST variables
		$data = array(
			'API_KEY' => $config['API_KEY'],
			'signature' => self::_generateSignature($config)
		);
		if (self::_validateStatus($fields['status'])) {
			$data['status'] = $fields['status'];
		}

		// do the actual post to TTPay servers
		$result = self::doTTPayPut(self::_getAPIURL($config, 'transaction') . $fields['txn_id'], $data);

		if ($result == 'Invalid transaction status change') {
			throw new Exception('Invalid transaction status change');
		}

		return $result;
	}

	private static function _generateSignature($config) {

		if (!isset($config['API_KEY'])) {
			throw new Exception('Invalid Merchant API KEY.');
		}
		if (!isset($config['API_SECRET'])) {
			throw new Exception('Invalid Merchant API SECRET.');
		}
		$signature = sha1($config['API_KEY'] . $config['API_SECRET']);

		return $signature;
	}

	private static function _validateStatus($status) {
		if (!constant('TransactionStatus::' . strtoupper($status))) {
			throw new Exception('Invalid Transaction Status.');
		} else {
			return TRUE;
		}
	}

}
?>