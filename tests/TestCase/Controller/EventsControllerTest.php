<?php
namespace App\Test\TestCase\Controller;

use App\Controller\EventsController;
use App\Database\Enum\AppEnum;
use App\Database\Enum\EventTypeEnum;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use App\Model\Table\EventsTable;

/**
 * App\Controller\EventsController Test Case
 */
class EventsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.events',
        'app.users',
//        'app.aros',
//        'app.acos',
//        'app.permissions',
        'app.tags',
        'app.events_tags',
        'app.users_tags',
        'app.tracks',
//        'app.activities',
        'app.attendees',
        'app.speakers',
        'app.event_places',
        'app.registration_items',
//        'app.registrations',
        'app.registration_payments',
//        'app.registration',
        'app.coupons',
//        'app.registration_payments_coupons',
//        'app.track_coordinators',
        'app.groups',
        'app.event_managers',
        'app.association_requests',
//        'app.event_parents',
        'app.companies',
        'app.sponsorships',
//        'app.association_request_parents'
    ];

    protected $Events;

    public function setUp ()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();

        TableRegistry::clear();
        $this->configRequest([]);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function test_list_all_events()
    {
        $this->get('/events');
        $this->assertResponseCode(200);
    }

    /**
     * Test view method
     *
     * @return void
     */
//    public function testView()
//    {
//
//    }

    /**
     * Test add method
     *
     * @return void
     */
    public function test_add_event_without_authentication()
    {
        $data = [
            'name' => 'Evento Teste',
            'date_start' => '2017-12-05 00:46:09',
            'date_end' => '2017-12-10 00:46:09',
            'type' => 1,
            'pay_by_activity' => 1,
            "tags" => [
                "712f0a60-144f-4d6b-8e94-32d64cfec75c"
            ]
        ];


        $this->post('/events/add', $data);
        $this->assertResponseCode(401);

        $articles = TableRegistry::get('Events');
        $query = $articles->find()->where(['name' => $data['name']]);
        $this->assertEquals(0, $query->count());
    }

    /**
     * Test types method
     *
     * @return void
     */
    public function test_add_event()
    {
        $data = [
            'name' => 'Evento Test',
            'date_start' => '2017-12-05 00:46:09',
            'date_end' => '2017-12-10 00:46:09',
            'type' => 1,
            'pay_by_activity' => 1,
            "tags" => [
                "e763e5ab-93c3-4bdb-92d9-7s6d9e269498"
            ]
        ];

        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiJiOGY1YzJhMi0yMjBmLTQ3ZWItYWViNS1jZmU5NTAzODU1MTAiLCJnaWQiOiJZbVptT0RRek5XSTRaR00wT1RKaE9EZGhOakUzTkdNMFlUYzNPR1l3TjJJM1lqaGpOakU1TXpsaFpESXdORFkyTW1FeVpqTTNPREprTkdFeE5qQTVOM2o4dnB5YkxIdWVabmV3aUMxV3hjY3VaZUMzVlA5RVZnZTA4cGFUaGN5UyIsImp0aSI6ImY0YzU3NGZkLTg5YmMtNDIwOS1iYmI1LWY0ZGFmYzVlZDhkYSIsImV4cCI6MTUwNTMwNjU1NX0.nb05vbKiAinZqzaBqqeitucqK7EINW-H5DQj3ycoZ1M'
            ],
            'body' => $data
        ]);

        $this->post('/events/add', $data);
        $this->assertResponseSuccess();

        $articles = TableRegistry::get('Events');
        $query = $articles->find()->where(['name' => $data['name']]);
        $this->assertEquals(1, $query->count());

    }

//
//    /**
//     * Test schedule method
//     *
//     * @return void
//     */
//    public function testSchedule()
//    {
//        $this->markTestIncomplete('Not implemented yet.');
//    }
}
