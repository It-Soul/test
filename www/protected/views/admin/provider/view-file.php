<?php $this->renderPartial('//admin/users/_menu', array('id' => $user_id)); ?>
<div class="span10">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'results-grid',
        'dataProvider' => $products,
        'columns' => array(
            array(
                'header' => '№',
                'value' => '$row+1',
            ),
            'photo' => array(
                'header' => 'Зображення',
                'type' => 'raw',
                'value' => function ($data) {

                    return '<img class="result_img" src="' . $data->photo . '" width="80" height="60" />';
                },
            ),
            array(
                'header' => 'Країна',
                'value' => function ($data) {
                    if ($this->providerAccess->status_country) {
                        if ($data->provider->status_country) {
                            return $data->provider->country->name;
                        }
                    }
                    return '';
                }
            ),
            array(
                'type' => 'raw',
                'header' => '',
                'value' => function ($data) {
                    if ($this->providerAccess->status_hint) {
                        return TbHtml::tooltip(TbHtml::labelTb('!', array('color' => TbHtml::LABEL_COLOR_IMPORTANT)), 'javascript:;', $this->providerAccess->country_hint, array('data-placement' => TbHtml::TOOLTIP_PLACEMENT_TOP, 'data-html' => true));
                    }
                }
            ),
            'name',
            'manufacturer',
            array(
                'type' => 'raw',
                'header' => 'Ціна',
                'value' => function ($data) {
                    return $data->price . ' ' . $data->currency;
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
        )
    )); ?>
</div>
