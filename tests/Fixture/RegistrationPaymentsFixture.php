<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RegistrationPaymentsFixture
 *
 */
class RegistrationPaymentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'registration_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'managed_by' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'full_amount' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => '0.0000', 'comment' => ''],
        'to_be_paid_amount' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => false, 'default' => '0.0000', 'comment' => ''],
        'payment_date' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'status' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
            'id' => '45bdb20a-a4d2-4cdb-a788-787cac0dd55e',
            'registration_id' => '0582a95b-c5c3-4315-95f0-6e795bbf870a',
            'managed_by' => '290acb09-8fb1-4a07-ace3-524280e5fcc5',
            'full_amount' => 1.5,
            'to_be_paid_amount' => 1.5,
            'payment_date' => 1504613906,
            'status' => 1,
            'active' => 1
        ],
    ];
}
