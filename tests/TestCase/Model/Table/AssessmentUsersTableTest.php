<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssessmentUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssessmentUsersTable Test Case
 */
class AssessmentUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssessmentUsersTable
     */
    public $AssessmentUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assessment_users',
        'app.users',
        'app.assessments',
        'app.peers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AssessmentUsers') ? [] : ['className' => AssessmentUsersTable::class];
        $this->AssessmentUsers = TableRegistry::getTableLocator()->get('AssessmentUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssessmentUsers);

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
