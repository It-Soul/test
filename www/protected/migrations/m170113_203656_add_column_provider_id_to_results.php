<?php

class m170113_203656_add_column_provider_id_to_results extends CDbMigration
{
	public function up()
	{
        $this->addColumn('results','provider_id','integer');
	}

	public function down()
	{
		$this->dropColumn('results','provider_id');
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