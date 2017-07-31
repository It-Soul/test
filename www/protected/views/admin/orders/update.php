<?php
/* @var $this OrdersController */
/* @var $model Orders */


$this->menu = array(
    array('label' => 'На головну', 'url' => array('/admin/site/index')),
    array('label' => 'Створити ', 'url' => array('create')),
    array('label' => 'Переглянути', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Список замовленнь', 'url' => array('index')),
);
?>
<div class="span12">
    <h1>Змінити замовлення</h1><br>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
