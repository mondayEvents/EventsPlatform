<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RegistrationsFixture
 *
 */
class RegistrationsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'event_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'whenAn' => ['type' => 'timestamp', 'length' => 1, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_registrations_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'fk_registrations_events1_idx' => ['type' => 'index', 'columns' => ['event_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'id_UNIQUE' => ['type' => 'unique', 'columns' => ['id'], 'length' => []],
            'fk_registrations_events1' => ['type' => 'foreign', 'columns' => ['event_id'], 'references' => ['events', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_registrations_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'id' => '4fcac21b-9533-4e8b-8cb7-5c6e8e38839f',
            'event_id' => '461c876d-a63c-4058-8f81-2e8a6c3414a4',
            'user_id' => 'f566c76d-046c-4b38-a4d2-066889a7e902',
            'when' => 1504613906,
            'active' => 1
        ],
    ];
}
