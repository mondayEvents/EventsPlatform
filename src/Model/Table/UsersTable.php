<?php
namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\Network\Exception\BadRequestException;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Users Model
 *
 * @property \App\Model\Table\GroupsTable|\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\HasMany $Events
 * @property \App\Model\Table\RegistrationsTable|\Cake\ORM\Association\HasMany $Registrations
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Acl.Acl', [
            'type'      => 'requester',
            'enabled'   => false
        ]);

        $this->belongsToMany('Tags', [
            'joinTable' => 'users_tags',
        ]);
        $this->belongsToMany('Tracks', [
            'joinTable' => 'track_coordinators',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'track_id'
        ]);
        $this->belongsToMany('Activities', [
            'joinTable' => 'attendees',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'activity_id'
        ]);

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Events', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Registrations', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('username','create')
            ->notEmpty('username')
            ->add('username', 'validFormat', [
                'rule' => ['custom', '/^\S+@\S+$/'],
                'message' => 'Invalid email format'
            ])
            ->add('username', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => __('This email is already in use!')
            ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password')
            ->add('password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'Your password needs to be at least 6 characters long',
                ]
            ]);

        $validator
            ->requirePresence('name')
            ->notEmpty('name')
            ->add('name', 'validFormat', [
                'rule' => ['custom', '/^[\p{L}\s]+$/'],
                'message' => 'Invalid characters'
            ])
            ->add('name', [
                'length' => [
                    'rule' => ['minLength', 3],
                    'message' => 'Your name needs to be at least 3 characters long',
                ]
            ]);

        $validator
            ->dateTime('birthdate')
            ->requirePresence('birthdate', 'create')
            ->notEmpty('birthdate');

        $validator
            ->allowEmpty('tags');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['groups_id'], 'Groups'));

        return $rules;
    }

    /**
     * Checks if user is logged and throws exeception if it is.
     *
     * @param null|array $is_logged
     * @throws BadRequestException When user is logged
     */
    public function cantBeLogged($is_logged)
    {
        if (!is_null($is_logged)) {
            throw new BadRequestException(__("You are already registered or logged in!"));
        }
    }
}
