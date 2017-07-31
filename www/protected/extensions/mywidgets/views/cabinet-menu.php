<div class="well span2" style="max-width: 340px; padding: 8px 0;">
		<?php echo TbHtml::navList(array(
    array('label' => 'Кабінет', 'url' => '/','active' => $active==''?true:false ),
    array('label' => 'Мої запчастини', 'url' => '#','active' => $active=='#'?true:false ),
    array('label' => 'Запропонувати продажу поштучно', 'url' => '/products/create','active' => $active=='create'?true:false, 'visible'=>$provider_status->uploading_status == 1),
    array('label' => 'Завантажити продажу з файла', 'url' => '/products/uploadFile','active' => $active=='#'?true:false, 'visible'=>$provider_status->file_uploading_status == 1),
    array('label' => 'Архів завантажень', 'url' => '/products/archive','active' => $active=='#'?true:false),
)); ?>
</div>
