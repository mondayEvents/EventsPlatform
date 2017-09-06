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
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'registration_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'activity_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'price' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'fk_registrations_has_event_activities_event_activities1_idx' => ['type' => 'index', 'columns' => ['activity_id'], 'length' => []],
            'fk_registrations_has_event_activities_registrations1_idx' => ['type' => 'index', 'columns' => ['registration_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['registration_id', 'activity_id'], 'length' => []],
            'fk_registrations_has_event_activities_event_activities1' => ['type' => 'foreign', 'columns' => ['activity_id'], 'references' => ['activities', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'id' => '85aa2429-7ed3-4830-a9c3-2a248631ff5e',
            'registration_id' => '7addc52e-2772-45ba-9d02-5001acb3440f',
            'activity_id' => '087d74ee-7b65-4859-a3d4-98c0cfc9d832',
            'price' => 1.5
        ],
    ];
}
