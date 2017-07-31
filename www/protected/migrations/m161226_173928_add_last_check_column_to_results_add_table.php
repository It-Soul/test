<?php

class m161226_173928_add_last_check_column_to_results_add_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('results_add', 'last_check', 'datetime');
    }

    public function down()
    {
        $this->dropColumn('results_add', 'last_check');
    }
}