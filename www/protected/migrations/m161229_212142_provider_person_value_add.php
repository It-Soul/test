<?php

class m161229_212142_provider_person_value_add extends CDbMigration
{
	public function up()
	{
        $this->execute('CREATE PROCEDURE `provider_add`(IN `status` INT, IN `status_hint` INT, IN `status_country` INT, IN `data_count` INT, IN `country_id` INT, IN `country_delivery` INT,IN `country_logistic` DOUBLE, IN `country_vat` DOUBLE,IN `uploading_status` INT,IN`updating_status` INT,IN`allowed_products_amount` INT,IN`file_uploading_status` INT,IN`relevance_check_status` INT,IN `country_hint` TEXT, IN `file_updating_status` INT, IN `uploaded_products_amount` INT)
begin
DECLARE I INT;
DECLARE result INT;
Declare done integer default 0;
DECLARE curs CURSOR FOR select u.id FROM users AS u;
DECLARE CONTINUE HANDLER FOR SQLSTATE \'02000\' SET done= 1;
open curs;
while   done=0 DO
FETCH curs INTO result;
insert INTO `provider_person`(user_id,status,status_hint, status_country, data_count, country_id, country_delivery,country_logistic, country_vat, uploading_status, updating_status, allowed_products_amount, file_uploading_status,relevance_check_status,country_hint,file_updating_status, uploaded_products_amount) values (result,status,status_hint, status_country, data_count, country_id, country_delivery,country_logistic, country_vat, uploading_status, updating_status, allowed_products_amount, file_uploading_status,relevance_check_status,country_hint,file_updating_status, uploaded_products_amount);
END WHILE;
close curs;
end');
	}

	public function down()
	{

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