<?php

class m160916_145025_create_table_provider_person extends CDbMigration
{
	public function up()
	{
		$this->createTable('provider_person', array(
			'id' => 'pk',
			'user_id' => 'integer',
			'status' => 'integer',
			'status_hint' => 'integer',
			'status_country' => 'integer',
			'data_count' => 'integer',
			'country_id' => 'integer',
			'country_delivery' => 'integer',
			'country_logistic' => 'real',
			'country_vat' => 'real',
		));
	}

	public function down()
	{
		echo "m160916_145025_create_table_provider_person does not support migration down.\n";
		return false;
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