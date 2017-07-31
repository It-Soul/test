<?php
if ($orders) {
    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'fixedHeader' => true,
        'type' => 'striped bordered',
        'dataProvider' => $orders,
        'template' => "{items}",
        'columns' => array(
            array(
                'header' => '№',
                'value' => '$row+1',
            ),

            'name' => array(
                'name' => 'name',
                'htmlOptions' => array('style' => 'width:150px; !important'),
            ),
            'cod' => array(
                'name' => 'cod',
                'visible' => $user->show_codes
            ),
            'manufacturer',
            'quantity' => array(
                'name' => 'quantity',
                'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['quantity'] . ' шт',
                'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
            ),


            'price_out',
            'price_out_sum' => array(
                'name' => 'price_out_sum',
                'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic($user->id, $invoice->date, 1, 1)['price_out_sum'] . ' грн',
                'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                'htmlOptions' => array('style' => 'width:150px; !important '),
            ),
        ),
    ));
} ?>
<?php if ($message) {
    echo $message;
} ?>

