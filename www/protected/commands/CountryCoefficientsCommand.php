<?php

class CountryCoefficientsCommand extends CConsoleCommand
{
    public function run($args)
    {
        $countries = array('9908', '1012', '2897', '9705');
        $users = Users::model()->findAll();

        if ($users) {
            foreach ($users as $user) {
                foreach ($countries as $countryId) {
                    $countryCoefficients = CountryCoef::model()->findByAttributes(array(
                        'user_id' => $user->id,
                        'country_id' => $countryId
                    ));
                    if (!$countryCoefficients) {
                        Yii::app()->db->createCommand()->insert('country_coef', array(
                            'country_id' => $countryId,
                            'user_id' => $user->id,
                            'vat' => 1,
                            'manager_coef' => 1,
                            'curator_coef' => 1,
                            'admin_coef' => 1,
                            'status' => 0
                        ));
                    }
                }
            }
        }
    }
}