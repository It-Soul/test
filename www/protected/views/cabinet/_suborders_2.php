<!--<p>-->
<!--    <button type="button" class="btn btn-default pull-right" id="print" data-invoice="--><?php //echo $invoice->id ?><!--">-->
<!--        Надрукувати-->
<!--    </button>-->
<!--</p><br/><br/>-->
<?php
if ($orders) {
    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'fixedHeader' => true,
        'type' => 'striped bordered',
        'dataProvider' => $orders,
        'template' => "{items}",
        'columns' => array(
//        array(
//            'class' => 'CCheckBoxColumn',
//        ),
            array(
                'header' => '№',
                'value' => '$row+1',
            ),
//			array(
//				'name' => 'date',
//				'value' => 'date("d.m.Y", strtotime($data->date))'
//			),
            //'footer'=>array(),
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
                'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic(Yii::app()->user->id, $invoice->date, 1, 1)['quantity'] . ' шт',
                'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
            ),


            'price_out',
            'price_out_sum' => array(
                'name' => 'price_out_sum',
                'footer' => 'Разом: ' . Orders::model()->getUserSumByDateLogistic(Yii::app()->user->id, $invoice->date, 1, 1)['price_out_sum'] . ' грн',
                'footerHtmlOptions' => array('style' => ' background-color: #FFFF00'),
                'htmlOptions' => array('style' => 'width:150px; !important '),
            ),


        ),
    ));
} ?>
<?php if ($message) {
    echo $message;
} ?>
<!--<script>-->
<!--    $('#print').click(function () {-->
<!--        var button = $(this);-->
<!--        window.open('/cabinet/print?id=' + button.attr('data-invoice'), '_blank');-->
<!--//        window.location.href = '/cabinet/print?id='+button.attr('data-invoice');-->
<!--//        $.ajax({-->
<!--//            type: 'POST',-->
<!--//            url: '/cabinet/print',-->
<!--//            data: {-->
<!--//                id: button.attr('data-invoice')-->
<!--//            },-->
<!--//            success: function (response) {-->
<!--//                var win = window.open();-->
<!--//-->
<!--//                win.document.write(response);-->
<!--//                win.document.close()-->
<!--//-->
<!--//            }-->
<!--//        })-->
<!---->
<!--    })-->
<!--</script>-->
