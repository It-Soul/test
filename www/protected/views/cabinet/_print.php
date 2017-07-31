<img src="/images/logo.png" width="350"/>
<hr/>
<div class="span3">
    <?php echo date('d.m.Y', strtotime($invoice->date)) ?>
</div>
<div class="span3">
    <?php echo 'Накладна №: ' . $invoice->id ?>
</div>
<br/><br/>
<div class="span12">
    <?php
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
                'header' => 'Назва',
                'value' => function ($data) {
                    return $data->name;
                },
                'htmlOptions' => array('style' => 'width:150px; !important'),
            ),
            'cod' => array(
                'header' => '№ запчастини',
                'value' => function ($data) {
                    return $data->cod;
                },
                'visible' => $user->show_codes
            ),
            'manufacturer' => array(
                'header' => 'Виробник',
                'value' => function ($data) {
                    return $data->manufacturer;
                },
            ),
            'quantity' => array(
                'header' => 'Кількість',
                'value' => function ($data) {
                    return $data->quantity;
                },
                'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic(Yii::app()->user->id, $invoice->date, 1, 1)['quantity'] . ' шт',
                'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
            ),


            'price_out' => array(
                'header' => 'Ціна, грн',
                'value' => function ($data) {
                    return $data->price_out;
                },
            ),
            'price_out_sum' => array(
                'header' => 'Сума, грн',
                'value' => function ($data) {
                    return $data->price_out_sum;
                },
                'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic(Yii::app()->user->id, $invoice->date, 1, 1)['price_out_sum'] . ' грн',
                'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                'htmlOptions' => array('style' => 'width:150px; !important '),
            ),


        ),
    )); ?>
</div>
<script>
    window.print();
</script>
