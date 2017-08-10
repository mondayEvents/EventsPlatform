<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventManager Entity
 *
 * @property string $id
 * @property string $event_id
 * @property string $users_id
 * @property bool $is_active
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\User $user
 */
class EventManager extends Entity
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
