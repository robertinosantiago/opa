<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RubricsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RubricsTable Test Case
 */
class RubricsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RubricsTable
     */
    public $Rubrics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rubrics',
        'app.users',
        'app.questions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Rubrics') ? [] : ['className' => RubricsTable::class];
        $this->Rubrics = TableRegistry::get('Rubrics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rubrics);

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
