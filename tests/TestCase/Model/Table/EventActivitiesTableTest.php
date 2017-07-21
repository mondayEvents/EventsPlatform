<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventActivitiesTable Test Case
 */
class EventActivitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EventActivitiesTable
     */
    public $EventActivities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.event_activities',
        'app.events',
        'app.users',
        'app.groups',
        'app.registrations',
        'app.coupons',
        'app.sponsorships',
        'app.registration_items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EventActivities') ? [] : ['className' => EventActivitiesTable::class];
        $this->EventActivities = TableRegistry::get('EventActivities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventActivities);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
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
