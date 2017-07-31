<div class="span3">
    <?php $this->widget('ext.mywidgets.Admin.EditorMenu'); ?>
</div>
<div class="span9">
    <h4>Курс валют</h4>
    <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
//		'fixedHeader' => true,
        'headerOffset' => 40,
        'type' => 'striped bordered',
        'dataProvider' => $exchange_rates->search(),
        'responsiveTable' => true,
        'template' => "{items}",
        'htmlOptions' => array('style' => 'width:110%'),
        'columns' => array(
//		'id',
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'zloty',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/editor/editCurrency'),
                    'placement' => 'right',
                    'inputclass' => 'span3',
                )
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'zloty_repair',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/editor/editCurrency'),
                    'placement' => 'right',
                    'inputclass' => 'span3',
                )
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'euro',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/editor/editCurrency'),
                    'placement' => 'right',
                    'inputclass' => 'span3',
                )
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'euro_repair',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/editor/editCurrency'),
                    'placement' => 'right',
                    'inputclass' => 'span3',
                )
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'us_dollar',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/editor/editCurrency'),
                    'placement' => 'right',
                    'inputclass' => 'span3',
                )
            ),
            array(
                'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                'name' => 'us_dollar_repair',
                'sortable' => true,
                'editable' => array(
                    'url' => $this->createUrl('/admin/editor/editCurrency'),
                    'placement' => 'right',
                    'inputclass' => 'span3',
                )
            ),
            array(
                'class'=>'yiiwheels.widgets.grid.WhToggleColumn',
                'toggleAction'=>'/admin/editor/toggle', // contoller/action
                'htmlOptions' => array('style' => 'text-align:center;'),
                'name' => 'auto',
                'sortable'=>true,
                'header' => 'Автоматичний режим',
                'checkedButtonLabel' => 'Вимкнути',
                'uncheckedButtonLabel' => 'Увімкнути',
            ),
//            array(
//                'class'=>'yiiwheels.widgets.grid.WhToggleColumn',
//                'toggleAction'=>'/admin/editor/toggle', // contoller/action
//                'htmlOptions' => array('style' => 'text-align:center;'),
//                'name' => 'advance',
//                'sortable'=>true,
//                'header' => 'Передоплата',
//                'checkedButtonLabel' => 'Вимкнути',
//                'uncheckedButtonLabel' => 'Увімкнути',
//            ),
        ),
    )); ?>
</div>
