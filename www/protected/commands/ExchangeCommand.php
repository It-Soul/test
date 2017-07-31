<?php

class ExchangeCommand extends CConsoleCommand
{
    public function run($args)
    {

        $exchange_rates = ExchangeRates::model()->findByPk(1);

        if ($exchange_rates['auto'] == 1) {

            include(Yii::app()->basePath . '/vendors/phpQuery/phpQuery/phpQuery.php');

            $value = file_get_contents('http://goverla.ua/');
            $div = phpQuery::newDocument($value);
            $items = $div->find('.gvrl-table-body')->eq(0);
            foreach ($items as $item) {
                $result = pq($item);
                $results['usd_buy'] = $result->find('.gvrl-table-cell')->eq(1)->text();
                $results['usd_sale'] = $result->find('.gvrl-table-cell')->eq(2)->text();
                $results['euro_buy'] = $result->find('.gvrl-table-cell')->eq(4)->text();
                $results['euro_sale'] = $result->find('.gvrl-table-cell')->eq(5)->text();
                $results['zloty_buy'] = $result->find('.gvrl-table-cell')->eq(19)->text();
                $results['zloty_sale'] = $result->find('.gvrl-table-cell')->eq(20)->text();
                $results_3 = $results;
                unset($results);
            };

            if ($results_3) {

                $usd = (double)$results_3['usd_buy'] / 100;
                $euro = (double)$results_3['euro_buy'] / 100;
                $zloty = (double)$results_3['zloty_buy'] / 100;

                ExchangeRates::model()->updateByPk(1, array(
                    'zloty' => $zloty,
                    'euro' => $euro,
                    'us_dollar' => $usd,
                    'status' => 1
                ));
            } else {
                ExchangeRates::model()->updateByPk(1, array(
                    'status' => 0
                ));
            }
        }

    }
}