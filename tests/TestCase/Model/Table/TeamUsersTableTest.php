<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TeamUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TeamUsersTable Test Case
 */
class TeamUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TeamUsersTable
     */
    public $TeamUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.team_users',
        'app.teams',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TeamUsers') ? [] : ['className' => TeamUsersTable::class];
        $this->TeamUsers = TableRegistry::get('TeamUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TeamUsers);

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
