<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#results-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
$app = Yii::app();
?>


<div style="text-align: center;min-height: 494px; margin: 0 20px">
    <div class="span4">
        <h3>Дати виїзду логістів</h3>
        <?php $this->widget('ext.yiicalendar.YiiCalendar', array
        (
            'linksArray' => $calendarItems,
        )); ?>
    </div>
    <div class="span8">
        <h3>До кінця робочого дня:</h3>
        <div id="CDT"></div>
        <br>
        <form class="form-horizontal" name="search_form" method="get">
            <div class="form-group">
                <div class="col-xs-10">
                    <input type="text" name="query" class="searchField" placeholder="Введіть номер">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <input type="submit" id="loading-example-btn" data-loading-text="Триває пошук..."
                           name="searchbtn" value="Пошук" class="btn btn-primary">
                    <input type="reset" name="resetbtn" value="Очистити" class="btn btn-success">
                </div>
            </div>

        </form>
    </div>

    <script>
        $('#loading-example-btn').click(function () {
            var btn = $(this);
            btn.button('loading');
        });
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
                                if ($data->providerinfo->country->name)
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
                                if ($data->provider->status_hint)
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
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, "photo" => $data->result_photo, 'price' => $data->result_price, 'def_price' => $data->def_price, 'name' => $data->result_name, 'manufacturer' => $data->result_manufacturer, 'cod' => $data->result_cod, 'state' => $data->result_state, 'phrase' => $data->query)));
                                    break;
                                case 'http://www.intercars.com.pl/' :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, 'cod' => $data->result_cod)));
                                    break;
                                case 'private_person' :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "product_id" => $data->product_id, "site" => $data->site, 'price' => $data->result_price)));
                                    break;
                                case 'http://www.diesel-czesci.pl/':
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, "photo" => $data->result_photo, 'price' => $data->result_price, 'def_price' => $data->def_price, 'name' => $data->result_name)));
                                break;
                                case 'https://sklep.autos.com.pl/':
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site, "photo" => $data->result_photo, 'price' => $data->result_price, 'def_price' => $data->def_price, 'name' => $data->result_name,'manufacturer' =>$data->result_manufacturer,'cod' => $data->result_cod,'info' =>$data->info, 'state' => $data->result_state)));
                                    break;

                                default :
                                    return CHtml::link("Детальніше", Yii::app()->controller->createUrl("info", array("result_info" => $data->result_info, "site" => $data->site)));
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


<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>
    $(document).ready(function () {
        $("#go").live("click", function () {
            var data_1 = $(this).siblings("strong").children(".in_01").text();
            var data_2 = $(this).siblings("strong").children(".in_02").text();
            var data_3 = $(this).siblings("strong").children(".in_03").text();
            var data = data_1 + data_2 + data_3;
            var data_4 = $(this).siblings("#cod").children("span").text();
            var price = $(this).siblings("#price").text();
            var priceDef = $(this).siblings("#hiddenDefaultPrice").val();
            var priceOne = $(this).siblings("#hiddenPrice").val();
//			var sh_price=price.length-3;
//			var lg_price=price.substring(0,sh_price);
//			var final_price=lg_price.replace(",",".");
            var quantity = $(this).siblings("#quantity").val();
            var provider = $(this).siblings("#site_name").val();
            var manufacturer = $(this).siblings("#manufacturer").text();
//			alert(quantity*final_price);

            var data = {
                Orders: {
                    name: data,
                    cod: data_4,
                    price_out_sum: parseFloat(price),
                    quantity: parseInt(quantity),
                    price_in: parseFloat(priceDef),
                    price_out: parseFloat(priceOne),
                    price_in_sum: parseFloat(priceDef) * parseInt(quantity),
                    provider: provider,
                    manufacturer: manufacturer
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
                        location.reload();
                    }

                }
            })
        });
        $('.minus').live("click", function () {
            var $input = $(this).parent().find('#quantity');
            var count = parseInt($input.val()) - 1;
            var price = $(this).siblings("#price").text();
            var hidPrice = parseFloat($(this).siblings("#hiddenPrice").val());
            if (count >= 1) {
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                $(this).siblings("#price").text((parseFloat(price) - hidPrice).toFixed(2));
            }
            return false;
        });
        $('.plus').live("click", function () {
            var $input = $(this).parent().find('#quantity');
            var price = $(this).siblings("#price").text();
            var hidPrice = parseFloat($(this).siblings("#hiddenPrice").val());
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            $(this).siblings("#price").text((parseFloat(price) + hidPrice).toFixed(2));
            return false;
        });
        $("#quantity").live("change", function () {
            var input = parseInt($(this).val());
            var price = $(this).siblings("#price").text();
            var hidPrice = parseFloat($(this).siblings("#hiddenPrice").val());
            $(this).siblings("#price").text((input * hidPrice).toFixed(2));
        });
        $("#more").live("click", function () {
            if ($(this).siblings("#info").is(':hidden')) {
                $(this).html('Приховати деталі <?php echo TbHtml::icon(TbHtml:: ICON_CHEVRON_UP)?>');
            } else {
                $(this).html('Показати деталі <?php echo TbHtml::icon(TbHtml:: ICON_CHEVRON_DOWN)?>');
            }
            $(this).siblings("#info").fadeToggle("slow");
        })
    });

    function CountdownTimer(elm, tl, mes) {
        this.initialize.apply(this, arguments);
    }
    CountdownTimer.prototype = {
        initialize: function (elm, tl, mes) {
            this.elem = document.getElementById(elm);
            this.tl = tl;
            this.mes = mes;
        }, countDown: function () {
            var timer = '';
            var today = new Date();
            var day = Math.floor((this.tl - today) / (24 * 60 * 60 * 1000));
            var hour = Math.floor(((this.tl - today) % (24 * 60 * 60 * 1000)) / (60 * 60 * 1000));
            var min = Math.floor(((this.tl - today) % (24 * 60 * 60 * 1000)) / (60 * 1000)) % 60;
            var sec = Math.floor(((this.tl - today) % (24 * 60 * 60 * 1000)) / 1000) % 60 % 60;
            var me = this;

            if (( this.tl - today ) > 0) {
//				timer += '<span class="number-wrapper"><div class="line"></div><div class="caption">DAYS</div><span class="number day">'+day+'</span></span>';
                timer += '<span class="number-wrapper"><div class="line"></div><div class="caption">год</div><span class="number hour">' + hour + '</span></span>';
                timer += '<span class="number-wrapper"><div class="line"></div><div class="caption">хв</div><span class="number min">' + this.addZero(min) + '</span></span><span class="number-wrapper"><div class="line"></div><div class="caption">сек</div><span class="number sec">' + this.addZero(sec) + '</span></span>';
                this.elem.innerHTML = timer;
                tid = setTimeout(function () {
                    me.countDown();
                }, 10);
            } else {
                this.elem.innerHTML = this.mes;
                return;
            }
        }, addZero: function (num) {
            return ('0' + num).slice(-2);
        }
    }
    function CDT() {

        // Set countdown limit

        var tl = new Date('<?php echo date('Y/m/d', $date) . ' ' . date('H:i:s', strtotime($data_worked['date']))?>');

        // You can add time's up message here
        var timer = new CountdownTimer('CDT', tl, '<span class="number-wrapper"><span class="number end">Робочий день закінчився!</span></span>');
        timer.countDown();
    }
    window.onload = function () {
        CDT();
    }
</script>

