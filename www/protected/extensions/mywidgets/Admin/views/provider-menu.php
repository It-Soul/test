<div class="well" style="max-width: 340px; padding: 8px 0;margin-top: 39px;">
    <div class="btn-group">
        <a href="<?php echo Yii::app()->createUrl('/admin/provider/disable', array('id' => $id)) ?>"
           class="btn btn-danger" style="font-size: 9px" <?php echo $providerStatus == 0 ? 'disabled' : '' ?>>Заблоковано</a>
        <a href="<?php echo Yii::app()->createUrl('/admin/provider/enable', array('id' => $id)) ?>"
           class="btn btn-primary" style="font-size: 9px" <?php echo $providerStatus == 1 ? 'disabled' : '' ?>>Розблоковано</a>
    </div>
    <br/>
    <br/>
    <div style="margin-top: 1px;"><?php echo $getProviderCountry?></div>
    <br/>
    <?php echo TbHtml::navList(array(
        array('label' => 'Постачальник', 'url' => '/admin/provider/settings?id=' . $id, 'active' => strstr(Yii::app()->request->requestUri, '/admin/provider/settings') != false ? true : false),
        array('label' => 'Завантаження', 'items' => array(
            array('label' => 'Файлом', 'url' => '/admin/provider/uploadFile?id=' . $id, 'active' => strstr(Yii::app()->request->requestUri, '/admin/provider/fileUpload') != false ? true : false),
            array('label' => 'Поштучно', 'url' => '/admin/products/create?id=' . $id, 'active' => strstr(Yii::app()->request->requestUri, '/admin/products/create') != false ? true : false),
        )),
        array('label' => 'Архів завантажень', 'url' => '/admin/products/archive?id=' . $id, 'active' => strstr(Yii::app()->request->requestUri, '/admin/products/archive') != false ? true : false),
    )); ?>
</div>