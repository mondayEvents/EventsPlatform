<?php

namespace App\Model\Strategy\Context;


use App\Model\Contract\RegistrationInterface;
use App\Model\Strategy\TotalByActivityStrategy;
use App\Model\Strategy\TotalByEventStrategy;
use Cake\Datasource\EntityInterface;

abstract class PaymentContext implements RegistrationInterface
{
    private static $_strategy;
    private static $_pool;

    public static function set(string $strategy)
    {
        if (!isset(self::$_pool[$strategy])) {
            switch ($strategy) {
                case '0':
                    self::$_pool[$strategy] = new TotalByEventStrategy();
                    break;

                case '1':
                    self::$_pool[$strategy] = new TotalByActivityStrategy();
                    break;

                default:
                    throw new \Exception('Invalid Payment Strategy');
            }
        }

        self::$_strategy = self::$_pool[$strategy];
    }


    /**
     * @param EntityInterface $event
     * @param $activities
     * @return float
     * @throws \Exception
     */
    public static function calculateTotal(EntityInterface $event, $activities): float
    {
        if (empty(self::$_strategy)) {
            throw new \Exception('You must set an strategy for payment first!');
        }

        return self::$_strategy::calculateTotal($event, $activities);
    }
}