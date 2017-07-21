<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RegistrationItemsFixture
 *
 */
class RegistrationItemsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'registration_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'event_activity_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'price' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_registrations_has_event_activities_event_activities1_idx' => ['type' => 'index', 'columns' => ['event_activity_id'], 'length' => []],
            'fk_registrations_has_event_activities_registrations1_idx' => ['type' => 'index', 'columns' => ['registration_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['registration_id', 'event_activity_id'], 'length' => []],
            'fk_registrations_has_event_activities_event_activities1' => ['type' => 'foreign', 'columns' => ['event_activity_id'], 'references' => ['event_activities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_registrations_has_event_activities_registrations1' => ['type' => 'foreign', 'columns' => ['registration_id'], 'references' => ['registrations', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'registration_id' => '94f25faf-004d-4552-9e89-a43141d935f1',
            'event_activity_id' => 'b9fe987a-58f9-4794-bbe4-5ee17a4344ec',
            'price' => 1.5
        ],
    ];
}
