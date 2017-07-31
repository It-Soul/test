<?php

class m161221_190022_rename_site_name_column_to_site_id_in_sites_access_control_table extends CDbMigration
{
    public function up()
    {
        $this->renameColumn('sites_access_control', 'site_name', 'site_id');
    }

    public function down()
    {
        $this->renameColumn('sites_access_control', 'site_id', 'site_name');
    }
}