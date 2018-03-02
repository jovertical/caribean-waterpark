<?php

namespace App\Traits;

trait ComputesCosts {

    public function computeItemCosts(array $items, float $deductable = null)
    {
        $vat_rate = 12;

        foreach ($items as $index => $item) {
            $price_taxable = $item->order_price / $vat_rate;
            $price_deductable = 0.00;
            $price_payable = $item->order_price - $price_deductable;

            $item->costs = [
                'price_taxable'     => $price_taxable,
                'price_deductable'  => $price_deductable,
                'price_payable'     => $price_payable
            ];
        }

        $price_taxable = array_sum(array_column($items, 'price_taxable'));
        $price_subtotal = array_sum(array_column($items, 'order_price'));
        $price_deductable = 0.00;
        $price_payable = $price_subtotal - $price_deductable;

        return [
            'price_taxable'     => $price_taxable,
            'price_subtotal'    => $price_subtotal,
            'price_deductable'  => $price_deductable,
            'price_payable'     => $price_payable
        ];
    }
}