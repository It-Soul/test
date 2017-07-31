<?php

class m170105_123524_add_column_file_ext extends CDbMigration
{
	public function up()
	{
        $this->addColumn('import_files','file_ext','text');
	}

	public function down()
	{
		$this->dropColumn('import_files','file_ext');
	}
}