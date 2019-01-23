<?php
use Migrations\AbstractMigration;

class Tokens extends AbstractMigration
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
      $table = $this->table('tokens');
      $table
          ->addColumn('token', 'text', ['null' => false])
          ->addColumn('validate', 'datetime', ['null' => false])
          ->addColumn('user_id', 'integer', ['null' => false])
          ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
