<?php

class m161128_184641_add_columns_to_provider_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('provider_person', 'uploading_status', 'integer');
        $this->addColumn('provider_person', 'updating_status', 'integer');
        $this->addColumn('provider_person', 'allowed_products_amount', 'integer');
        $this->addColumn('provider_person', 'file_uploading_status', 'integer');
        $this->addColumn('provider_person', 'relevance_check_status', 'integer');
        $this->addColumn('provider_person', 'country_hint', 'text');
    }

    public function down()
    {
        $this->dropColumn('provider_person', 'uploading_status');
        $this->dropColumn('provider_person', 'updating_status');
        $this->dropColumn('provider_person', 'allowed_products_amount');
        $this->dropColumn('provider_person', 'file_uploading_status');
        $this->dropColumn('provider_person', 'relevance_check_status');
        $this->dropColumn('provider_person', 'country_hint');
    }
}