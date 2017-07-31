<?php
/**
 * Created by PhpStorm.
 * User: Roma
 * Date: 15.03.2017
 * Time: 1:56
 */
?>
<?php $this->renderPartial('_menu', array('id' => $user_id, 'active' => 'countrycoef')); ?>
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
            'class'=>'yiiwheels.widgets.grid.WhToggleColumn',
            'toggleAction'=>'/admin/users/toggle_countrycof', // contoller/action
            'htmlOptions' => array('style' => 'width: 20px;text-align:center;'),
            'name' => 'status',
            'sortable'=>true,
            'header' => '',
            'checkedButtonLabel' => 'Вимкнути',
            'uncheckedButtonLabel' => 'Увімкнути',
        ),
        array(
            'name' => 'country_id',
            'header'=>'Країна',
            'value' =>function($data){
                return $data->country->name;
            }
        ),
        array(
            'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
            'name' => 'vat',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('/admin/users/editCountryCoef'),
                'placement' => 'right',
                'inputclass' => 'span3',
            ),
            'visible' => Yii::app()->user->getRole('administrator')
        ),
        array(
            'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
            'name' => 'manager_coef',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('/admin/users/editCountryCoef'),
                'placement' => 'right',
                'inputclass' => 'span3',
            ),
            'visible' => Yii::app()->user->checkAccess('administrator') || Yii::app()->user->checkAccess('moderator') || Yii::app()->user->checkAccess('user')
        ),
        array(
            'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
            'name' => 'curator_coef',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('/admin/users/editCountryCoef'),
                'placement' => 'right',
                'inputclass' => 'span3',
            ),
            'visible' => Yii::app()->user->checkAccess('administrator') || Yii::app()->user->checkAccess('moderator')
        ),
        array(
            'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
            'name' => 'admin_coef',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('/admin/users/editCountryCoef'),
                'placement' => 'right',
                'inputclass' => 'span3',
            ),
            'visible' => Yii::app()->user->checkAccess('administrator')
        ),

    ),
)); ?>
</div>
