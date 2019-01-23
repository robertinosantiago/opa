<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssessmentRubricsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssessmentRubricsTable Test Case
 */
class AssessmentRubricsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssessmentRubricsTable
     */
    public $AssessmentRubrics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assessment_rubrics',
        'app.assessments',
        'app.rubrics'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AssessmentRubrics') ? [] : ['className' => AssessmentRubricsTable::class];
        $this->AssessmentRubrics = TableRegistry::get('AssessmentRubrics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssessmentRubrics);

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
