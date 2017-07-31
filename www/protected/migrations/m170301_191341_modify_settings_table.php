<?php

class m170301_191341_modify_settings_table extends CDbMigration
{
    public function up()
    {
        $this->renameTable('setting', 'settings');

        $this->truncateTable('settings');

        $this->addColumn('settings', 'id', 'integer');
        $this->addColumn('settings', 'date', 'datetime');

        $this->dropPrimaryKey('name', 'settings');
        $this->addPrimaryKey('id', 'settings', 'id');

        $this->alterColumn('settings', 'id', 'integer NOT NULL AUTO_INCREMENT');

        $this->dropColumn('settings', 'name');
        $this->dropColumn('settings', 'value');
    }

    public function down()
    {
        echo "m170301_191341_modify_settings_table does not support migration down.\n";
        return false;
    }
}