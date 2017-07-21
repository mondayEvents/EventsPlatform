<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventActivities Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\RegistrationItemsTable|\Cake\ORM\Association\HasMany $RegistrationItems
 *
 * @method \App\Model\Entity\EventActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventActivity findOrCreate($search, callable $callback = null, $options = [])
 */
class EventActivitiesTable extends Table
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

        $this->setTable('event_activities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'events_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RegistrationItems', [
            'foreignKey' => 'event_activity_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->requirePresence('type', 'create')
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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['events_id'], 'Events'));

        return $rules;
    }
}
