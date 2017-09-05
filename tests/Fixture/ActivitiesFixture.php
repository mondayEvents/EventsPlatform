<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActivitiesFixture
 *
 */
class ActivitiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'event_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => '', 'comment' => '', 'precision' => null],
        'speaker_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'track_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'event_place_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'price' => ['type' => 'decimal', 'length' => 13, 'precision' => 4, 'unsigned' => false, 'null' => true, 'default' => '0.0000', 'comment' => ''],
        'type' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'start_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'end_at' => ['type' => 'timestamp', 'length' => null, 'null' => false, 'default' => '0000-00-00 00:00:00', 'comment' => '', 'precision' => null],
        'is_exclusive' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_event_activities_events1_idx' => ['type' => 'index', 'columns' => ['event_id'], 'length' => []],
            'fk_activities_themes1_idx' => ['type' => 'index', 'columns' => ['track_id'], 'length' => []],
            'fk_activities_attendees1_idx' => ['type' => 'index', 'columns' => ['speaker_id'], 'length' => []],
            'fk_activities_event_places1_idx' => ['type' => 'index', 'columns' => ['event_place_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'id_UNIQUE' => ['type' => 'unique', 'columns' => ['id'], 'length' => []],
            'fk_activities_attendees1' => ['type' => 'foreign', 'columns' => ['speaker_id'], 'references' => ['speakers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_activities_event_places1' => ['type' => 'foreign', 'columns' => ['event_place_id'], 'references' => ['event_places', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_activities_themes1' => ['type' => 'foreign', 'columns' => ['track_id'], 'references' => ['tracks', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_event_activities_events1' => ['type' => 'foreign', 'columns' => ['event_id'], 'references' => ['events', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
            'id' => '75120271-89c2-4ed2-92cf-fe83b01ac3bb',
            'user_id' => 'a7bd3cd3-6993-4f1a-a01b-5155f79c92c5',
            'event_id' => '3b5ef8be-828f-4925-80d0-73c8a4ce47d0',
            'speaker_id' => '76ec5018-719f-4c34-973a-6666c1aa8d04',
            'track_id' => '2ff03988-3090-45fc-80e2-592d7ee821d2',
            'event_place_id' => '404d5bb4-ddc2-48a2-a3c0-ed646cfd9915',
            'name' => 'Lorem ipsum dolor sit amet',
            'description' => 'Lorem ipsum dolor sit amet',
            'price' => 1.5,
            'type' => 1,
            'start_at' => 1504613905,
            'end_at' => 1504613905,
            'is_exclusive' => 1,
            'active' => 1
        ],
    ];
}
