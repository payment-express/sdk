<?php

namespace PaymentExpress;

class Merchant {

	const DOMAIN = 'https://payments.express';
	const DOMAIN_FORM = '/api/public/payment/form/';
	const DOMAIN_API = '/api/private/';

	public $id;
	protected $token;

	public function __construct(int $id, string $token)
	{
		$this->id = $id;
		$this->token = $token;
	}

	public function sign(array $data) : string
	{

		$data['token'] = $this->token;
		ksort($data);

		$sign = implode(":", $data);
		$sign = hash('sha256', $sign);
		$sign = strtolower($sign);

		return $sign;

	}

	public function createPayment(float $sum, ?string $order = null) : Pay
	{
		return new Pay($this, $sum, $order);
	}

}
