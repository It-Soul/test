<div class="span2">
    <div class="well" style="max-width: 340px; padding: 8px 0;margin-top: 39px;">
        <?php echo TbHtml::navList(array(
            array('label' => 'Замовлення/Аналітика', 'url' => '/admin/users/orders?id=' . $id, 'active' => $active == 'orders' ? true : false),
            array('label' => 'Інформація', 'url' => '/admin/users/update?id=' . $id, 'active' => $active == 'update' ? true : false),
            array('label' => 'Дебіторський аналіз', 'url' => '/admin/users/debit?id=' . $id, 'active' => $active == 'debit' ? true : false),
            array('label' => 'Декларації/Відправки', 'url' => '/admin/users/declarations?id=' . $id, 'active' => $active == 'declarations' ? true : false),
            array('label' => 'Коефіцієнти', 'url' => '/admin/users/coefficients?id=' . $id, 'active' => $active == 'coefficients' ? true : false),
            array('label' => 'Коефіцієнти країн', 'url' => '/admin/users/countrycoef?id=' . $id, 'active' => $active == 'countrycoef' ? true : false),
            array('label' => 'Корзина', 'url' => '/admin/users/userCart?id=' . $id, 'active' => $active == 'user-cart' ? true : false),
        )); ?>
    </div>
    <?php $this->widget('ext.mywidgets.Admin.ProviderMenu'); ?>
</div>