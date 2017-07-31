<?php

class m161206_134506_add_procedure_cofadd extends CDbMigration
{
	public function up()
	{
$this->execute('CREATE PROCEDURE `coeficients_add`(IN `logistic` FLOAT, IN `vat` FLOAT, IN `manager` FLOAT, IN `curator` FLOAT, IN `admin` FLOAT, IN `status_add` INT, IN `sname` VARCHAR(50))
begin
DECLARE I INT;
DECLARE result INT;
Declare done integer default 0;
DECLARE curs CURSOR FOR select u.id FROM users AS u LEFT JOIN coefficients AS c ON u.id = c.user_id WHERE c.admin_coef IS NULL OR  c.site_name  IN(select id from sites) group by u.id;
DECLARE CONTINUE HANDLER FOR SQLSTATE \'02000\' SET done= 1;
open curs;
while   done=0 DO
FETCH curs INTO result;
insert INTO `coefficients`(site_name,logistic, vat, manager_coef, curator_coef, admin_coef,user_id, status) values (sname,logistic,vat,manager,curator,admin,result,status_add);
END WHILE;
close curs;
end');
	}

	public function down()
	{
		echo "m161206_134506_add_procedure_cofadd does not support migration down.\n";
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