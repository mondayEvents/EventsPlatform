<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $date_start
 * @property \Cake\I18n\FrozenTime $date_end
 * @property string $tags
 * @property $type
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Coupon[] $coupons
 * @property \App\Model\Entity\EventAssociation[] $event_associations
 * @property \App\Model\Entity\Registration[] $registrations
 * @property \App\Model\Entity\Sponsorship[] $sponsorships
 * @property \App\Model\Entity\EventManager[] $event_managers
 */
class Event extends Entity
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

    /**
     * Returns if user is owner or not of the event
     *
     * @param $user
     * @return bool
     */
    public function isOwner($user): bool
    {
        if ($user === $this->user_id)
        {
            return true;
        }

        if (!$this->event_managers)
        {
            return false;
        }

        $user_ids = array_column($this->event_managers,'user_id');
        return array_search($user, $user_ids, true) !== false;
    }
}
