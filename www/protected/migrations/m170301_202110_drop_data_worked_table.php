<?php

class m170301_202110_drop_data_worked_table extends CDbMigration
{
    public function up()
    {
        $this->dropTable('data_worked');
    }

    public function down()
    {
        $this->createTable('data_worked', array(
            'id' => 'pk',
            'date' => 'datetime'
        ));
    }
}