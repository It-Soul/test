<?php if (!empty($substitutes)) { ?>
    <table id="replacementgrid" class="dgrid" width="100%">
        <tr class="dgridhead">
            <td></td>
            <td class="header-code"><span id=" Код товару  "> Код товару  </span></td>
            <td class="header-name"><span id=" Назва товару  "> Назва товару  </span></td>
            <td class="header-pricenet"><span id=" Ціна,грн "> Ціна,грн </span></td>
        </tr>
        <?php foreach ($substitutes as $substitute) { ?>
            <tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">
                <td class="title-image-url">
                    <img id="ctl00_articlerepeater_ctl01_Image1" width="100"
                         src="<?php echo((isset($substitute['substitute_image'])) ? ('/photos_online/' . $substitute['substitute_image']['image_folder'] . '/' . $substitute['substitute_image']['image_name']) : 'http://sklep.martextruck.pl/Handlers/ArticleImage.ashx?id=no-image&size=1') ?>">
                </td>
                <td class="code">
                    <a href="<?php echo Yii::app()->controller->createUrl("info", array("result_info" => '', "site" => 'http://www.intercars.com.pl/', 'cod' => $substitute['kod_p'])) ?>"><?php echo $substitute['kod_p'] ?></a>
                </td>
                <td class="name"><?php echo $substitute['naz_ru'] ?></td>
                <td id="ctl00_articlerepeater_ctl01_articlerepeatercontrol_price_tdNetPrice" class="pricenet" nowrap="">
                    <?php echo $substitute['substitute_final_price'] ?>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>