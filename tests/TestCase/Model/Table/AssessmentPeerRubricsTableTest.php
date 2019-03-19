<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssessmentPeerRubricsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssessmentPeerRubricsTable Test Case
 */
class AssessmentPeerRubricsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssessmentPeerRubricsTable
     */
    public $AssessmentPeerRubrics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assessment_peer_rubrics',
        'app.rubrics',
        'app.assessment_peers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AssessmentPeerRubrics') ? [] : ['className' => AssessmentPeerRubricsTable::class];
        $this->AssessmentPeerRubrics = TableRegistry::getTableLocator()->get('AssessmentPeerRubrics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssessmentPeerRubrics);

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
