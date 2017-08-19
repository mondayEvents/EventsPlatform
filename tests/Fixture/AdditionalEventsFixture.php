<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdditionalEventsFixture
 *
 */
class AdditionalEventsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'super_event_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'event_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_events_has_events_events2_idx' => ['type' => 'index', 'columns' => ['event_id'], 'length' => []],
            'fk_events_has_events_events1_idx' => ['type' => 'index', 'columns' => ['super_event_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['super_event_id', 'event_id'], 'length' => []],
            'fk_events_has_events_events1' => ['type' => 'foreign', 'columns' => ['super_event_id'], 'references' => ['events', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_events_has_events_events2' => ['type' => 'foreign', 'columns' => ['event_id'], 'references' => ['events', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'super_event_id' => '263f5eaa-2127-40a1-95fa-8e6d337c5756',
            'event_id' => '6724970e-3a18-4690-9a60-e21c1ac810bc'
        ],
    ];
}
