<?php

class m160916_145000_init_db extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $dump = '../environments/lc-parts.sql';
        if (file_exists($dump)) {
            $dump = file_get_contents($dump);
            $this->execute($dump);
        }

    }

    public function safeDown()
    {
    }

}