<?php

class m161221_185426_create_sites_tables extends CDbMigration
{
    public function up()
    {
        $this->createTable('sites', array(
            'id' => 'pk',
            'name' => 'string',
            'url' => 'string',
        ));
    }

    public function down()
    {
        $this->dropTable('sites');
    }
}