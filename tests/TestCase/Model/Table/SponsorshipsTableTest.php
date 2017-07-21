<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SponsorshipsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SponsorshipsTable Test Case
 */
class SponsorshipsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SponsorshipsTable
     */
    public $Sponsorships;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sponsorships',
        'app.events',
        'app.users',
        'app.groups',
        'app.registrations',
        'app.coupons',
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
        $config = TableRegistry::exists('Sponsorships') ? [] : ['className' => SponsorshipsTable::class];
        $this->Sponsorships = TableRegistry::get('Sponsorships', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Sponsorships);

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
