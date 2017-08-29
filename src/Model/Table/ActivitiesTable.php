<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;

/**
 * Activities Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 * @property \App\Model\Table\PanelistsTable|\Cake\ORM\Association\BelongsTo $Panelists
 * @property \App\Model\Table\ThemesTable|\Cake\ORM\Association\BelongsTo $Themes
 * @property \App\Model\Table\EventPlacesTable|\Cake\ORM\Association\BelongsTo $EventPlaces
 * @property \App\Model\Table\ActivityPlacesTable|\Cake\ORM\Association\HasMany $ActivityPlaces
 * @property \App\Model\Table\ConcomitanceTable|\Cake\ORM\Association\HasMany $Concomitance
 * @property \App\Model\Table\RegistrationItemsTable|\Cake\ORM\Association\HasMany $RegistrationItems
 *
 * @method \App\Model\Entity\Activity get($primaryKey, $options = [])
 * @method \App\Model\Entity\Activity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Activity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Activity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activity findOrCreate($search, callable $callback = null, $options = [])
 */
class ActivitiesTable extends AppTable
{

    /**
     * Initialize Schema method
     *
     * @param TableSchema $schema
     * @return TableSchema
     */
    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->columnType('type', 'ActivityType');
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

        $this->setTable('activities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Speakers', [
            'foreignKey' => 'speaker_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tracks', [
            'foreignKey' => 'track_id'
        ]);
        $this->belongsTo('EventPlaces', [
            'foreignKey' => 'event_places_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ActivityPlaces', [
            'foreignKey' => 'activity_id'
        ]);
        $this->hasMany('Concomitance', [
            'foreignKey' => 'activity_id'
        ]);
        $this->hasMany('RegistrationItems', [
            'foreignKey' => 'activity_id'
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
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        $rules->add($rules->existsIn(['panelist_id'], 'Panelists'));
        $rules->add($rules->existsIn(['theme_id'], 'Themes'));
        $rules->add($rules->existsIn(['event_places_id'], 'EventPlaces'));
	$rules->add(new NotSameTimeAndPlace(), '_notSameTimeAndPlace', [
            'errorField' => 'activity',
            'message' =>  __('This place is already in use at the specified time range')
        ]);
	$rules->add(new IsExclusive(), '_isExclusive', [
            'errorField' => 'activity',
            'message' =>  __('An exclusive activity will occur at the selected time range')
        ]);

        return $rules;
    }
}
