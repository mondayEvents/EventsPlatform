<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Track Entity
 *
 * @property string $id
 * @property string $events_id
 * @property string $name
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\TrackCoordinator[] $track_coordinators
 */
class Track extends Entity
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

    public function setManagers ($managers)
    {
        if (empty($this->users)) {
            $this->users = [];
        }

        $this->users[] = $managers;
    }
}
