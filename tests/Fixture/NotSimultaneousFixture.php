<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NotSimultaneousFixture
 *
 */
class NotSimultaneousFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'not_simultaneous';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'activity_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'another_activity_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_activities_has_activities_activities2_idx' => ['type' => 'index', 'columns' => ['another_activity_id'], 'length' => []],
            'fk_activities_has_activities_activities1_idx' => ['type' => 'index', 'columns' => ['activity_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['activity_id', 'another_activity_id'], 'length' => []],
            'fk_activities_has_activities_activities1' => ['type' => 'foreign', 'columns' => ['activity_id'], 'references' => ['activities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_activities_has_activities_activities2' => ['type' => 'foreign', 'columns' => ['another_activity_id'], 'references' => ['activities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'activity_id' => '359d4241-c4f6-4e97-9346-3f11bb11416f',
            'another_activity_id' => 'c40a574a-8c08-489b-a244-94f2188454df'
        ],
    ];
}
