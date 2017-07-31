<?php

class ProviderMenu extends CWidget
{
    public function run()
    {
        $id = Yii::app()->request->getQuery('id');

        $this->render('provider-menu', array(
            'id' => $id,
            'providerStatus' => ProviderPerson::getProviderStatus($id),
            'getProviderCountry' => ProviderPerson::getProviderCountry($id),
        ));
    }
}