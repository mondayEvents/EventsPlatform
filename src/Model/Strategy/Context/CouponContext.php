<?php
namespace App\Model\Strategy\Context;

use App\Model\Contract\CouponInterface;
use App\Model\Strategy\DiscountFixedStrategy;
use App\Model\Strategy\DiscountPercentageStrategy;

abstract class CouponContext implements CouponInterface
{
    private static $_strategy;
    private static $_pool;

    public static function set(string $strategy)
    {
        if (!isset(self::$_pool[$strategy])) {
            switch ($strategy) {
                case '0':
                    self::$_pool[$strategy] = new DiscountFixedStrategy();
                    break;

                case '1':
                    self::$_pool[$strategy] = new DiscountPercentageStrategy();
                    break;

                default:
                    throw new \Exception('Invalid Coupon Discount Strategy');
            }
        }

        self::$_strategy = self::$_pool[$strategy];
    }

    /**
     * @param float $initial_value
     * @param float $discount
     * @return float
     * @throws \Exception
     */
    public static function calculateDiscount (float $initial_value, float $discount): float
    {
        if (empty(self::$_strategy)) {
            throw new \Exception('You must set an strategy coupon discount first!');
        }

        return self::$_strategy::calculateDiscount($initial_value, $discount);
    }


}