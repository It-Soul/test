<?php

class m161130_192353_change_results_add_column extends CDbMigration
{
    public function up()
    {
        $this->renameColumn('results_add', 'def_price', 'weight');
        $this->renameColumn('results_add', 'query', 'currency');
    }

    public function down()
    {
        $this->renameColumn('results_add', 'weight', 'def_price');
        $this->renameColumn('results_add', 'currency', 'query');
    }
}