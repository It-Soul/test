<?php

class InvoicesCommand extends CConsoleCommand
{
    public function run($args) {

        $users = Orders::model()->findAll(array(
            'select' => 't.user_id',
            'group' => 't.user_id',
            'order' => 't.user_id DESC',
            'distinct' => true,
            'condition' => 't.date=:date AND t.ordered=:ordered AND t.send=:send AND t.quantity=t.received',
            'params' => array('date' => date('Y-m-d', time()), 'ordered' => 1, 'send' => 1),
        ));

        if ($users) {
            foreach ($users as $user) {
                $userOrders = Orders::model()->findAllByAttributes(array(
                    'date' => date('Y-m-d', time()),
                    'user_id' => $user->user_id,
                    'ordered' => 1,
                    'send' => 1
                ),
                    'quantity=received'
                );
                $userOrdersSum = 0;
                foreach ($userOrders as $userOrder) {
                    $userOrdersSum += $userOrder['price_out_sum'];
                }

                Yii::app()->db->createCommand()->insert('invoices', array(
                    'date' => date('Y-m-d', time()),
                    'sum' => $userOrdersSum,
                    'user_id' => $user->user_id,
                ));
            }
        }
    }
}