<?php

/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
$app = Yii::app();
?>
<div class="info">
    <?php
    $flag_time = false;
    if ((date('H:i', time()) <= date('H:i', strtotime($data_worked['date']))))
        $flag_time = true;
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'results-grid',
        'dataProvider' => $item,
        'template' => '{items}',
        'columns' => array(
            'photo' => array(
                'header' => 'Зображення',
                'type' => 'raw',
                'value' => function ($data) {
                    if (!empty($data['photo_2'])) {
                        return TbHtml::carousel(array(
                            array('image' => $data['photo']),
                            array('image' => $data['photo_2']),
                        ));
                    } else {
                        return '<img class="img" src="' . $data['photo'] . '"/>';
                    }
                },
                'htmlOptions' => array('style' => 'width:500px; height:400px; text-align:center', 'id' => 'photo',)
            ),
            'name' => array(
                'header' => 'Назва',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data['name'];
                },
                'htmlOptions' => array('style' => 'text-align:center', 'id' => 'name',)
            ),
            array(
                'header' => 'Країна',
                'value' => function ($data) {
                    if ($data['status_country'] == 1)
                        return $data['country_name'];
                    else return false;
                }
            ),
            'manufacturer' => array(
                'header' => 'Виробник',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data['manufacturer'];
                },
                'htmlOptions' => array('style' => 'text-align:center', 'id' => 'manufacturer',)
            ),
            'price' => array(
                'header' => 'Ціна, грн',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data['price'];
                },
                'htmlOptions' => array('style' => 'text-align:center', 'id' => 'price',)
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => function ($data) {
                    if ($data['status_hint'])
                        return TbHtml::tooltip(TbHtml::labelTb('!', array('color' => TbHtml::LABEL_COLOR_INFO)), 'javascript:;', $data['country_hint']);
                }
            ),
            'stock_2' => array(
                'header' => 'Наявність(Філії)',
                'type' => 'raw',
                'value' => function ($data) {
                    return $data['stock_2'];
                },
                'htmlOptions' => array('style' => 'text-align:center', 'id' => 'stock',)
            ),
            'stock' => array(
                'header' => 'Наявність(Центр)',
                'type' => 'raw',
                'value' => function ($data) {

                    return $data['stock'];
                },
                'htmlOptions' => array('style' => 'text-align:center', 'id' => 'stock',)
            ),
        ),
    )); ?>
</div>
<div style="margin: 25px;font-family: 'Arial Black'">
    <?php
    echo '<span class="minus">-</span><input type="text" id="quantity" value="1" size="5" style="width: 50px; margin: 10px 1px"/><span class="plus">+</span>';
    echo CHtml::button('Замовити', array(
        'type' => 'button',
        'id' => 'go',
        'class' => 'btn btn-primary',
        'style' => 'margin-left: 30px',
    ));
    echo CHtml::button('В корзину', array(
            'type' => 'button',
            'id' => 'go-cart',
            'class' => 'btn btn-success',
            'style' => 'margin-left: 30px',
        )) . '<br/>';
    ?>

    <input type="hidden" id="hiddenPrice" value="<?php echo $item_info['price_one'] ?>"/>
    <input type="hidden" id="hiddenDefaultPrice" value="<?php echo $item_info['def_price'] ?>"/>
    <input type="hidden" id="site_name" value="<?php echo $item_info['provider'] ?>"/>
    <input type="hidden" id="cod" value="<?php echo $item_info['cod'] ?>"/>
    <?php
    echo TbHtml::tabbableTabs(array(
        array('label' => 'Інші номера оригіналів', 'active' => true, 'content' => $table_7, 'visible' => (!empty($table_7))),
        array('label' => 'Коди ОЕ', 'content' => $table_2, 'visible' => (!empty($table_2))),
        array('label' => 'Замінники', 'content' => $table_6, 'visible' => (!empty($table_6))),
        array('label' => 'Інформація', 'content' => $table_1, 'visible' => (!empty($table_1))),
        array('label' => 'Є частиною', 'content' => $table_3, 'visible' => (!empty($table_3))),
        array('label' => 'Коди ОЕ TECDOC', 'content' => $table_4, 'visible' => (!empty($table_4))),
        array('label' => 'В транспортних засобах', 'content' => $table_5, 'visible' => (!empty($table_5))),


    )); ?>
</div>
<?php if (Yii::app()->session['session_info'] == 1) {
    $is_advance = 1;
} else {
    $is_advance = 0;
} ?>

<script>
    $(document).ready(function () {
        $("#go").click(function () {
            var name = $("#name").text();
            var manufacturer = $("#manufacturer").text();
            var price = $("#price").text();
            var quantity = $("#quantity").val();
            var priceOne = $("#hiddenPrice").val();
            var priceDef = $("#hiddenDefaultPrice").val();
            var data_4 = $("#cod").val();
            var provider = $("#site_name").val();
            var data = {
                Orders: {
                    name: name,
                    cod: data_4,
                    price_out_sum: parseFloat(price),
                    quantity: parseInt(quantity),
                    price_in: parseFloat(priceDef),
                    price_out: parseFloat(priceOne),
                    price_in_sum: parseFloat(priceDef) * parseInt(quantity),
                    provider: provider,
                    manufacturer: manufacturer,
                    is_advance: <?php echo $is_advance?>
                }
            };
            $.ajax({
                type: "POST",
                url: "/site/add",
                data: data,
                success: function (json) {
                    var echo = JSON.parse(json);
                    if (echo['status'] == true) {
                        alert("Ваше замовлення прийнято");
                        window.history.back();
                    }

                }
            })
        });
        $('.minus').click(function () {
            var $input = $(this).parent().find('#quantity');
            var count = parseInt($input.val()) - 1;
            var price = $("#price").text();
            var hidPrice = parseFloat($("#hiddenPrice").val());
            if (count >= 1) {
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                $("#price").text((parseFloat(price) - hidPrice).toFixed(2));
            }
            return false;
        });
        $('.plus').click(function () {
            var $input = $(this).parent().find('#quantity');
            var price = $("#price").text();
            var hidPrice = parseFloat($("#hiddenPrice").val());
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            $("#price").text((parseFloat(price) + hidPrice).toFixed(2));
            return false;
        });
        $("#quantity").change(function () {
            var input = parseInt($(this).val());
            var price = $("#price").text();
            var hidPrice = parseFloat($("#hiddenPrice").val());
            $("#price").text((input * hidPrice).toFixed(2));
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#go-cart").click(function () {
            var name = $("#name").text();
            var manufacturer = $("#manufacturer").text();
            var price = $("#price").text();
            var quantity = $("#quantity").val();
            var priceOne = $("#hiddenPrice").val();
            var priceDef = $("#hiddenDefaultPrice").val();
            var data_4 = $("#cod").val();
            var provider = $("#site_name").val();
            var photo = $("#photo").find("img").attr("src");


            var data = {
                Orders: {
                    name: name,
                    cod: data_4,
                    price_out_sum: parseFloat(price),
                    quantity: parseInt(quantity),
                    price_in: parseFloat(priceDef),
                    price_out: parseFloat(priceOne),
                    price_in_sum: parseFloat(priceDef) * parseInt(quantity),
                    provider: provider,
                    manufacturer: manufacturer,
                    photo: photo,
                    is_advance: <?php echo $is_advance?>
                }
            };
            $.ajax({
                type: "POST",
                url: "/cart/add",
                data: data,
                success: function (json) {
                    var echo = JSON.parse(json);
                    if (echo['status'] == true) {
                        alert("Товар додано");
                        window.history.back();
                    }

                }
            })
        });
    });
</script>

