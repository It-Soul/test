<div class="navbar navbar-default">
    <?php $this->widget('zii.widgets.CMenu', array(
        'htmlOptions' => array('class' => 'navbar-nav navigation'),
        'activeCssClass' => 'nav_active',
        'encodeLabel' => false,
        'items' => array(
            array('label' => 'Головна', 'url' => array('/admin/site/index')),
            array(
                'label' => 'Клієнти <span class="red">' . $countUsers . '</span>',
                'url' => array('/admin/users'),
                'active' => strstr(Yii::app()->request->requestUri, '/admin/users') != false
            ),
            array(
                'label' => 'Замовлення <span class="red">' . $countOrders . '</span>',
                'url' => array('/admin/orders'),
                'active' => strstr(Yii::app()->request->requestUri, '/admin/orders') != false
            ),
            array(
                'label' => 'Заборгованість <span class="red">' . $countArrears . '</span>',
                'url' => array('/admin/debit'),
                'active' => strstr(Yii::app()->request->requestUri, '/admin/debit') != false
            ),
            array(
                'label' => 'Редактор',
                'url' => '/admin/editor',
                'active' => strstr(Yii::app()->request->requestUri, '/admin/editor') != false
            ),
            array('label' => 'Вихід', 'url' => array('/admin/site/logout'), 'visible' => !Yii::app()->user->isGuest)
        ),
    )); ?>
</div>
     