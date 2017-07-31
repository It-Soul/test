<h1>Фільтр</h1>

<div class="span2">
    <div class="well" style="max-width: 340px; padding: 8px 0;">
        <?php echo TbHtml::navList(array(
            array('label' => 'Замовлення <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 0, 'completion' => 0))) . '</span>', 'url' => '/admin/orders'),
            array('label' => 'Логістика <span class="red">' . count(Orders::model()->findAllByAttributes(array('ordered' => 1, 'send' => 0))) . '</span>', 'url' => '/admin/orders/logistic'),
            array('label' => 'Доопрацювання <span class="red">' . $notMatchLogistic . '</span>', 'url' => '/admin/orders/completion'),
            array('label' => 'Аналітика', 'url' => '/admin/orders/filtr', 'active' => true),
            array('label' => 'Переоцінка', 'url' => '/admin/orders/revaluation'),
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
    <?php //echo CHtml::link('Розширений пошук','#',array('class'=>'search-button')); ?>
    <!--<div class="search-form" style="display:none">-->
    <?php //$this->renderPartial('_search',array(
    //	'model'=>$model,
    //)); ?>
    <!--</div><!-- search-form -->
    <br/>
<?php
//foreach ($model as $results => $value) {
//    foreach ($value as $keys => $key) {
//        $user = Users::model()->findByPk($keys);
//        echo date('d.m.Y', strtotime($results)) . '<span style="font-size:18px; font-weight: bold; margin-left:15px"><a href="/admin/users/update?id='.$user->id.'">' . $user->username . '&nbsp;&nbsp;&nbsp;' . $user->organisation_status . '</a></span>';
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
    'type' => 'striped bordered',
    'fixedHeader' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'responsiveTable' => true,
    'template' => "{items}",
    'columns' => array(
        array(
            'header' => '№',
            'value' => '$row+1',
        ),
        array(
            'name' => 'date',
            'value' => 'date("d.m.Y", strtotime($data->date))'
        ),
        array(
            'name' => 'user_id',
            'value' => function ($data) {
                return $data->user->organisation . ' ' . $data->user->organisation_status;
            },
            'filter' => $users
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
            },
            'filter' => array('http://webcatalog.opoltrans.com.pl/' => 'Ополь', 'http://sklep.martextruck.pl/' => "Мартекс", 'http://sklep.skuba.com.pl' => 'Скуба'),
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
            'header' => 'Виробник',

        ),
        array(

            'name' => 'quantity',
            'header' => 'Кількість',
            'sortable' => true,
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
 ?>
    </div>
