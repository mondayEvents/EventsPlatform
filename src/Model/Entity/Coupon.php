<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property string $id
 * @property string $event_id
 * @property string $code
 * @property float $amount
 * @property string $type
 * @property \Cake\I18n\FrozenTime $good_thru
 *
 * @property \App\Model\Entity\Event $event
 */
class Coupon extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
