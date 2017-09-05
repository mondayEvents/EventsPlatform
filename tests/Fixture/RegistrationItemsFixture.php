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
            'id' => 'a112aeea-b5ac-4d3c-998d-09b1e97f1493',
            'registration_id' => '32f86da5-0f11-4e80-b14e-d0724f104b02',
            'activity_id' => 'a4cdd0f7-8170-4f79-a863-fc73e977e6a9',
            'price' => 1.5
        ],
    ];
}
