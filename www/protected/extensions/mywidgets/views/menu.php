<div class="pull-right" style="margin-top:65px">
<div class="row" style="list-style-type: none">
<?php
$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => false,
    'items' => array(
        array('label' => Yii::app()->user->organisation, 'url' => array('/cabinet')),
        array('label' => 'Кошик ' . $cart_sum . ' грн', 'url' => array('/cart/index')),
        array('label' => 'Мої замовлення ' . $orders_sum . ' грн', 'url' => array('/cabinet/orders')),
        array('label' => 'Заборгованість ' . $arrears . ' грн', 'url' => array('/cabinet/arrears')),
        array('label' => 'Декларації/Відправки <span class="red">' . $decl_count . '</span>', 'url' => array('/cabinet/declarations')),
    ),
    'htmlOptions'=>array('style'=>'list-style-type: none',)
));?>

</div>

<div class="row" style="margin-left: 4px">
<?php
if ($advance['advance'] == 1) {
    if (Yii::app()->session['session_info'] == 1) {
        echo CHtml::link('Режим передоплати(викл)', '/site/index_payment_2?id=' . Yii::app()->request->getQuery('query', ''), array('class' => 'btn btn-primary'));
    } else {
        echo CHtml::link('Режим передоплати(вкл)', '/site/index_payment?id=' . Yii::app()->request->getQuery('query', ''), array('class' => 'btn btn-danger'));
    }
}
?>
</div>
</div>
<br>