<?php
/**
 * Created by PhpStorm.
 * User: Roma
 * Date: 29.12.2016
 * Time: 18:16
 */
class CabinetMenu extends CWidget
{
    public function run()
    {
        $provider_status = ProviderPerson::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
        $this->render('cabinet-menu', array(
            'provider_status' => $provider_status
        ));
    }
}