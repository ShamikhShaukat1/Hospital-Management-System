<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class BillingTest extends TestCase
{
    /** Test subtotal, tax and discount calculation formula */
    public function test_invoice_calculation_logic(): void
    {
        $items = [
            ['qty' => 1, 'price' => 120.00], // Doctor fee
            ['qty' => 3, 'price' => 100.00], // 3 days room stay
            ['qty' => 2, 'price' => 15.00],  // 2 medicines
        ];

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += ($item['qty'] * $item['price']);
        }

        $this->assertEquals(450.00, $subtotal);

        $discount = 50.00;
        $tax = 20.00;
        $total = max(0, $subtotal - $discount + $tax);

        $this->assertEquals(420.00, $total);

        // Test payment allocation
        $payment1 = 200.00;
        $balance1 = $total - $payment1;
        $this->assertEquals(220.00, $balance1);

        $payment2 = 220.00;
        $balance2 = $balance1 - $payment2;
        $this->assertEquals(0.00, $balance2);
    }
}
