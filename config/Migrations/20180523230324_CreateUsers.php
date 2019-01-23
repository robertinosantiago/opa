<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table
            ->addColumn('first_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('role', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('avatar', 'string', ['null' => true])
            ->addColumn('locale', 'string', ['null' => true])
            ->addColumn('confirm', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->addColumn('modified', 'datetime', ['null' => false])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
