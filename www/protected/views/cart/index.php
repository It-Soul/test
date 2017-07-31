<?php
/* @var $this CartController */

$this->breadcrumbs = array(
    'Кошик',
);


 if (Yii::app()->user->hasFlash('cart_success')): ?>
    </br>
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('cart_success')); ?>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('cart_error')): ?>
    <?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('cart_error')); ?>
<?php endif; ?>
<?php echo CHtml::form();

    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'type' => 'striped bordered',
        'fixedHeader' => true,
        'dataProvider' => $dataProvider,
        'template' => "{items}",
        'selectableRows' => 50,
//        'htmlOptions' => array('style' => 'width:150%;'),
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'Cart_id',
//                'value' => function ($data, $key) {
//                    return $key;
//                }
            ),
            array(
                'header' => '№',
                'value' => '$row+1',
                'htmlOptions' => array(
                    'style' => 'width: 30px'
                )
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::image($data['photo'], '', array('width' => 80, 'height' => 60));
                },
                'htmlOptions' => array(
                    'style' => 'width: 80px'
                )
            ),
            'name' => array(
                'name' => 'name',
                'header' => 'Назва',
                'htmlOptions' => array('style' => 'width:400px; !important'),
            ),

            array(
                'name' => 'manufacturer',
                'header' => 'Виробник',
                'htmlOptions' => array('style' => 'width:70px;'),
            ),

            array(
//                        'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'quantity',
                'header' => 'Кількість',
                'sortable' => true,

                'type' => 'raw',
                // 'footer' => Orders::model()->getUserSumByDate($keys, $results)['quantity'],
//                 'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                'htmlOptions' => array('style' => 'width:70px;'),
            ),


            array(
                'name' => 'price_out',
                'header' => 'Ціна грн',
                'sortable' => true,
                'htmlOptions' => array(
                    'style' => 'width: 80px'
                )
            ),
            array(
                'name' => 'price_out_sum',
                'header' => 'Сума грн',
                'sortable' => true,
                'footer' => Cart::model()->getCartSum(Yii::app()->user->id),
                'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                'htmlOptions' => array(
                    'style' => 'width: 80px'
                )
            ),


        ),
    ));

?>
<br/>
<div class="pull-right">
    <?php echo CHtml::submitButton('Купити виділене', array('class' => 'btn btn-primary', 'formaction' => '/cart/buy')); ?>
    <?php echo CHtml::submitButton('Видалити виділене', array('class' => 'btn btn-danger', 'formaction' => '/cart/delete')); ?>
</div>

<?php echo CHtml::endForm(); ?>
<br/><br/>
