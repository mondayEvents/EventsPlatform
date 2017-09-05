<?php
namespace App\Test\TestCase\Controller;

use App\Controller\EventsController;
use Cake\TestSuite\IntegrationTestCase;

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
        'app.aros',
        'app.acos',
        'app.groups',
        'app.registrations',
        'app.registration_items',
        'app.activities',
        'app.speakers',
        'app.tracks',
        'app.event_places',
        'app.tags',
        'app.events_tags',
        'app.coupons',
        'app.event_managers',
        'app.association_requests',
        'app.sponsorships',
        'app.companies'
    ];

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
    $this->markAsIncomplete();
    }



    public function testAdd()
    {
        $this->get('/events/add');
        $this->assertResponseOk();
    }

}
