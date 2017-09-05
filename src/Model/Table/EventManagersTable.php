<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * EventManagers Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EventManager get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventManager newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventManager[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventManager|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventManager patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventManager[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventManager findOrCreate($search, callable $callback = null, $options = [])
 */
class EventManagersTable extends AppTable
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

        $this->setTable('event_managers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->dateTime('created_at')
            ->allowEmpty('created_at');

        $validator
            ->dateTime('modified_at')
            ->requirePresence('modified_at', 'update')
            ->notEmpty('modified_at');

        $validator
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');

        $validator
            ->requirePresence('event_id', 'create')
            ->notEmpty('event_id');

        $validator
            ->boolean('active')
            ->allowEmpty('active', 'create');

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
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->isUnique(
            ['user_id', 'event_id'], __('You are already a manager of this event')
        ));

        return $rules;
    }
}
