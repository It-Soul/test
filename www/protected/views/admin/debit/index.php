<div class="row span12">
    <div class="span5">
        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'type' => 'striped bordered',
            'fixedHeader' => true,
            'dataProvider' => $debtorsList,
            'template' => "{items}",
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                ),
                array(

                    'header' => '№',
                    'value' => '$row+1',

                ),
                'organisation' => array(
                    'header' => 'Клієнт',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return '<a href="/admin/users/debit?id=' . $data->id . '">' . $data->organisation . '</a>';
                    },
                    'footer' => 'Разом:',
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                ),
                array(
                    'header' => 'Заборгованість',
                    'value' => function ($data) {
                        return
                            Orders::model()->getUserArrears($data->id);
                    },
                    'footer' => "$debtAmount грн",
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                ),


            ),
        )); ?>
    </div>
    <div class="span6">
        <?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'type' => 'striped bordered',
            'fixedHeader' => true,
            'dataProvider' => $messagesList,
            'template' => "{items}",
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                ),
                'user_name' => array(
                    'name' => 'user_name',
                    'header' => 'Клієнт'
                ),
                'text' => array(
                    'name' => 'text',
                    'header' => 'Сума'
                ),
                'date' => array(
                    'name' => 'date',
                    'header' => 'Дата'
                ),
                array(
                    'header' => 'Відм.',
                    'name' => 'status',
                    'type' => 'raw',
                    'value' => function ($data) {
                        return $data->status == 1 ? '<span class="btn btn-success">Переглянуто</span>' : '<a href="/admin/debit/setStatus?id=' . $data->id . '" class="btn btn-primary" id="order" >Ok</a>';
                    },
                    'htmlOptions' => array('style' => 'text-align:center')
                ),

            ),
        )); ?>
    </div>
</div>

