<?php
use Migrations\AbstractMigration;

class AlterFromTeacherAssessmentUsers extends AbstractMigration
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
        $table = $this->table('assessment_users');
        $table
          ->addColumn('from_teacher', 'boolean', ['null' => false, 'default' => false])
          ->update();
    }
}
