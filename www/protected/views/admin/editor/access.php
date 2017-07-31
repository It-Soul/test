<?php if (Yii::app()->user->hasFlash('access')): ?>
<?php echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('access')); ?>
<?php endif; ?>
<div class="span3">
    <?php $this->widget('ext.mywidgets.Admin.EditorMenu'); ?>
</div>
<div class="span9">
	<h4>Управління логуванням</h4>
	<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
		'headerOffset' => 40,
		'type' => 'striped bordered',
        'dataProvider' => $accessControl,
		'responsiveTable' => true,
		'template' => "{items}",
		'htmlOptions' => array('style' => 'width:100%'),
		'columns' => array(
            array(
                'name' => 'site_name',
                'header' => 'Сайт',
                'value' => function ($data) {
                    return $data->siteinfo->name;
                }
            ),
			array(
				'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
				'name' => 'login',
				'sortable' => true,
				'editable' => array(
					'url' => $this->createUrl('/admin/editor/editAccess'),
					'placement' => 'right',
					'inputclass' => 'span3',
				)
			),
			array(
				'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
				'name' => 'password',
				'sortable' => true,
				'editable' => array(
					'url' => $this->createUrl('/admin/editor/editAccess'),
					'placement' => 'right',
					'inputclass' => 'span3',
				)
			),
		),
	)); ?>

</div>


