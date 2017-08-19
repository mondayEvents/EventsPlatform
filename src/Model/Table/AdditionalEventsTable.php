<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * AdditionalEvents Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 *
 * @method \App\Model\Entity\AdditionalEvent get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdditionalEvent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdditionalEvent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdditionalEvent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdditionalEvent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdditionalEvent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdditionalEvent findOrCreate($search, callable $callback = null, $options = [])
 */
class AdditionalEventsTable extends AppTable
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

        $this->setTable('additional_events');
        $this->setDisplayField('super_event_id');
        $this->setPrimaryKey(['super_event_id', 'event_id']);

        $this->belongsTo('Events', [
            'foreignKey' => 'super_event_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['super_event_id'], 'Events'));
        $rules->add($rules->existsIn(['event_id'], 'Events'));

        return $rules;
    }
}
