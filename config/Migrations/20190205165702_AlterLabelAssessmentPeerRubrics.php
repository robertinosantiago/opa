<?php
use Migrations\AbstractMigration;

class AlterLabelAssessmentPeerRubrics extends AbstractMigration
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
          ->addColumn('label', 'string', ['limit' => 255, 'null' => false])
          ->update();
    }
}
