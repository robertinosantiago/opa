<?php
use Migrations\AbstractMigration;

class CreateInvites extends AbstractMigration
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
        $table = $this->table('invites');
        $table
          ->addColumn('email', 'string', ['length' => 255, 'null' => false])
          ->addColumn('hash', 'string', ['length' => 255, 'null' => false])
          ->addColumn('confirm', 'boolean', ['default' => false])
          ->addColumn('team_id', 'integer', ['null' => false])
          ->addForeignKey('team_id', 'teams', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
