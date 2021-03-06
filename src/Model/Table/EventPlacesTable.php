<?php
namespace App\Model\Table;

use App\Model\Entity\EventPlace;
use Cake\Network\Exception\UnauthorizedException;
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

        $this->addBehavior('Tree');
 
        $this->setTable('event_places');
        $this->setDisplayField('name');
        $this->setPrimaryKey(['id']);
 
        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'bindingKey' => 'id',
            'joinType' => 'INNER'
        ]);
 
        $this->hasMany('Activities', [
            'foreignKey' => 'event_place_id',
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
     * @param string $current_user
     * @param string $event_id
     * @param array $data
     * @return EventPlace|\Cake\Datasource\EntityInterface
     *
     * @throws UnauthorizedException If the user doesnt own the event
     */
    public function addEventPlace (string $current_user, string $event_id, array $data)
    {
        $user = $this->Events->Users->get($current_user);
        $event = $this->Events->get($event_id, ['contain' => ['Users']]);
        $place = $this->newEntity($data);

        $event->addEventPlace($place, $user);

        $place = $this->Events->saveOrFail($event);
        return $place;
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
        $rules->add($rules->isUnique(
            ['name', 'event_id'], __('Your event already has a place with that name')
        ));
        $rules->add($rules->existsIn(['events_id'], 'Events'));

        return $rules;
    }
}
