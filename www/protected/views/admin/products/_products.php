<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'fixedHeader' => true,
    'type' => 'striped bordered',
    'dataProvider' => $products,
    'template' => "{items}",
    'columns' => array(
        array(
            'header' => '№',
            'value' => '$row+1',
        ),

        array(
            'header' => 'Зображення',
            'type' => 'raw',
            'value' => function ($data) {
                return '<img src="' . $data->photo . '" width="80" height="60" />';
            }
        ),
        array(
            'header' => 'Країна',
            'value' => function ($data) {
                return $data->provider->country->name;
            }
        ),
        array(
            'header' => 'Назва',
            'value' => function ($data) {
                return $data->name . ' ' . $data->cod . '    ' . ($data->weight > 0 ?: '');
            }
        ),
        array(
            'header' => 'Виробник',
            'value' => function ($data) {
                return $data->manufacturer;
            }
        ),
        array(
            'header' => 'Ціна',
            'value' => function ($data) {
                return $data->price;
            }
        ),
        array(
            'header' => 'Завантаження',
            'value' => function ($data) {
                return date('d.m.Y', strtotime($data->date));
            }
        ),
        array(
            'header' => 'Автоперевірка',
            'value' => function ($data) {
                return date('d.m.Y', strtotime($data->last_check));
            }
        ),
        array(
            'type' => 'raw',
            'header' => '',
            'value' => function ($data) {
                return '<a href="' . Yii::app()->createUrl('/admin/products/update', array('productId' => $data->id, 'id' => $data->user_id)) . '" class="btn btn-primary">Редагувати</a>';
            }
        ),
        array(
            'type' => 'raw',
            'header' => '',
            'value' => function ($data) {
                return '<a href="' . Yii::app()->createUrl('/admin/products/delete', array('id' => $data->id)) . '" class="btn btn-danger">Видалити</a>';
            }
        ),
    ),
)); ?>
