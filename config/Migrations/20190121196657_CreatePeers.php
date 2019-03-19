<?php
use Migrations\AbstractMigration;

class CreatePeers extends AbstractMigration
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
        $table = $this->table('peers');
        $table
          ->addColumn('user_id', 'integer', ['null' => false])
          ->addColumn('appraiser_id', 'integer', ['null' => false])
          ->addColumn('assessment_id', 'integer', ['null' => false])
          ->addColumn('assessment_user_id', 'integer', ['null' => true])
          ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addForeignKey('appraiser_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addForeignKey('assessment_id', 'assessments', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->addForeignKey('assessment_user_id', 'assessment_users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
