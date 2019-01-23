<?php
use Migrations\AbstractMigration;

class CreateAssessmentRubrics extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('assessment_rubrics');
        $table
          ->addColumn('weight', 'float', ['null' => false])
          ->addColumn('assessment_id', 'integer', ['null' => false])
          ->addColumn('rubric_id', 'integer', ['null' => false])
          ->addForeignKey('assessment_id', 'assessments', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addForeignKey('rubric_id', 'rubrics', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
