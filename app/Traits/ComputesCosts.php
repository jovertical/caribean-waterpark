<?php

namespace App\Traits;

trait ComputesCosts 
{
    public function computeItemCosts(array $reservation_settings, array $items, float $deductable = null)
    {
        $vat_rate = 12;

        foreach ($items as $index => $item) {
            $price_taxable = $item->price / $vat_rate;
            $price_subpayable = $item->price;
            $price_deductable = 0.00;
            $price_payable = $item->price - $price_deductable;

            $item->costs = [
                'price_taxable'         => $price_taxable,
                'price_subpayable'      => $price_subpayable,
                'price_deductable'      => $price_deductable,
                'price_payable'         => $price_payable
            ];
        }

        $price_taxable = array_sum(array_column(array_column($items, 'costs'), 'price_taxable'));
        $price_subpayable = array_sum(array_column(array_column($items, 'costs'), 'price_subpayable'));
        $price_deductable = 0.00;
        $price_payable = $price_subpayable - $price_deductable;
        $price_partial_payable = $price_payable / $reservation_settings['partial_payment_rate']; 

        return [
            'price_taxable'         => $price_taxable,
            'price_subpayable'      => $price_subpayable,
            'price_deductable'      => $price_deductable,
            'price_payable'         => $price_payable,
            'price_partial_payable' => $price_partial_payable,
        ];
    }
}