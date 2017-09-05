<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity
 *
 * @property string $id
 * @property string $event_id
 * @property string $user_id
 * @property string $panelist_id
 * @property string $theme_id
 * @property string $event_places_id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property $type
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\Panelist $panelist
 * @property \App\Model\Entity\Theme $theme
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\EventPlace $event_place
 * @property \App\Model\Entity\ActivityPlace[] $activity_places
 * @property \App\Model\Entity\Concomitance[] $concomitance
 * @property \App\Model\Entity\RegistrationItem[] $registration_items
 */
 
class Activity extends Entity
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
        'event_id' => false,
        'id' => false
    ];

    public function setAttendee ($attendee, $activity, $manager)
    {
        $activity->event->mustBeOwner($manager);
        $registration_id = $activity->event->isRegistered($attendee);
        $activity->isRegistered($registration_id);

        if (empty($this->users)) {
            $this->users = [];
        }
        $this->users[] = $attendee;
    }

    public function isRegistered ($registration_id)
    {
        $registered = false;
        foreach ($this->event->registrations->registration_items as $item) {
            if ($item->registration_id == $registration_id) {
                $registered = true;
            }
        }

        if (!$registered) {
            throw new \Exception(__('This user is not registered to this activity'));
        }
    }

}
