<?php
use Migrations\AbstractMigration;

class AlterAssessment extends AbstractMigration
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
        $table->addColumn('start_assessment', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => true,
        ]);
        $table->addColumn('end_assessment', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => true,
        ]);
        $table->update();
    }
}
