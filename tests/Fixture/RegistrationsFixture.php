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
        'coupons_id' => ['type' => 'string', 'fixed' => true, 'length' => 26, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null],
        'when' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'is_paid' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'total_paid' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => '0.0000', 'comment' => ''],
        '_indexes' => [
            'fk_registrations_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'fk_registrations_events1_idx' => ['type' => 'index', 'columns' => ['event_id'], 'length' => []],
            'fk_registrations_coupons1_idx' => ['type' => 'index', 'columns' => ['coupons_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'id_UNIQUE' => ['type' => 'unique', 'columns' => ['id'], 'length' => []],
            'fk_registrations_coupons1' => ['type' => 'foreign', 'columns' => ['coupons_id'], 'references' => ['coupons', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'id' => '67c3a477-73c7-44c8-8c86-405fbc5cd8cc',
            'event_id' => '519eaf33-b41f-4b3a-a2af-17549f975d42',
            'user_id' => '7a09b001-575e-4bbc-994b-aa2781f82397',
            'coupons_id' => 'Lorem ipsum dolor sit am',
            'when' => 1500676256,
            'is_paid' => 1,
            'total_paid' => 1.5
        ],
    ];
}
