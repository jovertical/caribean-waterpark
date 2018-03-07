<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalExpress
{
    /**
    * @var ExpressCheckout Instance
    */
    private $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function redirect($reservation)
    {
        $cart = $this->getCheckoutData($reservation);

        return $this->provider->setExpressCheckout($cart, false);
    }

    public function callback($reservation, $token, $payer_id)
    {
        $cart = $this->getCheckoutData($reservation);

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            // Perform transaction on PayPal
            $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $payer_id);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
        }

        return $status;
    }

    protected function getCheckoutData($reservation)
    {
        $items = collect([]);

        $reservation->items->each(function($item) use ($items) {
            $items->push([
                'name' => $item->name,
                'price' => $item->price,
                'qty' => $item->quantity
            ]);
        });

        $item_totals = 0;

        foreach ($items as $item) {
            $item_totals += $item['price'] * $item['qty'];
        }

        return [
            'return_url' => route('root.reservations.paypal.callback', $reservation),
            'cancel_url' => route('root.reservations.show', $reservation),
            'invoice_id' => $reservation->reference_number,
            'invoice_description' => 'Transaction #'.$reservation->id,
            'items' => $items->toArray(),
            'total' => $item_totals
        ];
    }
}