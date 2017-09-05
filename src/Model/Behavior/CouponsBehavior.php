<?php
namespace App\Model\Behavior;

use App\Model\Contract\CouponInterface;
use Cake\ORM\Behavior;

class CouponsBehavior extends Behavior implements CouponInterface
{
    private $_strategy;
    private $_pool;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $this->setContext($config['strategy']);
    }

    public function setContext(CouponInterface $strategy)
    {
        $class_name = get_class($strategy);

        if (!isset($this->_pool[$class_name])) {
            $this->_pool[$class_name] = $strategy;
        }

        $this->_strategy = $this->_pool[$class_name];
    }

    public final function calculateDiscount (float $initial_value, float $discount): float
    {
        return $this->_strategy->calculateDiscount($initial_value, $discount);
    }
}