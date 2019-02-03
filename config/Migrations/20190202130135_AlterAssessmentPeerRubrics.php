<?php
use Migrations\AbstractMigration;

class AlterScore extends AbstractMigration
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
      $table->changeColumn('score', 'float', ['null' => false]);
      $table->update();
    }
}
