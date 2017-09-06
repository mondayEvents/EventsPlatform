<?php
namespace App\Model\Table;

use App\Model\Rule\AutoCouponConcomitance;
use App\Strategy\Coupons\DiscountFixedStrategy;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * Coupons Model
 *
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 *
 * @method \App\Model\Entity\Coupon get($primaryKey, $options = [])
 * @method \App\Model\Entity\Coupon newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Coupon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Coupon|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Coupon[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Coupon findOrCreate($search, callable $callback = null, $options = [])
 */
class CouponsTable extends AppTable
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

        $this->setTable('coupons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('RegistrationPayments', [
            'foreignKey' => 'coupon_id',
            'joinTable' => 'registration_payments_coupons'
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('code', function ($context) {
                return !(empty($context['data']['code']) && $context['data']['automatic'] !== 1);
            })
            ->add('code', 'validFormat', [
                'rule' => ['custom', '/^\w{3}\d{5}$/'],
                'message' => 'Cupon code must follow the rule: SSS-DDDDD'
            ]);

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->dateTime('start_at')
            ->requirePresence('start_at', 'create')
            ->notEmpty('start_at')
            ->add('start_at', '_notPast', [
                'rule' => function ($date, $context) {
                    $is_past = Time::createFromFormat('Y-m-d H:i:s', $date, 'UTC')->isPast();
                    if ($is_past) {
                        return false;
                    }
                    return true;
                },
                'message' => 'The Activity start must be in the future'
            ]);

        $validator
            ->dateTime('end_at')
            ->requirePresence('end_at', 'create')
            ->notEmpty('end_at')
            ->add('end_at', '_biggerThanStart', [
                'rule' => function ($end_at, $request) {
                    if ($end_at <= $request['data']['start_at']) {
                        return false;
                    }
                    return true;
                },
                'message' => 'The Activity end must be bigger than its start'
            ]);

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
        $rules->add(new AutoCouponConcomitance(), '_onlyOneAutoCouponPerPeriod', [
            'errorField' => 'code',
            'message' =>  __('You can only have one auto coupon at for the same time range')
        ]);

        return $rules;
    }

    public function findValidCoupons (string $event_id, array $coupons)
    {
        $today = new \DateTime();
        return $this->find()
            ->where(['Coupons.start_at <=' => $today->getTimestamp(), 'Coupons.end_at >=' => $today->getTimestamp()])
            ->andWhere(['Coupons.event_id' => $event_id])
            ->andWhere(['Coupons.automatic' => false])
            ->all();
    }
}