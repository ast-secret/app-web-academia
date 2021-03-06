<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ServicesWeekdaysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ServicesWeekdaysTable Test Case
 */
class ServicesWeekdaysTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'ServicesWeekdays' => 'app.services_weekdays',
        'Services' => 'app.services',
        'Gyms' => 'app.gyms',
        'Machines' => 'app.machines',
        'Phones' => 'app.phones',
        'Rooms' => 'app.rooms',
        'Lessons' => 'app.lessons',
        'Users' => 'app.users',
        'Roles' => 'app.roles',
<<<<<<< HEAD
        'Cards' => 'app.cards',
=======
        'Releases' => 'app.releases',
>>>>>>> db391e975ea2e6de5e5488bb493dc5474a6ca65a
        'Customers' => 'app.customers',
        'Suggestions' => 'app.suggestions',
        'ExercisesGroups' => 'app.exercises_groups',
        'Exercises' => 'app.exercises',
        'Releases' => 'app.releases',
        'Weekdays' => 'app.weekdays'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ServicesWeekdays') ? [] : ['className' => 'App\Model\Table\ServicesWeekdaysTable'];
        $this->ServicesWeekdays = TableRegistry::get('ServicesWeekdays', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ServicesWeekdays);

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
