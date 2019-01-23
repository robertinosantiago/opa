<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PeersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PeersTable Test Case
 */
class PeersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PeersTable
     */
    public $Peers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.peers',
        'app.users',
        'app.assessments',
        'app.assessment_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Peers') ? [] : ['className' => PeersTable::class];
        $this->Peers = TableRegistry::getTableLocator()->get('Peers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Peers);

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
