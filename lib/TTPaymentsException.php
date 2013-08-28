<?php

class TTPaymentsException extends Exception {

	const SUCCESS = 'success_ok';

	/* Generic error codes */
	const INVALID_HTTP_METHOD = 'error_invalid_http_method';
	const MISSING_PARAMS = 'error_param_missing';
	const MALFORMED_PARAMS = 'error_malformed_params';
	const INVALID_ACCESS_TOKEN = 'error_invalid_access_token';
	const INVALID_APP_ID = 'error_invalid_app_id';
	const TAG_INVALID_LENGTH = 'error_tag_invalid_length';
	const INVALID_NOTIFY_URL = 'error_invalid_notify_url';
	const UNABLE_TO_RESOLVE_NOTIFY_URL = 'error_unable_to_resolve_notify_url';
	const INSUFFICIENT_CREDIT = 'error_insufficient_credit';
	const RATE_LIMIT_EXCEEDED = 'error_rate_limit_exceeded';
	const INTERNAL_SERVER_ERROR = 'error_internal_server_error';
	const INVALID_TXN_REF = 'error_invalid_txn_ref';
	const NOT_ALLOWED_FOR_TRIAL = 'error_not_allowed_for_trial';

	protected $status = '';

	public function __construct($status) {
		if (strpos($status, '_param_missing') !== false) {
			$this->status = self::MISSING_PARAMS;
		} else {
			$this->status = $status;
		}

		parent::__construct($status);
	}

	public function getStatus() {
		return $this->status;
	}

}
