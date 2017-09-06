<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegistrationPaymentsCoupon Entity
 *
 * @property string $registration_payment_id
 * @property string $coupon_id
 *
 * @property \App\Model\Entity\RegistrationPayment $registration_payment
 * @property \App\Model\Entity\Coupon $coupon
 */
class RegistrationPaymentsCoupon extends Entity
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
        'registration_payment_id' => false
    ];
}
