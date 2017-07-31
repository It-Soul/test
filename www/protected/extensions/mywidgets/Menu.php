<?php

/**
 * Created by PhpStorm.
 * User: Roma
 * Date: 06.07.2016
 * Time: 17:05
 */
class Menu extends CWidget
{
    // этот метод будет вызван внутри CBaseController::endWidget()
    public function run()
    {
        $orders_sum = Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0)['price_out_sum'];
        $cart_sum = Cart::model()->getCartSum(Yii::app()->user->id);
//        $decl_count = count(Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, $results, 0, 0, 0)['price_out_sum'] + Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, $results, 1, 0)['price_out_sum']);
        $decl_count = count(Declarations::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id, 'status' => 0)));
        $arrears = Orders::model()->getUserArrears(Yii::app()->user->id);
        $advance = Users::model()->findByAttributes(array('id' => Yii::app()->user->id));
        $this->render('menu', array(
            'orders_sum' => $orders_sum,
            'cart_sum' => $cart_sum,
            'decl_count' => $decl_count,
            'arrears' => $arrears,
            'advance' =>$advance
        ));
    }
}