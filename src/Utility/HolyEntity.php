<?php
namespace App\Utility;

use Cake\Core\Exception\Exception;
use Cake\ORM\Entity;

class HolyEntity extends Entity
{

    /**
     * This magic setter makes impossible to create or modify class properties
     * without using encapsulation
     *
     * @param string $property The name of the property to set
     * @param mixed $value The value to set to the property
     * @return void
     */
    public function __set($property, $value)
    {
        throw new Exception("You are not allowed to set variables directly. Use set() method instead.");
    }

    /**
     * This magic getter makes impossible to get class properties
     * without using encapsulation
     *
     * @param string $property Name of the property to access
     * @return mixed
     */
    public function &__get($property)
    {
        throw new Exception("You are not allowed to get variables directly. Use get() method instead.");
    }
}