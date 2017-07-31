<div class="well" style="max-width: 340px; padding: 8px 0;">
    <?php echo TbHtml::navList(array(
        array('label' => 'Управліня курсом валют', 'url' => '/admin/editor/exchange', 'active' => $active == 'exchange' ? true : false),
        array('label' => 'Доступи сайтів', 'url' => '/admin/editor/access', 'active' => $active == 'access' ? true : false),
        array('label' => 'Налаштування коефіцієнтів', 'url' => '/admin/editor/coefficients', 'active' => $active == 'coefficients' ? true : false),
        array('label' => 'Календар логістики', 'url' => '/admin/editor/calendar', 'active' => $active == 'calendar' ? true : false),
        array('label' => 'Управління візуалізації', 'url' => '/admin/editor/visualization', 'active' => $active == 'visualization' ? true : false),
        array('label' => 'Управліня доступом', 'url' => '/admin/users', 'active' => $active == 'users' ? true : false),
    )); ?>
</div>