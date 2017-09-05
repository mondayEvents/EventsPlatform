<?php
namespace App\Model\Table;

use App\Model\Entity\Event;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Events Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\HasMany $Activities
 * @property \App\Model\Table\CouponsTable|\Cake\ORM\Association\HasMany $Coupons
 * @property \App\Model\Table\AdditionalEventsTable|\Cake\ORM\Association\HasMany $AdditionalEvents
 * @property \App\Model\Table\EventManagersTable|\Cake\ORM\Association\HasMany $EventManagers
 * @property \App\Model\Table\EventManagersTable|\Cake\ORM\Association\HasMany $EventPlaces
 * @property \App\Model\Table\RegistrationsTable|\Cake\ORM\Association\HasMany $Registrations
 * @property \App\Model\Table\SponsorshipsTable|\Cake\ORM\Association\HasMany $Sponsorships
 * @property \App\Model\Table\AssociationRequestsTable|\Cake\ORM\Association\HasMany $AssociationRequests
 *
 * @method \App\Model\Entity\Event get($primaryKey, $options = [])
 * @method \App\Model\Entity\Event newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Event[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event findOrCreate($search, callable $callback = null, $options = [])
 */
class EventsTable extends AppTable
{
    /**
     * Initialize Schema method
     *
     * @param TableSchema $schema
     * @return TableSchema
     */
    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->columnType('type', 'EventType');
        $schema->columnType('status', 'EventStatusType');
        return $schema;
    }

    /**
     * Initialize ORM configs
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('events');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Tags');

        $this->hasMany('Activities');
        $this->hasMany('Coupons');
        $this->hasMany('EventManagers');
        $this->hasMany('AssociationRequests');
        $this->hasMany('EventPlaces');
        $this->hasMany('Registrations');
        $this->hasMany('Companies');

        $this->belongsToMany('SubEvents', [
            'className' => 'Events',
            'joinTable'=>'event_subevents',
            'foreignKey' => 'event_id',
            'targetForeignKey' => 'subevent_id'
        ]);
        $this->hasMany('AssociationRequestParents', [
            'className' => 'AssociationRequests',
            'foreignKey' => 'event_parent_id'
        ]);
        $this->hasMany('Tracks');
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
            ->requirePresence('name')
            ->notEmpty('name');

        $validator
            ->requirePresence('date_start')
            ->dateTime('date_start')
            ->notEmpty('date_start')
            ->add('date_start', '_notPast', [
                'rule' => function ($date, $context) {
                    $is_past = Time::createFromFormat('Y-m-d H:i:s', $date, 'UTC')->isPast();
                    if ($is_past) {
                        return false;
                    }
                    return true;
                },
                'message' => 'The Activity start must be in the future'
            ]);

        $validator
            ->requirePresence('date_end')
            ->dateTime('date_end')
            ->notEmpty('date_end')
            ->add('end_at', '_biggerThanStart', [
                'rule' => function ($end_at, $request) {
                    if ($end_at <= $request['data']['date_start']) {
                        return false;
                    }
                    return true;
                },
                'message' => 'The Activity end must be bigger than its start'
            ]);

        $validator
            ->requirePresence('pay_by_activity')
            ->notEmpty('pay_by_activity')
            ->add('pay_by_activity', 'boolean', [
                'rule' => 'boolean'
            ]);

        $validator
            ->requirePresence('pay_by_activity')
            ->notEmpty('type');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

    /**
     * Returns all children from given event
     * @param string $event_id
     * @return \Cake\Datasource\ResultSetInterface|null
     */
    public function getEventChildren (string $event_id)
    {
        return $this->Subevents->find()->where(['Subevents.event_id' => $event_id])->all();
    }

    public function viewDetails($event_id)
    {
        $activity_associations = [
            'Speakers',
            'EventPlaces',
            'Tracks'
        ];

        return $this->get($event_id, ['contain' => [
                'Users',
                'Coupons',
                'SubEvents' => ['Activities' => $activity_associations],
                'Registrations',
                'Companies',
                'Activities' => $activity_associations
            ]
        ]);
    }
}