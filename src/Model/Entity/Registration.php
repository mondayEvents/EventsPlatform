<?php
namespace App\Model\Entity;

use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\Entity;

/**
 * Registration Entity
 *
 * @property string $id
 * @property string $event_id
 * @property string $user_id
 * @property \Cake\I18n\FrozenTime $when
 * @property int $is_paid
 * @property float $total_paid
 *
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\RegistrationItem[] $registration_items
 * @property \App\Model\Entity\RegistrationPayment $registration_payment
 */
class Registration extends Entity
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
        '*' => false,
        'id' => false,
        'registration_items',
        'coupons'
    ];

    /**
     * @param Event $event
     * @param array $items
     * @param User $user
     * @param RegistrationPayment $payment
     * @param object $user_coupons
     * @throws \Exception When the event is per activity and user havent chose one
     */
    public function newRegistration (
        Event $event,
        array $items,
        RegistrationPayment $payment,
        User $user,
        $user_coupons
    ) {
        $this->isNew(true);
        $this->user = $user;

        if (empty($items) && $event->pay_by_activity) {
            throw new \Exception(__('You must choose at least one valid activity to be registered!'));
        }

        $payment->calculatePayment($items, $event, $user_coupons);
        $this->registration_payment = $payment;

        $event->setRegistration($this);
    }

    /**
     * @param User $manager_user
     */
    public function acceptPayment (User $manager_user)
    {
        if (!$this->event->isOwnedBy($manager_user)) {
            throw new UnauthorizedException(__('You dont have permission to perform this action'));
        }

        if ($this->registration_payment->status !== 0) {
            throw new UnauthorizedException(__('Someone managed this registration already'));
        }

        $this->registration_payment->status = 1;
        $this->registration_payment->managed_by = $manager_user->id;
        $this->registration_payment->payment_date = (new \DateTime())->getTimestamp();

        $this->setDirty('registration_payment', true);
    }
}