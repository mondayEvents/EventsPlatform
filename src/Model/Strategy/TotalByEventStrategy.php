<?php
namespace App\Model\Strategy;

use App\Model\Contract\CouponInterface;
use App\Model\Contract\RegistrationInterface;
use Cake\Datasource\EntityInterface;

class TotalByEventStrategy implements RegistrationInterface
{
    /**
     * @param EntityInterface $event
     * @param $activities
     * @return float
     */
    public static function calculateTotal(EntityInterface $event, $activities): float
    {
        $subevents_total = 0;
        foreach ($event->sub_events as $sub_event) {
            $subevents_total += $sub_event->price;
        }

        return $event->price + $subevents_total;
    }

}