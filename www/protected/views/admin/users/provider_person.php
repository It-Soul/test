<?php $this->renderPartial('_menu', array('id' => $user_id, 'active' => 'provider_person')); ?>
<div class="span10">
    <?php echo TbHtml::well(Users::model()->getUserName($user_id), array('size' => TbHtml::WELL_SIZE_SMALL, 'style' => 'width:100%')); ?>
    <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
        'fixedHeader' => true,
        'headerOffset' => 40,
        'type' => 'striped bordered',
        'dataProvider' => $model,
        'responsiveTable' => true,
        'template' => "{items}",
        'htmlOptions' => array('style' => 'width:100%'),
        'columns' => array(
            array(
                'name' => 'status',
                'header' => 'Постачальник',
                'class' => 'yiiwheels.widgets.grid.WhToggleColumn',
                'htmlOptions' => array('style' => 'width: 20px;text-align:center;'),
                'toggleAction' => '/admin/users/toggle_provider',
                'checkedButtonLabel' => 'Вимкнути',
                'uncheckedButtonLabel' => 'Увімкнути',
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'data_count',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/users/editprovider'),
                    'placement' => 'left',
                    'inputclass' => 'span3',
                ),
                'htmlOptions' => array('style' => 'width:40px;'),
            ),

            array(
                'name' => 'status_hint',
                'class' => 'yiiwheels.widgets.grid.WhToggleColumn',
                'htmlOptions' => array('style' => 'width: 20px;text-align:center;'),
                'toggleAction' => '/admin/users/toggle_provider',
                'checkedButtonLabel' => 'Вимкнути',
                'uncheckedButtonLabel' => 'Увімкнути',

            ),
            array(
                'name' => 'status_country',
                'class' => 'yiiwheels.widgets.grid.WhToggleColumn',
                'htmlOptions' => array('style' => 'width: 20px;text-align:center;'),
                'toggleAction' => '/admin/users/toggle_provider',
                'checkedButtonLabel' => 'Вимкнути',
                'uncheckedButtonLabel' => 'Увімкнути',

            ),

            array(

                'name' => 'country_id',
                'sortable' => true,
                'value' => function ($data) {
                    return $data->country->name;
                }
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'country_delivery',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/users/editprovider'),
                    'placement' => 'left',
                    'inputclass' => 'span3',
                ),
                'htmlOptions' => array('style' => 'width:40px;'),
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'country_logistic',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/users/editprovider'),
                    'placement' => 'left',
                    'inputclass' => 'span3',
                ),
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'country_vat',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/users/editprovider'),
                    'placement' => 'left',
                    'inputclass' => 'span3',

                ),
            ),

        ),
    )); ?>
</div>




