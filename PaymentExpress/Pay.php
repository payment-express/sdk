<?php

namespace PaymentExpress;

class Pay
{

	protected $data = [];
	protected $merchant;

	public function __construct(Merchant $merchant, float $sum, ?string $orderId = null)
	{
		$this->addAmount($sum);

		if($orderId){
		    $this->addOrderId($orderId);
        }

		$this->merchant = $merchant;
	}

	public function getUrl()
	{

		$data = $this->data;
		$data['merchant_id'] = $this->merchant->id;

		//Подпись
		$sign = $data;
		unset($sign['gateway']);
		$sign = $this->merchant->sign($sign);

		$data['hash'] = $sign;

		return Merchant::DOMAIN . Merchant::DOMAIN_FORM . '?' . http_build_query($data);

	}

	public function addCustom(string $field, $value) : Pay
	{
		$this->data[$field] = $value;
		return $this;
	}


	public function addDescription(string $description) : Pay
	{
		return $this->addCustom('description', $description);
	}

	public function addGateway(string $gateway) : Pay
	{
		return $this->addCustom('gateway', $gateway);
	}

	public function addPayload(array $payload) : Pay
	{
		return $this->addCustom('payload', json_encode($payload));
	}

	public function addSuccessUrl(string $url) : Pay
	{
		return $this->addCustom('success_url', $url);
	}

	public function addFailUrl(string $url) : Pay
	{
		return $this->addCustom('fail_url', $url);
	}

	public function addOrderId(string $order) : Pay
    {
        return  $this->addCustom('order_id', $order);
    }

    public function addAmount(float $sum) : Pay
    {
        return $this->addCustom('amount', $sum);
    }

}
