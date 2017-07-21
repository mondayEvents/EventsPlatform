<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RegistrationItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RegistrationItemsTable Test Case
 */
class RegistrationItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RegistrationItemsTable
     */
    public $RegistrationItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.registration_items',
        'app.registrations',
        'app.events',
        'app.users',
        'app.groups',
        'app.coupons',
        'app.sponsorships',
        'app.companies',
        'app.event_activities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RegistrationItems') ? [] : ['className' => RegistrationItemsTable::class];
        $this->RegistrationItems = TableRegistry::get('RegistrationItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RegistrationItems);

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
