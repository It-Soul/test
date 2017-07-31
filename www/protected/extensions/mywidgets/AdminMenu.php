<?php

class AdminMenu extends CWidget
{
    public function run()
    {
        $countUsers = count(Users::model()->findAllByAttributes(array('status' => 0)));
        $countOrders = count(Orders::model()->findAllByAttributes(array('ordered' => 0, 'completion' => 0)));
        $countArrears = count(Messages::model()->findAllByAttributes(array('status' => 0)));

        $this->render('admin-menu', array(
            'countUsers' => $countUsers,
            'countOrders' => $countOrders,
            'countArrears' => $countArrears,
        ));
    }
}