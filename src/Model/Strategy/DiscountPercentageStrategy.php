<?php
namespace App\Model\Strategy;

use App\Model\Contract\CouponInterface;

class DiscountPercentageStrategy implements CouponInterface
{
    public static function calculateDiscount(float $initial_value, float $discount): float
    {
        return $initial_value * ($discount/100);
    }
}