<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssociationRequest Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $event_id
 * @property string $event_parent_id
 * @property string $message
 * @property int $status
 * @property bool $active
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\Event $event_parent
 */
class AssociationRequest extends Entity
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
