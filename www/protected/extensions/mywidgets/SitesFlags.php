<?php

class SitesFlags extends CWidget
{
    public function run()
    {
        $sites = SitesAccessControl::model()->findAll();
        $exchangeRates = ExchangeRates::model()->findByPk(1);

        $this->render('sites-flags', array(
            'sites' => $sites,
            'exchangeRates' => $exchangeRates,
        ));
    }
}