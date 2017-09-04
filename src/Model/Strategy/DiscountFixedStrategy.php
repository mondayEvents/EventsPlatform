<?php
namespace App\Model\Strategy;

use App\Model\Contract\CouponInterface;

class DiscountFixedStrategy implements CouponInterface
{

    public static function calculateDiscount(float $initial_value, float $discount): float
    {
        $final_price = $initial_value - $discount;
        return (($final_price) > 0) ? $discount : ($initial_value - $final_price);
    }
}