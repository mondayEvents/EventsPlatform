<?php
namespace App\Model\Strategy;

use App\Model\Contract\RegistrationInterface;
use Cake\Datasource\EntityInterface;

class TotalByActivityStrategy implements RegistrationInterface
{
    /**
     * @param EntityInterface $event
     * @param $activities
     * @return float
     */
    public static function calculateTotal(EntityInterface $event, $activities): float
    {
        $activities_total = 0;

        foreach ($activities as $activity) {
            $activities_total += $activity->price;
        }

        return $activities_total;
    }

}