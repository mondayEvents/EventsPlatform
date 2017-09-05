<?php
namespace App\Model\Contract;


use Cake\Datasource\EntityInterface;

interface RegistrationInterface
{
    public static function calculateTotal(EntityInterface $event, $activities): float;
}