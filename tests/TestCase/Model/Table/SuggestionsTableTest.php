<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SuggestionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SuggestionsTable Test Case
 */
class SuggestionsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Suggestions' => 'app.suggestions',
        'Customers' => 'app.customers',
        'Cards' => 'app.cards',
        'Users' => 'app.users',
        'Gyms' => 'app.gyms',
        'Machines' => 'app.machines',
        'Phones' => 'app.phones',
        'Rooms' => 'app.rooms',
        'Lessons' => 'app.lessons',
        'Services' => 'app.services',
        'Weekdays' => 'app.weekdays',
        'ServicesWeekdays' => 'app.services_weekdays',
        'Roles' => 'app.roles',
        'Releases' => 'app.releases',
        'ExercisesGroups' => 'app.exercises_groups',
        'Exercises' => 'app.exercises'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Suggestions') ? [] : ['className' => 'App\Model\Table\SuggestionsTable'];        $this->Suggestions = TableRegistry::get('Suggestions', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Suggestions);

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
