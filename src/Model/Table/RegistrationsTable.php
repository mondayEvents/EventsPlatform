<?php
namespace App\Model\Table;

use App\Model\Entity\Event;
use App\Strategy\Registrations\TotalByActivityStrategy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * Registrations Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $RegistrationPayments
 * @property \App\Model\Table\RegistrationItemsTable|\Cake\ORM\Association\HasMany $RegistrationItems
 *
 * @method \App\Model\Entity\Registration get($primaryKey, $options = [])
 * @method \App\Model\Entity\Registration newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Registration[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Registration|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Registration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Registration[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Registration findOrCreate($search, callable $callback = null, $options = [])
 */
class RegistrationsTable extends AppTable
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

        $this->setTable('registrations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

//        $this->addBehavior('Registrations', [
//            'strategy' => new PaymentByActivityStrategy()
//        ]);

        $this->hasOne('RegistrationPayments');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('RegistrationItems', [
            'foreignKey' => 'registration_id'
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->dateTime('when')
            ->requirePresence('when', 'create')
            ->notEmpty('when');

        $validator
            ->integer('is_paid')
            ->requirePresence('is_paid', 'create')
            ->notEmpty('is_paid');

        $validator
            ->decimal('total_paid')
            ->requirePresence('total_paid', 'create')
            ->notEmpty('total_paid');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * @param mixed $activity_ids
     * @param Event $event
     * @return array
     */
    public function activitiesFinder ($activity_ids, Event $event)
    {
        if (empty($activity_ids)) {
            return [];
        }

        $event_ids[] = $event->id;
        foreach ($event->sub_events as $event) {
            $event_ids[] = $event->id;
        }

        return $this->RegistrationItems->Activities->find()
            ->where(['Activities.id IN' => $activity_ids])
            ->andWhere(['Activities.event_id IN' => $event_ids])
            ->all();
    }
}
