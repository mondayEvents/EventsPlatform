<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;

/**
 * Events Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\HasMany $Activities
 * @property \App\Model\Table\CouponsTable|\Cake\ORM\Association\HasMany $Coupons
 * @property \App\Model\Table\EventAssociationsTable|\Cake\ORM\Association\HasMany $EventAssociations
 * @property \App\Model\Table\EventManagersTable|\Cake\ORM\Association\HasMany $EventManagers
 * @property \App\Model\Table\RegistrationsTable|\Cake\ORM\Association\HasMany $Registrations
 * @property \App\Model\Table\SponsorshipsTable|\Cake\ORM\Association\HasMany $Sponsorships
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
        return $schema;
    }

    /**
     * Initialize method
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
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Activities', [
            'foreignKey' => 'event_id'
        ]);
        $this->hasMany('Coupons', [
            'foreignKey' => 'event_id'
        ]);

        $this->hasMany('AdditionalEvents', [
            'className' => 'AdditionalEvents',
            'foreignKey' => 'super_event_id',
            'joinTable' => 'additional_events',
        ]);

        $this->hasMany('EventManagers', [
            'foreignKey' => 'event_id'
        ]);
        $this->hasMany('Registrations', [
            'foreignKey' => 'event_id'
        ]);
        $this->hasMany('Sponsorships', [
            'foreignKey' => 'event_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->dateTime('date_start')
            ->notEmpty('date_start')
            ->add('date_start', '_notPast', [
                'rule' => [$this, 'notPast'],
                'message' => 'The Activity start must be in the future'
            ]);

        $validator
            ->dateTime('date_end')
            ->notEmpty('date_end')
            ->add('end_at', '_biggerThanStart', [
                'rule' => [$this, 'biggerThanStart'],
                'message' => 'The Activity end must be bigger than its start'
            ]);

        $validator
            ->allowEmpty('tags');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }
    
    /**
     * Checks the start_at/end_at integrity
     *
     * @param string $end_at
     * @param array $request
     * @return bool
     */
    public function biggerThanStart ($end_at, $request)
    {
        if ($end_at <= $request['data']['date_start']) {
            return false;
        }
        return true;
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
}
