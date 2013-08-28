<?php

/**
 * Possible transaction statuses.
 *
 */
class TransactionStatus {
	/*
	 * Buyer has success login to TTPay but the payment transaction may be incomplete or in progress.
	 */
	const PENDING = 'pending';

	/*
	 * Buyer has sufficient funds in his/her account and the payment transaction had been processed
	 * This status will be automatically changed to "withheld" within a set period of time.
	 * (applicable only for ESCROW type payment)
	 */
	const PAID = 'paid';

	/*
	 * The merchant has shipped/delivered the product. This can be trigger via TTPay console
	 * or via APIs call by the merchant or the shipper.
	 */
	const SHIPPED = 'shipped';

	/*
	 * This is a system set duration where buyer will be able to raise a payment transaction
	 * dispute/request for refund. This status will start immediately after transaction has been
	 * set to "shipped". (applicable only for ESCROW type payment)
	 */
	const WITHHELD = 'withheld';

	/*
	 * Transaction has successfully been completed and buyer did not raise a dispute within
	 * the "withheld" period. The funds are now available for withdrawal by the merchant.
	 * This status can also be linked to the buyer acknowledging that he/she has received his/her
	 * product from the shipper.
	 */
	const COMPLETED = 'completed';

	/*
	 * This transaction has been cancelled. This can be trigger via TTPay
	 * console or APIs Call by both buyer and merchant. Note: This can only be
	 * done before the transaction reach "paid" status.
	 */
	const CANCELLED = 'cancelled';

	/*
	 * Buyer has raised a dispute on a transaction. Merchant needs to reach out
	 * to the buyer and resolve this issue. The funds will be frozen (i.e
	 * transaction will not transit to "completed" status) until this is resolved.
	 */
	const DISPUTE = 'dispute';

	/*
	 * Merchant has refunded the transaction. This can be done via TTPay console
	 * or via APIs call by the merchant.
	 * Note: This can only be done after the transaction reach "paid" status and
	 * before it become "completed".
	 */
	const REFUNDED = 'refunded';

}
?>