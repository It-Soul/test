<?php

class m170113_204036_add_column_provider_id_to_results_admin extends CDbMigration
{
	public function up()
	{
        $this->addColumn('results_admin','provider_id','integer');
	}

	public function down()
	{
		$this->dropColumn('results_admin','provider_id');
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