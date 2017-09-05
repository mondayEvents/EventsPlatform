<?php
namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Application Table
 *
 * Application-wide methods are implemented here,
 * so Table Models can inherit them.
 */
abstract class AppTable extends Table
{
    public function beforeFind($event, $query, $options, $primary)
    {
        if(!isset($options['active'])){
            $query->where([
                $event->subject()->alias() . '.active' => 1
            ]);
        }
        return $query;
    }
}
