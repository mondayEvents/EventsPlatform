<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * EventPlaces Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 *
 * @method \App\Model\Entity\EventPlace get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventPlace newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventPlace[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventPlace|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventPlace patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventPlace[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventPlace findOrCreate($search, callable $callback = null, $options = [])
 */
class EventPlacesTable extends AppTable
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

        $this->setTable('event_places');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'events_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('ltd');

        $validator
            ->allowEmpty('lat');

        $validator
            ->allowEmpty('lng');

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
        $rules->add($rules->existsIn(['events_id'], 'Events'));

        return $rules;
    }
}
