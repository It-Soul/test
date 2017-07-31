<?php

class m161221_190023_infosite_view_create extends CDbMigration
{
    public function up()
    {
        $this->execute('create view `infosite`  AS
select sac.site_id,s.name,s.url,sac.login,sac.password,sac.status from sites as s inner join sites_access_control as sac ON s.id = sac.site_id');
    }

    public function down()
    {
        $this->dropTable('infosite');
    }
}