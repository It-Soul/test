<?php

class m161201_181359_change_result_add_columns extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('results_add', 'info', 'integer');
        $this->renameColumn('results_add', 'info', 'file_id');
    }

    public function down()
    {
        $this->alterColumn('results_add', 'file_id', 'string');
        $this->renameColumn('results_add', 'file_id', 'info');
    }
}