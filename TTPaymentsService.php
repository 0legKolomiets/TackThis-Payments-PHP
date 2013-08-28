<?php

require_once __DIR__ . '/lib/HTTPService.php';
require_once __DIR__ . '/lib/AccountService.php';
require_once __DIR__ . '/lib/PaymentService.php';
require_once __DIR__ . '/lib/TransactionService.php';
require_once __DIR__ . '/lib/TransactionStatus.php';

/**
 * Public interface to access TTPay API.
 * Use this class to do your stuffs.
 *
 * E.g.
 * $config['API_KEY'] = "myApiKey";
 * $config['API_SECRET'] = "myApiSecret";
 * $config['SANDBOX'] = TRUE;
 * 
 * $ttpay = new TTPayService($config);
 * $results = $ttpay->getTransactions($fields);
 * 
 * echo json_encode($results);
 *
 */
class TTPayService {
	/* developer credentials */

	public function __construct($config) {
		$this->CONFIG = array();
		if (isset($config['API_KEY'])) {
			$this->CONFIG['API_KEY'] = $config['API_KEY'];
		}
		if (isset($config['API_SECRET'])) {
			$this->CONFIG['API_SECRET'] = $config['API_SECRET'];
		}
		if (isset($config['RESELLER_API_KEY'])) {
			$this->CONFIG['RESELLER_API_KEY'] = $config['RESELLER_API_KEY'];
		}
		if (isset($config['RESELLER_API_SECRET'])) {
			$this->CONFIG['RESELLER_API_SECRET'] = $config['RESELLER_API_SECRET'];
		}
		if (isset($config['EMAIL'])) {
			$this->CONFIG['EMAIL'] = $config['EMAIL'];
		}
		if (isset($config['SANDBOX'])) {
			$this->CONFIG['SANDBOX'] = filter_var($config['SANDBOX'], FILTER_VALIDATE_BOOLEAN) ? TRUE : FALSE;
		}
	}

	public function accountCreate($account_details) {
		return AccountService::createAccount($this->CONFIG, $account_details);
	}

	public function getAccountStatus($email) {
		return AccountService::getAccountStatus($this->CONFIG, $email);
	}

	public function getTransaction($fields) {
		return TransactionService::getTransaction($this->CONFIG, $fields);
	}

	public function updateTransaction($fields) {
		return TransactionService::updateTransaction($this->CONFIG, $fields);
	}

	public function getTransactions($fields) {
		return TransactionService::getMerchantTransactions($this->CONFIG, $fields);
	}

	public function validatePayment($fields) {
		return PaymentService::validatePayment($this->CONFIG, $fields);
	}

}

?>