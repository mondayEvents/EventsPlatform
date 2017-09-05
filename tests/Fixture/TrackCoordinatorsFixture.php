<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TrackCoordinatorsFixture
 *
 */
class TrackCoordinatorsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'track_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_users_has_themes_themes1_idx' => ['type' => 'index', 'columns' => ['track_id'], 'length' => []],
            'fk_users_has_themes_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['user_id', 'track_id'], 'length' => []],
            'fk_users_has_themes_themes1' => ['type' => 'foreign', 'columns' => ['track_id'], 'references' => ['tracks', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_users_has_themes_users1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'user_id' => 'c1e537f6-f450-4503-bcee-babc9614cf27',
            'track_id' => '89747e61-d9f0-411c-9971-8e64db22f13e'
        ],
    ];
}
