<?php
use Migrations\AbstractMigration;

class Assessments extends AbstractMigration
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
      $table = $this->table('assessments');
      $table
          ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
          ->addColumn('description', 'text', ['null' => true])
          ->addColumn('scale', 'integer', ['null' => false])
          ->addColumn('labels', 'json', ['null' => true])
          ->addColumn('file', 'string', ['null' => true])
          ->addColumn('maximum_score', 'float', ['null' => false])
          ->addColumn('status', 'string', ['default' => 'draft', 'null' => false])
          ->addColumn('startAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
          ->addColumn('endAt', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
          ->addColumn('created', 'datetime', ['null' => false])
          ->addColumn('modified', 'datetime', ['null' => false])
          ->addColumn('team_id', 'integer', ['null' => false])
          ->addForeignKey('team_id', 'teams', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addColumn('user_id', 'integer', ['null' => false])
          ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
