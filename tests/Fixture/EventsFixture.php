<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventsFixture
 *
 */
class EventsFixture extends TestFixture
{

    public $import = ['table' => 'Events'];
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
//    public $fields = [
//        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
//        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
//        'parent_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
//        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
//        'date_start' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
//        'date_end' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
//        'type' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
//        'price' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => '0.0000', 'comment' => ''],
//        'pay_by_activity' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
//        'status' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
//        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
//        '_indexes' => [
//            'fk_events_users_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
//        ],
//        '_constraints' => [
//            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
//            'fk_events_users' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
//        ],
//        '_options' => [
//            'engine' => 'InnoDB',
//            'collation' => 'latin1_swedish_ci'
//        ],
//    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 'efba6aea-9350-4034-9d2b-b684c20401c7',
            'user_id' => '06e0518d-d98c-4a70-bb91-6a792cd428c6',
            'parent_id' => '824425af-143a-4412-a309-efa3be0e19d4',
            'name' => 'Lorem ipsum dolor sit amet',
            'date_start' => 1504638195,
            'date_end' => 1504638195,
            'type' => 1,
            'price' => 1.5,
            'pay_by_activity' => 1,
            'status' => 1,
            'active' => 1
        ],
    ];
}
