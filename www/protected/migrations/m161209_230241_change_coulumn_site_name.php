<?php

class m161209_230241_change_coulumn_site_name extends CDbMigration
{
    public function up()
    {
        $this->alterColumn('sites_access_control', 'site_name', 'integer');
        $this->dropColumn('sites_access_control', 'site_url');
    }

    public function down()
    {
        $this->alterColumn('sites_access_control', 'site_name', 'string');
        $this->addColumn('sites_access_control', 'site_url', 'string');


    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}