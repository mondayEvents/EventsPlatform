<?php


namespace App\Model\Table;


use App\Database\Enum\AssociationRequestStatusEnum as Status;
use App\Listener\AssociationRequestListener;
use App\Model\Entity\AssociationRequest;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Exception\PersistenceFailedException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;
use Cake\Event\Event;
use MongoDB\Driver\Exception\AuthenticationException;

/**
 * AssociationRequests Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 * @property |\Cake\ORM\Association\BelongsTo $EventParents
 *
 * @method \App\Model\Entity\AssociationRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\AssociationRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AssociationRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssociationRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssociationRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AssociationRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssociationRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class AssociationRequestsTable extends Table implements EventListenerInterface
{

    /**
     * Initialize Schema method.
     * Any custom type must be mapped here.
     *
     * @param TableSchema $schema
     * @return TableSchema
     */
    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->columnType('status', 'AssociationRequestType');
        return $schema;
    }

    /**
     * Initialize method.
     * Any relationship, component or custom setup
     * must be place here.
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('association_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('EventParents', [
            'className' => 'Events',
            'foreignKey' => 'event_parent_id',
            'joinType' => 'INNER'
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
            ->uuid('user')
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');

        $validator
            ->uuid('event')
            ->requirePresence('event_id', 'create')
            ->notEmpty('event_id');

        $validator
            ->uuid('event_parent')
            ->requirePresence('event_parent_id', 'create')
            ->notEmpty('event_parent_id');

        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

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
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        $rules->add($rules->existsIn(['event_parent_id'], 'EventParents'));

        return $rules;
    }

    /**
     * Get all pending association requests for events
     * created by the user
     *
     * @param string $user_id
     * @return AssociationRequest[]
     */
    public function getAssociationRequests($user_id)
    {
       $associationRequests = $this->find()
           ->where(['AssociationRequests.status' => Status::getNameByValue(Status::PENDING)])
           ->innerJoinWith('EventParents', function ($q) use ($user_id) {
               return $q->where(['EventParents.user_id' => $user_id]);
           })
           ->contain(['Events', 'EventParents'])
           ->toArray();

       return $associationRequests;
    }
}
