<?php
namespace App\Model\Rule;
 
use Cake\Datasource\EntityInterface;
use App\Model\Rule\AppRule;
 
/**
 * This class checks if the given set of dates are within
 * the same range.
 *
 * Situation: One Event cannot have an Activity outside its
 * date/time range.
 *
 * @method \App\Model\Rule\AppRule getAlias()
 * @method \App\Model\Rule\AppRule getColumnNames()
 * @method \App\Model\Rule\AppRule getOptions()
 * @method \App\Model\Rule\AppRule getRepository()
 * @method \App\Model\Rule\AppRule getEntity()
 * @method \App\Model\Rule\AppRule getSchema()
 * @method \App\Model\Rule\AppRule populate($entity, array $options)
 */
class MatchDateRanges extends AppRule
{
 
    /**
     * @param EntityInterface $entity
     * @param array $options
     * @return bool
     * @throws \Exception
     */
    public function __invoke(EntityInterface $entity, array $options): bool
    {
        $this->populate($entity, $options);
        return $this->_matchDateRanges();
    }
 
    private function _matchDateRanges()
    {
//        dd($this->getEntity());
        return true;
    }
}