<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegistrationItem Entity
 *
 * @property string $registration_id
 * @property string $activity_id
 * @property float $price
 *
 * @property \App\Model\Entity\Registration $registration
 * @property \App\Model\Entity\Activity $activity
 */
class RegistrationItem extends Entity
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
        'registration_id' => false,
        'activity_id' => false
    ];
}
