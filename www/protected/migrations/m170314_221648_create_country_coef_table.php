<?php

class m170314_221648_create_country_coef_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('country_coef',array(
            'id'=>'pk',
            'country_id'=>'integer',
            'user_id'=>'integer',
            'vat'=>'float',
            'manager_coef'=>'float',
            'curator_coef'=>'float',
            'admin_coef'=>'float',
            'status'=>'integer',
        ));
	}

	public function down()
	{
		$this->dropTable('country_coef');
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