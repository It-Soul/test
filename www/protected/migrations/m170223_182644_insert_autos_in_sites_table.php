<?php

class m170223_182644_insert_autos_in_sites_table extends CDbMigration
{
    public function safeUp()
    {
        $this->insert('sites', array(
            'id' => 6,
            'name' => 'Автос',
            'url' => 'https://sklep.autos.com.pl/'
        ));
        $this->insert('sites_access_control', array(
            'site_id' => 6,
            'login' => '',
            'password' => '',
            'status' => 1
        ));
    }

    public function safeDown()
    {
        $this->delete('sites', 'url=:url', array(
            'url' => 'https://sklep.autos.com.pl/'
        ));
        $this->delete('sites_access_control', 'site_id=:site_id', array(
            'site_id' => 6
        ));
    }

}