<?php
use Migrations\AbstractMigration;

class CreateAssessmentPeerRubrics extends AbstractMigration
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
        $table = $this->table('assessment_peer_rubrics');
        $table
          ->addColumn('weight', 'float', ['null' => false])
          ->addColumn('score', 'integer', ['null' => false])
          ->addColumn('comments', 'text', ['null' => true])
          ->addColumn('rubric_id', 'integer', ['null' => false])
          ->addColumn('assessment_peer_id', 'integer', ['null' => false])
          ->addForeignKey('assessment_peer_id', 'assessment_peers', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addForeignKey('rubric_id', 'rubrics', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
