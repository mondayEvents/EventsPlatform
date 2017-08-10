<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property string $id
 * @property int $groups_id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property \Cake\I18n\FrozenTime $birthdate
 * @property string $tags
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Event[] $events
 * @property \App\Model\Entity\Registration[] $registrations
 */
class User extends Entity
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
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * Setter for password (hashing)
     *
     * @param $password
     * @return string
     */
    protected function _setPassword ($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    public function parentNode ()
    {
        if (!$this->id) {
            return null;
        }
        if (isset($this->group_id)) {
            $groupId = $this->group_id;
        }
        if (!$groupId) {
            return null;
        }
        return ['Groups' => ['id' => $groupId]];
    }

    public function bindNode ($user)
    {
        return ['model' => 'Groups', 'foreign_key' => $user['Users']['group_id']];
    }

}