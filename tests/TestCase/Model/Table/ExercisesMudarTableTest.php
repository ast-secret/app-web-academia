<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExercisesMudarTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExercisesMudarTable Test Case
 */
class ExercisesMudarTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'ExercisesMudar' => 'app.exercises_mudar'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
<<<<<<< HEAD
        $config = TableRegistry::exists('ExercisesMudar') ? [] : ['className' => 'App\Model\Table\ExercisesMudarTable'];        $this->ExercisesMudar = TableRegistry::get('ExercisesMudar', $config);    }
=======
        $config = TableRegistry::exists('ExercisesMudar') ? [] : ['className' => 'App\Model\Table\ExercisesMudarTable'];
        $this->ExercisesMudar = TableRegistry::get('ExercisesMudar', $config);
    }
>>>>>>> db391e975ea2e6de5e5488bb493dc5474a6ca65a

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ExercisesMudar);

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
}
