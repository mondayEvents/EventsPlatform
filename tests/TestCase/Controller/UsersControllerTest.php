<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        //'app.aros',
       // 'app.acos',
       // 'app.permissions',
        'app.tags',
        'app.users_tags',
        'app.tracks',
        'app.track_coordinators',
        'app.activities',
        'app.events',
        'app.events_tags',
        'app.coupons',
        'app.registration_payments',
        'app.registration_payments_coupons',
        'app.event_managers',
        'app.association_requests',
     //   'app.event_parents',
        'app.event_places',
        'app.registrations',
        'app.registration_items',
        'app.companies',
        'app.sponsorships',
      //  'app.association_request_parents',
        'app.attendees',
        'app.speakers',
        'app.groups'
    ];



    /**
     * Test token method
     *
     * @return void
     */
    public function test_get_token()
    {
        $response = $this->get('/users/token');
        $this->assertResponseCode(200);

       //$this->markTestIncomplete('Not implemented yet.');
    
    }

}
