<?php
namespace App\Model\Entity;

use Cake\Network\Exception\BadRequestException;
use Cake\ORM\Entity;
use App\Database\Enum\AssociationRequestStatusEnum as Status;
use Cake\ORM\Exception\PersistenceFailedException;

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


    private function _statusVerifier(int $value)
    {
        if ($this->status !== Status::getNameByValue($value)) {
            throw new BadRequestException(
                "This request is " . Status::getNameByValue(Status::getValueByName($this->status)) . " already"
            );
        }
    }

    public function acceptEventAssociation (EventManager $user)
    {
        $this->_statusVerifier(Status::PENDING);
        $this->status = Status::getNameByValue(Status::ACCEPTED);
        $this->event->setManager($user);
        $this->setDirty('event', true);
    }

    public function declineEventAssociation ()
    {
        $this->_statusVerifier(Status::PENDING);
        $this->status = Status::getNameByValue(Status::DECLINED);
    }

    /**
     * Creates the Association Request in order to associate
     * the AskerEvent with the AskedEvent
     *
     * @param User $user
     * @param Event $parent
     * @param Event $sub_event
     * @throws \Exception
     */
    public final function setAssociationRequest (User $user, Event $parent, Event $sub_event, string $message)
    {
        if ($sub_event->hasSubEvents()) {
            throw new \Exception(__('Your event cannot become a subevent because it already has subevents.'));
        }

        if (!$sub_event->isOwnedBy($user)) {
            throw new \Exception(__("You don't own '". $sub_event->name ."' event."));
        }

        if (empty($message)) {
            $message = __("I'd like to be a subevent of your event");
        }

        $this->message = $message;
        $this->event_parent = $parent;
        $this->event = $sub_event;
    }
}
