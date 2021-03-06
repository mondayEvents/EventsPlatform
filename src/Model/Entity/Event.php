<?php
namespace App\Model\Entity;

use App\Database\Enum\EventStatusEnum as Status;
use App\Model\Strategy\Context\PaymentContext;
use Cake\Core\Exception\Exception;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\Entity;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\Utility\Hash;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Event Entity
 *
 * @property string $id
 * @property string $user_id
 * @property $parent_id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $date_start
 * @property \Cake\I18n\FrozenTime $date_end
 * @property $type
 * @property $status
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Coupon[] $coupons
 * @property \App\Model\Entity\Event[] $sub_events
 * @property \App\Model\Entity\Registration[] $registrations
 * @property \App\Model\Entity\Sponsorship[] $sponsorships
 * @property \App\Model\Entity\EventManager[] $event_managers
 * @property \App\Model\Entity\EventPlace[] $event_places
 * * @property \App\Model\Entity\Tag[] $tags
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
        'parent_id' => false,
        'tags' => false,
        'user' => false,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
     protected $_hidden = [
        'user_id',
        'parent_id'
    ];

        /**
     * Returns if user is owner or not of the event
     *
     * @param User $user
     * @return bool
     */
     public function isOwnedBy(User $user): bool
     {
         if ($user->id === $this->user->id) {
             return true;
         }
 
         if (!$this->event_managers) {
             return false;
         }
 
         $user_ids = array_column($this->event_managers,'user_id');
         return array_search($user->id, $user_ids, true) !== false;
     }


    /**
     * Adds an event as a child of another event (subevents concept)
     *
     * @param Event $parent
     * @param User $user
     * @throws NotFoundException|PersistenceFailedException
     */
    public function setParent (Event $parent, User $user)
    {
        if (!empty($this->parent_id) && ($this->parent_id !== $parent->id)) {
            throw new LogicException('It seems that the asker event is already associated to another event');
        }

        $save_as_manager = true;
        foreach ($this->event_managers as $event_manager) {
            if ($event_manager->event_id == $this->id && $event_manager->user_id == $user->id) {
                $save_as_manager = false;
            }
        }

        if ($save_as_manager) {
            $this->event_managers = array_push($this->event_managers, $user);
        }
        $this->parent_id = $parent->id;
    }

    /**
     * @param EventManager $manager
     */
     public function setManager(EventManager $manager)
     {
         if (is_null($this->event_managers)) {
             $this->event_managers = [];
         }
 
         $this->event_managers[] = $manager;
         $this->setDirty('event_managers', true);
     }

    /**
     * @return int
     */
    public function hasSubEvents ()
    {
        return count($this->sub_events);
    }


    /**
     * Makes sure the event is accepting new registers
     *
     * @throws Exception When event is in progress, closed or unpublished
     */
     public function opennessChecker ()
     {
         if (($this->status !== Status::getNameByValue(Status::NEW)) &&
             ($this->status !== Status::getNameByValue(Status::OPEN))
         ) {
             throw new Exception('The Event is not open to new registers');
         }
     }
 
     public function getAutoCoupons ()
     {
 
         $coupons = [];
         foreach ($this->coupons as $coupon) {
             if ($coupon->automatic) {
                 $coupons[] = $coupon;
             }
         }
         return $coupons;
     }

     
    public function setRegistration (Registration $registration)
    {
        $this->opennessChecker();

        foreach ($this->registrations as $reg) {
            if ($reg->user_id == $registration->user->id) {
                throw new \Exception(__('You are already registered to this event'));
            }
        }

        $registration->isNew(true);
        $this->registrations[] = $registration;
        $this->setDirty('registrations', true);
    }


    public function matchActivity ($activity_ids)
    {
        $activities = $this->getAllActivitiesAvailable();

        $exist_activities = [];
        foreach ($activities as $activity) {
            foreach ($activity_ids as $key => $item) {
                if ($activity->id == $item) {
                    array_push($exist_activities, $activity);
                }
            }
        }
        $exist_activities = array_unique($exist_activities);
        if (count($activities) > count($exist_activities)) {
            throw new \Exception(__('One or more actitivities were not found'));
        }

        return $exist_activities;
    }


    public function getAllActivitiesAvailable ()
    {
        $subactivities = function () {
            $activities = [];
            foreach ($this->sub_events as $event) {
                foreach ($event->activities as $activity) {
                    $activities[] = $activity;
                }
            }
            return $activities;
        };
        return Hash::merge($subactivities(), $this->activities);
    }

    public function addEventPlace (EventPlace $place, User $user)
    {
        if (!$this->isOwnedBy($user)) {
            throw new UnauthorizedException(__('You are not allowed to perform this action'));
        }

        $this->event_places[] = $place;
        $this->setDirty('event_places', true);
    }


    public function setCoupon (Coupon $coupon, User $user)
    {
        $this->mustBeOwner($user);

        if (empty($this->coupons)) {
            $this->coupons = [];
        }

        $this->coupons[] = $coupon;
        $this->setDirty('coupons', true);
    }

    public function setCompany(Company $company, $user)
    {
        $this->mustBeOwner($user);

        if (empty($this->companies)) {
            $this->companies = [];
        }
        $this->companies[] = $company;
    }

    /**
     * @param $user
     * @throws \Exception
     */
    public function mustBeOwner($user)
    {
        if (!$this->isOwnedBy($user)) {
            throw new \Exception(__('You do not own this event!'));
        }
    }

    public function setTrack(Track $track, User $user)
    {
        $this->mustBeOwner($user);

        if (empty($this->tracks)) {
            $this->tracks = [];
        }
        $this->tracks[] = $track;
    }

    public function isRegistered (User $user)
    {
        $registered = false;
        foreach ($this->registrations as $registration) {
            if ($registration->user_id == $user->id) {
                $registered = true;
            }
        }

        if (!$registered) {
            throw new \Exception(__('This user is not registered to the event'));
        }
    }
    
}
