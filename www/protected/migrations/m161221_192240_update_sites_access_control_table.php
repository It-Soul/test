<?php

class m161221_192240_update_sites_access_control_table extends CDbMigration
{

    public function safeUp()
    {
        $this->update('sites_access_control', array('site_id' => 1), 'id=1');
        $this->update('sites_access_control', array('site_id' => 2), 'id=2');
        $this->update('sites_access_control', array('site_id' => 3), 'id=3');
        $this->update('sites_access_control', array('site_id' => 4), 'id=4');
        $this->update('sites_access_control', array('site_id' => 5), 'id=5');
    }

    public function safeDown()
    {
    }
}