<h1>Переоцінка</h1>
<div class="row">
<div class="span2">
    <div class="well" style="max-width: 340px; padding: 8px 0;">
        <?php echo TbHtml::navList(array(
            array('label' => 'Замовлення <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 0, 'completion' => 0))) . '</span>', 'url' => '/admin/orders'),
            array('label' => 'Логістика <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 1, 'send' => 0))) . '</span>', 'url' => '/admin/orders/logistic'),
            array('label' => 'Доопрацювання <span class="red">' . $notMatchLogistic . '</span>', 'url' => '/admin/orders/completion'),
            array('label' => 'Аналітика', 'url' => '/admin/orders/filtr'),
            array('label' => 'Переоцінка', 'url' => '/admin/orders/revaluation', 'active' => true),
        )); ?>
    </div>
</div>

<div class="span10">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'method' => 'get'
    )) ?>
    <div class="span3">
        Від
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'from_date',
            'language' => 'uk',
            'value' => Yii::app()->request->getPost('from_date'),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        )); ?>
    </div>
    <div class="span3">
        &nbsp;До
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'to_date',
            'language' => 'uk',
            'value' => Yii::app()->request->getPost('to_date'),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        )); ?>
    </div>
    <div class="span3">
        <?php echo TbHtml::submitButton('Ок', array('class' => '')); ?>
    </div>

    <?php $this->endWidget(); ?>
    <br/> <br/>
    <?php if (count($model->search()) !== 0) { ?>
        <h6>Введіть курс злотого</h6>
        <?php
        echo CHtml::form(array('action' => '/admin/orders/revaluation'));
        echo CHtml::textField('exchangerates');
        echo CHtml::submitButton('Ок', array('class' => 'btn btn-primary ', 'style' => 'margin-top:-10px;'));
        ?>
        <!--</div><!-- search-form -->

</div>
        </div>
        <div class="row span2 exel_table">
        <?php


        $this->widget('yiiwheels.widgets.grid.WhGridView', array(
            'type' => 'striped bordered',
            'fixedHeader' => true,
            'selectableRows' => 100,
            'dataProvider' => $model->search(),
            'template' => "{items}",
//            'rowCssClass' => array('setGreenColor', 'setFillColor'),
//            'rowCssClassExpression' => '$data->send==0?$this->rowCssClass[1]:$this->rowCssClass[0]',
//            'id' => 'Order_id',
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'id' => 'Order_id'
                ),
                array(
                    'header' => '№',
                    'value' => '$row+1',
                ),
                array(
                    'name' => 'date',
                    'value' => 'date("d.m.Y", strtotime($data->date))'
                ),
                array(
                    'name' => 'user_name',
                    'value' => function ($data) {
                        return $data->user->organisation . ' ' . $data->user->organisation_status;
                    }
                ),
                array(
                    'name' => 'provider',
                    'header' => 'Постачальник',
                    'value' => function ($data) {
                        switch ($data->provider) {
                            case    'http://webcatalog.opoltrans.com.pl/':
                                return 'Ополь';
                                break;
                            case    'http://sklep.martextruck.pl/':
                                return 'Мартекс';
                                break;
                            case    'http://www.intercars.com.pl/':
                                return 'Інтеркарс';
                                break;
                            case    'http://sklep.skuba.com.pl':
                                return 'Скуба';
                                break;

                        }


                    }
                ),
                'name' => array(
                    'name' => 'name',
                    'htmlOptions' => array('style' => 'width:150px; !important'),
                    'header' => 'Назва',
                ),
                array(
                    'name' => 'cod',
                    'header' => 'Номер запчастини'
                ),
                array(
                    'name' => 'manufacturer',
                    'header' => 'Виробник'
                ),
                array(
//            'class' => 'yiiwheels.widgets.editable.WhEditableColumn',
                    'name' => 'quantity',
                    'header' => 'Кількість',
                    'sortable' => true,
//            'editable' => array(
//                'url' => $this->createUrl('/admin/orders/editOrder'),
//                'placement' => 'right',
//                'inputclass' => 'span3',
//            ),
                    'footer' => Orders::model()->getAllSum()['quantity'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00')
                ),
                array(
                    'name' => 'price_in',
                    'header' => 'Ціна PLN',
                    'sortable' => true,
                    'value' => function ($data) {
                        return number_format($data->price_in, 2, ',', '');
                    }
                ),
                array(
                    'name' => 'price_in_sum',
                    'header' => 'Сума PLN',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['price_in_sum'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->price_in_sum, 2, ',', '');
                    }
                ),

                array(
                    'name' => 'vat',
                    'header' => 'VAT',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['vat'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->vat, 2, ',', '');
                    }
                ),
                array(
                    'name' => 'work',
                    'header' => 'Робота',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['work'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->work, 2, ',', '');
                    }
                ),

                array(
                    'name' => 'summary',
                    'header' => 'Загально',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['summary'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->summary, 2, ',', '');
                    }
                ),

                array(
                    'name' => 'manager',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['manager'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->manager, 2, ',', '');
                    }
                ),
                array(
                    'name' => 'courier',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['courier'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->courier, 2, ',', '');
                    }
                ),
                array(
                    'name' => 'admin',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['admin'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->admin, 2, ',', '');
                    }
                ),
                array(
                    'name' => 'course',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['course'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->course, 2, ',', '');
                    }
                ),

                array(
                    'name' => 'price_out',
                    'sortable' => true,
                    'value' => function ($data) {
                        return number_format($data->price_out, 2, ',', '');
                    }
                ),

                array(
                    'name' => 'price_out_sum',
                    'sortable' => true,
                    'footer' => Orders::model()->getAllSum()['price_out_sum'],
                    'footerHtmlOptions' => array('style' => 'background-color:#FFFF00'),
                    'value' => function ($data) {
                        return number_format($data->price_out_sum, 2, ',', '');
                    }
                ),


            ),
        ));
        echo CHtml::endForm();
    } ?>
            </div>
</div>