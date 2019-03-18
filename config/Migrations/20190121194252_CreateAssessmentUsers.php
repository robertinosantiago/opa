<?php
use Migrations\AbstractMigration;

class CreateAssessmentUsers extends AbstractMigration
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
          ->addColumn('file', 'string', ['null' => true])
          ->addColumn('document_text', 'text', ['null' => true])
          ->addColumn('draft', 'boolean', ['null' => false, 'default' => true])
          ->addColumn('user_id', 'integer', ['null' => false])
          ->addColumn('assessment_id', 'integer', ['null' => false])
          ->addColumn('created', 'datetime', ['null' => false])
          ->addColumn('modified', 'datetime', ['null' => false])
          ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addForeignKey('assessment_id', 'assessments', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
