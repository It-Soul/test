<?php $this->renderPartial('_cabinetmenu'); ?>
<div class="span10">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        </br><?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success')); ?>
    <?php endif; ?>
    <?php if (Yii::app()->user->hasFlash('error')): ?>
        </br><?php echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('error')); ?>
    <?php endif; ?>

    <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'type' => 'striped bordered',
        'dataProvider' => $files,
        'template' => "{items}",
        'columns' => array_merge(array(
            array(
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'header' => 'Назва файлу',
                'url' => $this->createUrl('/products/getFileProducts'),
                'value' => function ($data) {
                    return $data->name;
                },
            )
        ), array(
            array(
                'header' => 'Кількість позицій у файлі',
                'value' => function ($data) {
                    return $data->positions_amount;
                }
            ),
            array(
                'header' => 'Дата створення',
                'value' => function ($data) {
                    return date('d.m.Y', strtotime($data->created_at));
                },
            ),
            array(
                'header' => 'Дата автоперевірки',
                'value' => function ($data) {
                    return date('d.m.Y', strtotime($data->last_check));
                },
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => function ($data) {
                    return '<a href="/products/deleteFile?id=' . $data->id . '" class="btn btn-danger" onclick="return confirm(\'Впевнені,що хочете видалити файл?\')" >Видалити</a>';
                },
            ),
        )),
    )); ?>

    <h4>Завантажено поштучно <?php echo ProviderPerson::getUploadedProductsCount($this->providerAccess->user_id) ?>
        /<?php echo $this->providerAccess->allowed_products_amount ?></h4>
    <?php $this->renderPartial('//products/_products', array('products' => $products)); ?>
</div>