<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdditionalEventsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdditionalEventsTable Test Case
 */
class AdditionalEventsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdditionalEventsTable
     */
    public $AdditionalEvents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.additional_events',
        'app.events',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.groups',
        'app.registrations',
        'app.registration_items',
        'app.activities',
        'app.speakers',
        'app.tracks',
        'app.event_places',
        'app.activity_places',
        'app.concomitance',
        'app.coupons',
        'app.event_managers',
        'app.sponsorships',
        'app.companies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AdditionalEvents') ? [] : ['className' => AdditionalEventsTable::class];
        $this->AdditionalEvents = TableRegistry::get('AdditionalEvents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdditionalEvents);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
