<?php
use Migrations\AbstractMigration;

class CreateAssessmentPeers extends AbstractMigration
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
        $table = $this->table('assessment_peers');
        $table
          ->addColumn('comments', 'text', ['null' => true])
          ->addColumn('peer_id', 'integer', ['null' => false])
          ->addColumn('created', 'datetime', ['null' => false])
          ->addColumn('modified', 'datetime', ['null' => false])
          ->addForeignKey('peer_id', 'peers', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
          ->create();
    }
}
