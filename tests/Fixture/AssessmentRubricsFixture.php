<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AssessmentRubricsFixture
 *
 */
class AssessmentRubricsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'weight' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'assessment_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rubric_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'assessment_id' => ['type' => 'index', 'columns' => ['assessment_id'], 'length' => []],
            'rubric_id' => ['type' => 'index', 'columns' => ['rubric_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'assessment_rubrics_ibfk_1' => ['type' => 'foreign', 'columns' => ['assessment_id'], 'references' => ['assessments', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'assessment_rubrics_ibfk_2' => ['type' => 'foreign', 'columns' => ['rubric_id'], 'references' => ['rubrics', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'weight' => 1,
                'assessment_id' => 1,
                'rubric_id' => 1
            ],
        ];
        parent::init();
    }
}
