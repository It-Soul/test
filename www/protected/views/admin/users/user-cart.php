<?php $this->renderPartial('_menu', array('id' => $id, 'active' => 'user-cart')); ?>
<div class="span10">
    <?php
    $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'type' => 'striped bordered',
        'fixedHeader' => true,
        'dataProvider' => $items,
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
                'footer' => Cart::model()->getCartSum($id),
                'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                'htmlOptions' => array(
                    'style' => 'width: 80px'
                )
            ),
            array(
                'name' => 'date',
                'header' => 'Додано',
                'sortable' => true,
                'htmlOptions' => array(
                    'style' => 'width: 80px'
                )
            ),

        ),
    ));

    ?>
</div>
<br/>