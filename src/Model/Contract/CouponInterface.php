<?php
namespace App\Model\Contract;


interface CouponInterface
{
    public static function calculateDiscount(float $initial_value, float $discount): float;
}