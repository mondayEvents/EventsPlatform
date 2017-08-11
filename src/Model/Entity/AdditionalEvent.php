<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AdditionalEvent Entity
 *
 * @property string $super_event_id
 * @property string $event_id
 *
 * @property \App\Model\Entity\Event $event
 */
class AdditionalEvent extends Entity
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
        'super_event_id' => false,
        'event_id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'super_event_id',
        'event_id'
    ];
}
