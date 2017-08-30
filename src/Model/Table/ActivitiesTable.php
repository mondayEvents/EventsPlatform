<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;
use App\Database\Enum\ActivityTypeEnum as ActivityType;
use Cake\I18n\Time;

use App\Model\Rule\{
    NotSameTimeAndPlace,
    IsExclusive
};

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
//            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Speakers', [
            'foreignKey' => 'speaker_id',
//            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tracks', [
            'foreignKey' => 'track_id'
        ]);
        $this->belongsTo('EventPlaces', [
            'foreignKey' => 'event_place_id',
            'bindingKey' => 'id',
//            'joinType' => 'INNER'
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
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->decimal('price')
            ->requirePresence('price', function ($context) {
                if (!isset($context['data']['type'])) { return true; }
                return $context['data']['type'] !== ActivityType::SPARE_TIME;
            })
            ->notEmpty('price');


        $validator
            ->requirePresence('start_at', 'create')
            ->notEmpty('start_at')
            ->dateTime('start_at')
            ->add('start_at', '_notPast', [
                'rule' => [$this, 'notPast'],
                'message' => 'The Activity start must be in the future'
            ]);

        $validator
            ->requirePresence('end_at', 'create')
            ->notEmpty('end_at')
            ->dateTime('start_at')
            ->add('end_at', '_biggerThanStart', [
                'rule' => [$this, 'biggerThanStart'],
                'message' => 'The Activity end must be bigger than its start'
            ]);

        $validator
            ->requirePresence('speaker_id', function ($context) {
                if (!isset($context['data']['type'])) { return true; }
                return $context['data']['type'] !== ActivityType::SPARE_TIME;
            });

        $validator
            ->requirePresence('event_place_id', function ($context) {
                if (!isset($context['data']['type'])) { return true; }
                return $context['data']['type'] !== ActivityType::SPARE_TIME;
            });

        return $validator;
    }

    /**
     * Checks the start_at/end_at integrity
     *
     * @param $value
     * @param $context
     * @return bool
     */
    public function biggerThanStart ($value, $context)
    {

        if ($value <= $context['data']['start_at'])
        {
            return false;
        }
        return true;
    }

    /**
     * Checks the start_at/end_at integrity
     *
     * @param $value
     * @param $context
     * @return bool
     */
    public function notPast ($value, $context)
    {

        $is_past = Time::createFromFormat('Y-m-d H:i:s', $value, 'UTC')->isPast();
        if ($is_past)
        {
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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        $rules->add($rules->existsIn(['speaker_id'], 'Speakers'));
        $rules->add($rules->existsIn(['track_id'], 'Tracks'));
//        $rules->add($rules->existsIn(['event_place_id', 'event_id'], 'EventPlaces'));

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