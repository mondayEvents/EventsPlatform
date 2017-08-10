<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RegistrationItems Model
 *
 * @property \App\Model\Table\RegistrationsTable|\Cake\ORM\Association\BelongsTo $Registrations
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\BelongsTo $Activities
 *
 * @method \App\Model\Entity\RegistrationItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\RegistrationItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RegistrationItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RegistrationItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RegistrationItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RegistrationItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RegistrationItem findOrCreate($search, callable $callback = null, $options = [])
 */
class RegistrationItemsTable extends Table
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

        $this->setTable('registration_items');
        $this->setDisplayField('registration_id');
        $this->setPrimaryKey(['registration_id', 'activity_id']);

        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
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
            ->decimal('price')
            ->allowEmpty('price');

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
        $rules->add($rules->existsIn(['registration_id'], 'Registrations'));
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));

        return $rules;
    }
}
