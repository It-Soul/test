<?php

class m170301_194648_fill_settings_table extends CDbMigration
{

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->insert('settings', array(
            'id' => 1
        ));
    }

    public function safeDown()
    {
        $this->delete('settings', 'id=:id', array(
            'id' => 1
        ));
    }

}