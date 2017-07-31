<div style="text-align: center;min-height: 494px; margin: 0 20px">
    <br>
    <!--<div class="row-fluid">-->
    <h6>Виберіть користувача</h6>
    <form class="form-horizontal" name="search_form" method="get">
        <?php
        $this->widget('ext.select2.XSelect2', array(
            'model' => $model,
            'attribute' => 'id',
            'value' => '1',
            'data' => $users,
            'htmlOptions' => array(
                'style' => 'width:300px',
                'placeholder' => Yii::app()->session['user'],
            ),
        ));
        ?>
        <br>
        <br>
        <div class="form-group">
            <div class="col-xs-10">
                <input type="text" name="query" class="searchField" placeholder="Введіть номер">
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">

                <input type="submit" id="loading-example-btn" data-loading-text="Триває пошук..." name="searchbtn"
                       value="Пошук" class="btn btn-primary">
                <input type="reset" name="resetbtn" value="Очистити" class="btn btn-success">
            </div>
        </div>
    </form>
    <script>
        $('#loading-example-btn').click(function () {
            var btn = $(this);
            btn.button('loading');
        });
        $('#Users_id').val(<?php echo Yii::app()->session['user'] ?>);
    </script>

    <?php

    if (isset($_GET['query'])) {

        echo '<h3>Результати пошуку за номером ' . $_GET['query'] . '</h3>';

        if ((!empty($results_2) || !empty($opol_results) || !empty($intercars_products) || !empty($query)) && !empty($empty)) {
            $flag = 1;
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'results-grid',
                'dataProvider' => $model_2->search(),
                'columns' => array(
                    array(
                        'header' => '№',
                        'value' => '$row+1',
                    ),
                    'result_photo' => array(
                        'header' => 'Зображення',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<img class="result_img" src="' . $data->result_photo . '" width="80" height="60" />';
                        },
                    ),
                    array(
                        'header' => 'Країна',
                        'value' => function ($data) {
                            if ($data->site == 'private_person') {
                                if ($data->providerinfo->status_country == 1)
                                    return $data->providerinfo->country->name;
                                else return false;
                            } else return 'Польща';
                        }
                    ),
                    'result_name',
                    array(
                        'type' => 'raw',
                        'header' => '',
                        'value' => function ($data) {
                            if ($data->site == 'private_person') {
                                if ($data->providerinfo->status_hint)
                                    return TbHtml::tooltip(TbHtml::labelTb('!', array('color' => TbHtml::LABEL_COLOR_INFO)), 'javascript:;', $data->providerinfo->country_hint);
                            }
                        }
                    ),
                    'result_manufacturer',
                    'result_price',
                    array(
                        'value' => function ($data) {
                            switch ($data->site) {
                                case 'http://webcatalog.opoltrans.com.pl/' :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, "photo" => $data->result_photo, 'price' => $data->result_price, 'def_price' => $data->def_price, 'name' => $data->result_name, 'manufacturer' => $data->result_manufacturer, 'cod' => $data->result_cod, 'state' => $data->result_state)));
                                    break;
                                case 'http://www.intercars.com.pl/' :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, 'cod' => $data->result_cod)));
                                    break;
                                case 'http://www.diesel-czesci.pl/':
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, "photo" => $data->result_photo, 'price' => $data->result_price, 'def_price' => $data->def_price, 'name' => $data->result_name)));
                                    break;
                                case 'private_person' :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "product_id" => $data->product_id, "site" => $data->site, 'price' => $data->result_price)));
                                    break;
                                case 'https://sklep.autos.com.pl/':
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, "photo" => $data->result_photo, 'price' => $data->result_price, 'def_price' => $data->def_price, 'name' => $data->result_name, 'manufacturer' => $data->result_manufacturer, 'cod' => $data->result_cod, 'info' => $data->info, 'state' => $data->result_state)));
                                    break;
                                default :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, 'price' => $data->result_price, 'def_price' => $data->def_price)));
                            }

                        },
                        'type' => 'html',
                    ),

                ),
            ));

        } else $flag = 0;
    }
    if ($flag === 1) {
        echo '';
    }
    if ($flag === 0) {
        echo 'Даних товарів немає в наявності!';
    }
    ?>
</div>
</div>
</div>