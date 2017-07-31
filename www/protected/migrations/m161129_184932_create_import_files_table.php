<?php

class m161129_184932_create_import_files_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('import_files', array(
            'id' => 'pk',
            'user_id' => 'integer',
            'name' => 'string',
            'real_file_name' => 'string',
            'positions_amount' => 'integer',
            'created_at' => 'datetime',
            'last_check' => 'datetime'
        ));
    }

    public function down()
    {
        $this->dropTable('import_files');
    }
}