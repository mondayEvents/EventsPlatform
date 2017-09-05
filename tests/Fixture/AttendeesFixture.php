<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AttendeesFixture
 *
 */
class AttendeesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'activity_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_attendees_activities1_idx' => ['type' => 'index', 'columns' => ['activity_id'], 'length' => []],
            'fk_attendees_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'fk_attendees_activities1' => ['type' => 'foreign', 'columns' => ['activity_id'], 'references' => ['activities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_attendees_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'activity_id' => 'f37890de-1509-4328-97aa-3b06b8c5d1c3',
            'user_id' => 'f577877c-13ef-4094-8cc2-850da9ae1350'
        ],
    ];
}
