<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssessmentPeersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssessmentPeersTable Test Case
 */
class AssessmentPeersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssessmentPeersTable
     */
    public $AssessmentPeers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assessment_peers',
        'app.peers',
        'app.assessment_peer_rubrics'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AssessmentPeers') ? [] : ['className' => AssessmentPeersTable::class];
        $this->AssessmentPeers = TableRegistry::getTableLocator()->get('AssessmentPeers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssessmentPeers);

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
