<?php

class m161128_191725_add_columns_to_provider_table_2 extends CDbMigration
{
    public function up()
    {
        $this->addColumn('provider_person', 'file_updating_status', 'integer');
    }

    public function down()
    {
        $this->dropColumn('provider_person', 'file_updating_status');
    }
}