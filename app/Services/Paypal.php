<?php

namespace App\Services;

use Omnipay\Omnipay;

class Paypal {

    private function gateway()
    {
        $gateway = Omnipay::create('PayPal_Express');

        $gateway->setUsername(config('services.paypal.username'));
        $gateway->setPassword(config('services.paypal.password'));
        $gateway->setSignature(config('services.paypal.signature'));
        $gateway->setTestMode(config('services.paypal.sandbox'));

        return $gateway;
    }

    public static function pay(Paypal $paypal, array $parameters)
    {
        return $paypal->gateway()->purchase($parameters)->send();
    }

    public static function completePayment(Paypal $paypal, array $parameters)
    {
        return $paypal->gateway()->completePurchase($parameters)->send();
    }
}