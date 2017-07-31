<?php

class m161221_191315_fill_sites_table extends CDbMigration
{
    public function safeUp()
    {
        $this->insertMultiple('sites', array(
            array(
                'id' => 1,
                'name' => 'Мартекс',
                'url' => 'http://sklep.martextruck.pl/'
            ),
            array(
                'id' => 2,
                'name' => 'Опольтранс',
                'url' => 'http://webcatalog.opoltrans.com.pl/'
            ),
            array(
                'id' => 3,
                'name' => 'Інтеркарс',
                'url' => 'http://intercars.com.pl/'
            ),
            array(
                'id' => 4,
                'name' => 'Скуба',
                'url' => 'http://www.skuba.com.pl/'
            ),
            array(
                'id' => 5,
                'name' => 'Дізель',
                'url' => 'http://www.diesel-czesci.pl/'
            )
        ));
    }

    public function safeDown()
    {
        $this->truncateTable('sites');
    }

}