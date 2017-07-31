<?php

class m161219_175231_add_uploaded_products_amount_to_provider_person_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('provider_person', 'uploaded_products_amount', 'integer');
    }

    public function down()
    {
        $this->dropColumn('provider_person', 'uploaded_products_amount');
    }
}