<?php

use PaymentExpress\Merchant;
use PaymentExpress\User;

$merchant = new Merchant(123, 'token');

$pay = $merchant->createPayment(100);
$pay->addDescription('desc')
    ->addOrderId('orderId')
	->addPayload([1 => 2])
	->addGateway('card')
	->addSuccessUrl('tg://')
	->addFailUrl('tg://')
	->addCustom('merchant_name', 'Test')
	->addCustom('sms_merchant', 'Test')
	->addCustom('sms_description', 'Test');

echo $pay->getUrl();

////////
$user = new User('id', 'token_api');

echo $user->getBalance(true);