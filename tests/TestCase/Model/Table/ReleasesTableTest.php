<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReleasesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReleasesTable Test Case
 */
class ReleasesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.releases',
        'app.users',
        'app.gyms',
        'app.machines',
        'app.phones',
        'app.rooms',
        'app.lessons',
        'app.services',
        'app.times',
        'app.weekdays',
        'app.suggestions',
        'app.customers',
        'app.cards',
        'app.exercises_groups',
        'app.exercises',
        'app.roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Releases') ? [] : ['className' => 'App\Model\Table\ReleasesTable'];
        $this->Releases = TableRegistry::get('Releases', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Releases);

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
