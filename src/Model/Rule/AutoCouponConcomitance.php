<?php
namespace App\Model\Rule;

use Cake\Datasource\EntityInterface;
use App\Model\Rule\AppRule;
use App\Database\Enum\ActivityTypeEnum as ActivityType;

/**
 * This class checks if the given entity date/time range occurs
 * at the same place of another entity.
 *
 * Situation: One Activity cannot occur at same date and time
 * and space of another Activity.
 *
 * @method \App\Model\Rule\AppRule getAlias()
 * @method \App\Model\Rule\AppRule getColumnNames()
 * @method \App\Model\Rule\AppRule getOptions()
 * @method \App\Model\Rule\AppRule getRepository()
 * @method \App\Model\Rule\AppRule getEntity()
 * @method \App\Model\Rule\AppRule getSchema()
 * @method \App\Model\Rule\AppRule populate($entity, array $options)
 */
class AutoCouponConcomitance extends AppRule
{
    /**
     * @var array
     */
    protected $_column_names = [
        'start' => 'start_at',
        'end' => 'end_at'
    ];
    /**
     * @param EntityInterface $entity
     * @param array $options
     * @return bool
     * @throws \Exception
     */
    public function __invoke(EntityInterface $entity, array $options): bool
    {
        $this->populate($entity, $options);
        return $this->_couponConcomitance();
    }

    /**
     * @return bool
     */
    private function _couponConcomitance (): bool
    {
        $hasColumns = $this->columnChecker();
        if ($hasColumns->error)
        {
            $this->throwError($hasColumns->missingColumn);
        }

        $query = $this->_buildQuery();
        return !$query;
    }

    /**
     * @return bool
     */
    private function _buildQuery (): bool
    {
        if ($this->getEntity()->automatic == 0) {
            return false;
        }

        $table_alias = (string) $this->getAlias();
//        dd($this->getEntity());
        $event_id = $this->getEntity()->event_id;
        $end_at = $this->getEntity()->end_at;
        $start_at = $this->getEntity()->start_at;

        $whereStart = [
            $table_alias . '.' . $this->getColumnNames()->start . ' <=' => $end_at,
            $table_alias . '.' . $this->getColumnNames()->start . ' >=' => $start_at
        ];

        $whereEnd = [$table_alias . '.' . $this->getColumnNames()->end . ' >=' => $start_at];

        return (bool) $this->getRepository()
            ->find()
            ->where($whereStart)
            ->orWhere($whereEnd)
            ->andWhere([$table_alias . '.' . 'event_id' => $event_id, $table_alias . '.' . 'automatic' => 1])
            ->contain([])
            ->count();
    }
}
