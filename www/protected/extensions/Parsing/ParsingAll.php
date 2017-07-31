<?php

/**
 * Created by PhpStorm.
 * User: Roma
 * Date: 04.11.2016
 * Time: 20:37
 */
class ParsingAll
{
    public function ParserMartext($parsing_result, $parsed_site1, $exchange_rates)
    {
        $div = phpQuery::newDocument($parsing_result);
        if (empty($div)) {
            $martex_work = 0;
        }
        $get_results = $div->find('.partscontrol-group');
        if (isset($get_results)) {
            foreach ($get_results as $result) {
                $pq = pq($result);
                $count = count($pq->find('.partscontrol-box'));
                if ($count > 1) {
                    $pq = pq($pq);
                    $photo = $pq->find('.partscontrol-box-img')->eq(1)->attr('data-img');
                    $results['photo'] = 'http://sklep.martextruck.pl/' . $photo . '">';
                    if (!empty($results['photo']))
                        $status = true;
                    $manufacturer = $pq->find('.partscontrol-group-head-text')->text();
                    $results['manufacturer'] = $manufacturer;
                    $name = $pq->find('.partscontrol-box-info-name')->eq(1);
                    $name->find('.promotion_info')->remove();
                    $name->find('.sale_info')->remove();
                    $name->find('.news_info')->remove();
                    $results['name'] = $name->text();;
                    $price = $pq->find('.partscontrol-box-articles-price-net')->eq(1)->text();
                    if (!$name || !$price) {
                        $martex_work = 0;
                        continue;
                    }
                    $price = str_replace('PLN', '', $price);
                    $price = str_replace(',', '.', $price);
                    $price = trim($price);
                    $def_price = (double)$price;
                    $results['def_price'] = $def_price;
                    if (Yii::app()->session['session_info'] == 1) {
                        $price = round(((double)$price) * $parsed_site1->logistic * ($exchange_rates->zloty), 0);
                        $admin_price = ($price * $parsed_site1->admin_coef) - $price;
                        $curator_price = ($price * $parsed_site1->curator_coef) - $price;
                        $manager_price = ($price * $parsed_site1->manager_coef) - $price;
                        $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                    } else {
                        $price = round(((double)$price) * $parsed_site1->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                        $admin_price = ($price * $parsed_site1->admin_coef) - $price;
                        $curator_price = ($price * $parsed_site1->curator_coef) - $price;
                        $manager_price = ($price * $parsed_site1->manager_coef) - $price;
                        $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                    };
                    $results['price'] = round($price, 0);
                    $number = $pq->find('.partscontrol-box-articles-articleid')->eq(1)->text();
                    $results['number'] = $number;
                    $results['details'] = $pq->find('a')->eq(1)->attr('href');
                    $results_2[] = $results;
                }
                $photo = $pq->find('.partscontrol-box-img')->attr('data-img');
                $results['photo'] = 'http://sklep.martextruck.pl/' . $photo . '">';
                if (!empty($results['photo']))
                    $status = true;
                $manufacturer = $pq->find('.partscontrol-group-head-text')->text();
                $results['manufacturer'] = $manufacturer;
                $name = $pq->find('.partscontrol-box-info-name')->eq(0);
                $name->find('.promotion_info')->remove();
                $name->find('.sale_info')->remove();
                $name->find('.news_info')->remove();
                $results['name'] = $name->text();
                $price = $pq->find('.partscontrol-box-articles-price-net')->text();
                if (empty($name) || empty($price)) {
                    $martex_work = 0;
                    continue;
                } else {
                    $martex_work = 1;
                }
                $price = str_replace('PLN', '', $price);
                $price = str_replace(',', '.', $price);
                $price = trim($price);
                $def_price = (double)$price;
                $results['def_price'] = $def_price;
                if (Yii::app()->session['session_info'] == 1) {
                    $price = round(((double)$price) * $parsed_site1->logistic * ($exchange_rates->zloty), 0);
                    $admin_price = ($price * $parsed_site1->admin_coef) - $price;
                    $curator_price = ($price * $parsed_site1->curator_coef) - $price;
                    $manager_price = ($price * $parsed_site1->manager_coef) - $price;
                    $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                } else {
                    $price = round(((double)$price) * $parsed_site1->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                    $admin_price = ($price * $parsed_site1->admin_coef) - $price;
                    $curator_price = ($price * $parsed_site1->curator_coef) - $price;
                    $manager_price = ($price * $parsed_site1->manager_coef) - $price;
                    $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                };
                $results['price'] = round($price, 0);
                $number = $pq->find('.partscontrol-box-articles-articleid')->text();
                $results['number'] = $number;
                $results['details'] = $pq->find('a')->attr('href');
                $results['martex_work'] = $martex_work;
                $results_2[] = $results;
                unset($results);
            }
        }
        return $results_2 ?: false;
    }

    /**
     * @param $parsing_result
     * @param $parsed_site5
     * @param $exchange_rates
     * @return array
     */
    public function ParsingDiesel($parsing_result, $parsed_site5, $exchange_rates)
    {
        $diesel_work = 1;
        $div = phpQuery::newDocument($parsing_result);
        $results_items = $div->find('.int-thumb-wrapper');
        foreach ($results_items as $items) {
            $items = pq($items);
            $results['name'] = $items->find('h2.int-margin-top-clear')->text();
            $results['details'] = 'http://www.diesel-czesci.pl' . $items->find('h2.int-margin-top-clear')->find('a')->attr('href');
            $photo = $items->find('.int-position-relative')->find('img')->attr('src');
            if ($photo != '/lib/dieselczesci/img/avl-high.png?v4') {
                $results['photo'] = 'http://www.diesel-czesci.pl' . $items->find('.int-position-relative')->find('img')->attr('src');
            } else {
                $results['photo'] = 'http://sklep.martextruck.pl/Handlers/ArticleImage.ashx?id=no-image&size=1';
            }
            $price = $items->find('.int-thumb-desc-price')->find('span')->eq(3)->text();
            $price = html_entity_decode($price);
            $price = explode(',', $price);
            $price = $price[0];
            $price = htmlentities($price);
            $price = str_replace('&nbsp;', '', $price);
            $results['def_price'] = $price;
            if (Yii::app()->session['session_info'] == 1) {
                $price = round(($price) * $parsed_site5->logistic * ($exchange_rates->zloty), 0);
                $admin_price = ($price * $parsed_site5->admin_coef) - $price;
                $curator_price = ($price * $parsed_site5->curator_coef) - $price;
                $manager_price = ($price * $parsed_site5->manager_coef) - $price;
                $price = round($admin_price + $curator_price + $manager_price + $price, 0);
            } else {
                $price = round(($price) * $parsed_site5->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                $admin_price = ($price * $parsed_site5->admin_coef) - $price;
                $curator_price = ($price * $parsed_site5->curator_coef) - $price;
                $manager_price = ($price * $parsed_site5->manager_coef) - $price;
                $price = round($admin_price + $parsed_site5 + $manager_price + $price, 0);
            };
            $results['price'] = round($price, 0);
            $aviliability = $items->find('span.on-photo-wrapper.avail-wrap:last')->find('img')->attr('title');
            ($aviliability == 'Niedostępny') ? $aviliability = 0 : $aviliability = 'Так';
            $results['diesel_work'] = $diesel_work;
            $results['aviliability'] = $aviliability;
            $results_2[] = $results;
            unset($results);
        }
        return $results_2;
    }

    public function ParsingOpol($parsing_result, $get_html_martex, $query)
    {

        if (!empty($parsing_result)) {
            foreach ($parsing_result as $items) {
                $pos1 = stripos($items, '<script id');
                $pos2 = stripos($items, '</div></script>') + 15;
                $items = str_replace(substr($items, $pos1, $pos2 - $pos1), '', $items);
                $html = phpQuery::newDocument($items);
                $products_dom = $html->find('.prod-display-container');
                ($products_dom) ? $opol_work = 1 : $opol_work = 1;
                if (count($products_dom))
                    foreach ($html->find('.prod-display-container')->eq(2)->find('.product-container') as $product) {
                        $product = pq($product);
                        $count = $product->find('.product-storehouses-all a')->attr('href');
                        $count = 'http://webcatalog.opoltrans.com.pl' . $count;
                        $result_3 = $get_html_martex->get_html_opol($count);
                        $pos1 = stripos($result_3[content], '<script id');
                        $pos2 = stripos($result_3[content], '</div></script>') + 15;
                        $result_3[content] = str_replace(substr($result_3[content], $pos1, $pos2 - $pos1), '', $result_3[content]);
                        $count = phpQuery::newDocument($result_3[content]);
                        foreach ($count->find('tr') as $value) {
                            $value = pq($value);
                            if (trim($value->find('td')->eq(0)->text()) == '201M0M') {
                                $availability = $value->find('td')->eq(3)->text();
                                $availability = str_replace('\n', '', $availability);
                                $availability = str_replace('>', '', $availability);
                                $availability = trim($availability);
                                $availability = (int)$availability;
                            }
                            if (trim($value->find('td')->eq(0)->text()) == '214M0M') {
                                $rzeshow = $value->find('td')->eq(3)->text();
                                $rzeshow = str_replace('\n', '', $rzeshow);
                                $rzeshow = str_replace('>', '', $rzeshow);
                                $rzeshow = trim($rzeshow);
                                $rzeshow = (int)$rzeshow;
                            }
                        }
                        $product_symbol = $product->find('a.product-symbol', 0);
                        $data['product-symbol'] = $product_symbol->text();
                        $data['product-url'] = $product_symbol->attr('href');
                        foreach ($product->find('.product-symbol-name-container .product-symbol-ref') as $el) {
                            $el = pq($el);
                        }
                        $data['data_zaminniki']['product-symbol'] = $data['product-symbol'];
                        $data['data_zaminniki']['phrase'] = $query;
                        $data['product-name'] = $product->find('.product-name', 0)->text() . ' - ' . $data['product-symbol-ref'][] = str_replace(array('(', ')'), '', $el->text());
                        $data['price'] = trim(str_replace('PLN', '', str_replace(',', '', $product->find('.product-price-container', 0)->find('.product-price-p', 0)->text())));
                        $data['price_nds'] = trim(str_replace('PLN', '', $product->find('.product-price-container', 0)->find('.product-price-p-vat', 0)->text()));
                        $data['product-state'] = $product->find('.product-state-container img', 0)->attr('title');
                        $data['availability'] = $availability;
                        $data['rzeshow'] = $rzeshow;
                        $data['product-producer-name'] = $product->find('.product-producer-name .product-symbol-ref', 0)->text();
                        $photo = $product->find('.product-photo-container', 0)->find('img', 0)->attr('src');
                        if ($photo == '/assets/plat/product/photo_no.jpg') $photo = null;
                        $data['photo'] = $photo;
                        $data['info'] = '';
                        $data['opol_work'] = $opol_work;
                        $products[] = $data;
                        unset($data);
                    }
            }
        }
        return $products;
    }

    /**
     * @param $result
     * @param $opol_login
     * @param $opol_password
     * @param $get_html
     * @param $parsed_site2
     * @param $exchange_rates
     * @param $data_calendar_centr
     * @param $data_calendar_filia
     * @return array
     */
    public function OpolInfo($result, $opol_login, $opol_password, $get_html, $parsed_site2, $exchange_rates, $data_calendar_centr, $data_calendar_filia)
    {
        $div = phpQuery::newDocument($result);
        if (!is_object($div)) {
            echo "problem is_object - 1";
            exit;
        }
        if (count($div->find('.new_suser')))
            $html = login($div, $opol_login, $opol_password);

        $dataproductlink = 'http://webcatalog.opoltrans.com.pl' . $_GET['result_info'];
        $result_3 = $get_html->get_html_opol($dataproductlink);
        $pos1 = stripos($result_3['product-link']['content'], '<script id');
        $pos2 = stripos($result_3['product-link']['content'], '</div></script>') + 15;
        $result_3['content'] = str_replace(substr($result_3['content'], $pos1, $pos2 - $pos1), '', $result_3['content']);
        $html_3 = phpQuery::newDocument($result_3[content]);
        $data_3 = array();
        $count = $html_3->find('.product-storehouses-all a')->attr('href');
        $count = 'http://webcatalog.opoltrans.com.pl' . $count;
        $result_3 = $get_html->get_html_opol($count);
        $pos1 = stripos($result_3[content], '<script id');
        $pos2 = stripos($result_3[content], '</div></script>') + 15;
        $result_3[content] = str_replace(substr($result_3[content], $pos1, $pos2 - $pos1), '', $result_3[content]);
        $count = phpQuery::newDocument($result_3[content]);

        foreach ($count->find('tr') as $value) {
            $value = pq($value);
            if (trim($value->find('td')->eq(0)->text()) == '201M0M') {
                $availability = $value->find('td')->eq(3)->text();
                $availability_or = str_replace('\n', '', $availability);
            }
            if (trim($value->find('td')->eq(0)->text()) == '214M0M') {
                $rzeshow_or = $value->find('td')->eq(3)->text();
                $rzeshow_or = str_replace('\n', '', $rzeshow_or);
            }
        }
        foreach ($html_3->find('.col-page-l .header-half-page') as $value) {


            $value = pq($value);
            $name = trim($value->find('.sp-inline', 0)->text());
           if (count($value->next()->find('.list-all'))) {
                foreach ($value->next()->find('.list-all') as $val) {
                    $val = pq($val);
                    foreach ($val->find('li') as $punkt) {
                        $punkt = pq($punkt);
                        if (trim($punkt->find('span.sp-inline')->eq(1)))
                            $data_3[$name][trim($punkt->find('span.sp-inline', 0)->text())][] = trim($punkt->find('span.sp-inline')->eq(1)->text());
                        else
                            $data_3[$name][] = trim($punkt->find('span.sp-inline', 0)->text());
                    }
                }
            } elseif (count($value->next()->find('.list-using li.product-using-mark'))) {
                foreach ($value->next()->find('.list-using li.product-using-mark') as $val) {
                    $val = pq($val);
                    $li = $val->find('span', 0)->text();
                    foreach ($val->next()->find('li.product-using-model') as $v) {
                        $v = pq($v);
                        $name_li = $v->find('span.sp-inline', 0)->text();
                        foreach ($val->next()->find('li.product-using-type') as $model) {
                            $model = pq($model);
				//TODO: FIX it
                            //$data_3[$name][$li][$name_li][$model->find('span.sp-inline', 0)->text()] = $model->find('span.sp-inline', 1)->text();
                        }
                    }
                }
            }
        }
        $data['detail_product'] = $data_3;
        if (isset($data['detail_product']['Kryteria'])) {
            $table_1 = '';
            foreach ($data['detail_product']['Kryteria'] as $items => $key) {
                $table_1 .= $items;
            }
            $data['table_1'] = $table_1;
        }
        if (isset($data['detail_product']['Numery OEM'])) {
            $table_2 = '<table id="replacementgrid" class="dgrid" width="100%">';
            foreach ($data['detail_product']['Numery OEM'] as $items => $key) {
                $table_2 .= '<tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">';
                $table_2 .= '<td>' . $items . '</td>';
            }
            $table_2 .= '</table>';
            $data['table_2'] = $table_2;
        }
        if (isset($data['detail_product']['Zastosowanie'])) {
            $table_3 = '<table id="replacementgrid" class="dgrid" width="100%">';

            foreach ($data['detail_product']['Zastosowanie'] as $items => $key) {
                $table_3 .= '<tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">';
                $table_3 .= '<td>' . $items . '</td>';
            }
            $table_3 .= '</table>';
        }
        if (isset($data['detail_product']['Własne symbole oryginałów'])) {
            $table_7 = '<table id="replacementgrid" class="dgrid" width="100%">';

            foreach ($data['detail_product']['Własne symbole oryginałów'] as $items => $key) {

                $table_7 .= '<tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">';
                $table_7 .= '<td>' . $key . '</td>';
            }
            $table_7 .= '</table>';
        }

        $table_6 = '<table id="replacementgrid" class="dgrid" width="100%">';
        $table_6 .= '<tr class="dgridhead"><td></td>
									<td class="header-code"><span id=" Код товару  "> Код товару  </span>
									</td><td class="header-name">
									<span id=" Назва товару  "> Назва товару  </span>
									</td><td class="header-pricenet">
									<span id=" Ціна,грн "> Ціна,грн </span>
									</td></tr>';
        if (!empty($products)) {
            foreach ($products as $product) {
                if (Yii::app()->session['session_info'] == 1) {
                    $price = round(((double)$product['price']) * $parsed_site2->logistic * ($exchange_rates->zloty), 0);
                    $admin_price = ($price * $parsed_site2->admin_coef) - $price;
                    $curator_price = ($price * $parsed_site2->curator_coef) - $price;
                    $manager_price = ($price * $parsed_site2->manager_coef) - $price;
                    $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                } else {

                    $price = round(((double)$product['price']) * $parsed_site2->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                    $admin_price = ($price * $parsed_site2->admin_coef) - $price;
                    $curator_price = ($price * $parsed_site2->curator_coef) - $price;
                    $manager_price = ($price * $parsed_site2->manager_coef) - $price;
                    $price = round($admin_price + $curator_price + $manager_price + $price, 0);

                };
                $table_6 .= '<tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">';
                $table_6 .= '<td class="title-image-url"><img id="ctl00_articlerepeater_ctl01_Image1" width="100" src="' . ((isset($product['photo']) && $product['photo'] != 'http://tdfoto.flkat24.pl:40000/-1') ? $product['photo'] : 'http://sklep.martextruck.pl/Handlers/ArticleImage.ashx?id=no-image&size=1') . '"></td>';
                $table_6 .= '<td class="code"><a href="' . Yii::app()->controller->createUrl("info", array("result_info" => $product['product-url'], "site" => 'http://webcatalog.opoltrans.com.pl/', "photo" => $product['photo'], 'price' => $price, 'def_price' => $product['price'], 'name' => $product['product-name'], 'manufacturer' => $product['product-producer-name'], 'cod' => $product['product-symbol'], 'state' => $product['product-state'], 'info' => $product['info'])) . '">' . $product['product-symbol-ref'][0] . '</a></td>';
                $table_6 .= '<td class="name">' . $product['product-name'] . '</td>';
                $table_6 .= '<td id="ctl00_articlerepeater_ctl01_articlerepeatercontrol_price_tdNetPrice" class="pricenet" nowrap="">' . $price . '</td>';
                $table_6 .= '</tr>';
            }
        }
        $table_6 .= '</table>';
        $opol_info = array(
            'table_1' => $table_1,
            'table_2' => $table_2,
            'table_3' => $table_3,
            'table_6' => $table_6,
            'table_7' => $table_7,
            'item_info' => array(
                'price_one' => round($_GET['price'], 0),
                'def_price' => $_GET['def_price'],
                'provider' => $_GET['site'],
                'cod' => $_GET['cod'],
            ),
            'item' => array(
                array(
                    'name' => $_GET['name'],
                    'photo' => $_GET['photo'],
                    'manufacturer' => $_GET['manufacturer'],
                    'price' => $_GET['price'],
                    'stock' => $availability_or . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_centr)) . ' )',
                    'stock_2' => $rzeshow_or . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_filia)) . ' )',
                )
            ),
        );
        return $opol_info;
    }

    public function MartexInfo($res_1, $parsed_site1, $exchange_rates, $data_calendar_centr, $data_calendar_filia)
    {

        $div = phpQuery::newDocument($res_1);
        $prom_name = $div->find('#main_head_container');
        $prom_cod = $div->find('.ofpCode');
        $prom_price = $div->find('.ofpClientNetPrice');
        $prom_photo = $div->find('.partimglarge');
        $prom_manufactured = $div->find('.ofpProducerName')->text();
        $prom_photo = pq($prom_photo);
        $prom_photo = $prom_photo->text();
        $prom_photo = str_replace('_imgItem = ["/', '', $prom_photo);
        $change = '"';
        $change_2 = stripos($prom_photo, $change);
        $change_3 = substr($prom_photo, $change_2);
        $prom_photo = str_replace($change_3, '', $prom_photo);
        $prom_photo_2 = $div->find('.partimgthumbs');
        $prom_photo_2 = $prom_photo_2->find('a')->eq(1)->attr('href');
        if ($prom_photo == '') {
            $prom_photo = 'http://sklep.martextruck.pl/Handlers/ArticleImage.ashx?id=no-image';
        } else {
            $prom_photo = 'http://sklep.martextruck.pl/' . trim($prom_photo);
        }
        if ($prom_photo_2 !== '') {

            $prom_photo_2 = 'http://http://sklep.martextruck.pl/' . trim($prom_photo_2);
        }

        $prom_prices = $prom_price->text();
        $prom_price = str_replace('PLN', '', $prom_prices);
        $prom_price = str_replace(',', '.', $prom_price);
        $prom_price = trim($prom_price);
        $prom_price = (double)$prom_price;
        if (Yii::app()->session['session_info'] == 1) {
            $price = round(($prom_price) * $parsed_site1->logistic * ($exchange_rates->zloty), 0);
            $admin_price = ($price * $parsed_site1->admin_coef) - $price;
            $curator_price = ($price * $parsed_site1->curator_coef) - $price;
            $manager_price = ($price * $parsed_site1->manager_coef) - $price;
            $prom_prices_2 = round($admin_price + $curator_price + $manager_price + $price, 0);
        } else {
            $price = round(($prom_price) * $parsed_site1->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
            $admin_price = ($price * $parsed_site1->admin_coef) - $price;
            $curator_price = ($price * $parsed_site1->curator_coef) - $price;
            $manager_price = ($price * $parsed_site1->manager_coef) - $price;
            $prom_prices_2 = round($admin_price + $curator_price + $manager_price + $price, 0);
        };

        $availability_result = $div->find('div.artquant')->find('select');
        $availability = $availability_result->find('option')->eq(1);
        $rzeshow = $availability_result->find('option')->eq(15);
        $availability = str_replace('Centrala:', '', $availability);
        $rzeshow = str_replace('filia Rzeszów:', '', $rzeshow);

        $cod = $div->find('#partscatalogoue_article_tab');
        $table_1 = $cod->find('#pcp_1');
        $table_1 = str_replace('Ciężar [kg]', 'Вага(кг)', $table_1);
        $table_1 = str_replace('Wymagana ilość', 'Мінімальна кількість', $table_1);
        $table_1 = str_replace('Kod EAN', 'Код EAN', $table_1);

        $table_2 = $cod->find('#pcp_7', 0);
        $table_2 = str_replace('Producent', 'Виробник  ', $table_2);
        $table_2 = str_replace('Kod towaru', 'Код товару', $table_2);

        $table_3 = $cod->find('#ctl00_pagecontext_partdetailcontrol1_partownedcontrol1_PanelOwnedPart');
        $table_3 = str_replace('Kod zestawu', 'Код набору', $table_3);
        $table_3 = str_replace('Nazwa zestawu', 'Назва набору', $table_3);
        $table_3 = strip_tags($table_3, '<table><td><tr><tbody>');

        $tec_doc = $cod->find('a')->eq(2);
        $tec_doc_2 = $tec_doc->attr("href");


        $detail = 'http://http://sklep.martextruck.pl' . $tec_doc_2;
        $get_html_martex_2 = new  CurlAll();
        $res_1 = $get_html_martex_2->get_html_martex_2($detail);
        $table_4 = phpQuery::newDocument($res_1);
        $error = $table_4->find('a')->attr("href");
        if (!empty($error)) {
            $table_4 = "   ";
        } else {
            $table_4 = str_replace('Producent', 'Виробник', $table_4);
            $table_4 = str_replace('Kod OE', 'КОД ОЕ', $table_4);
        }
        $transport = $cod->find('a')->eq(4);
        $transport_2 = $transport->attr("href");
        $detail = 'http://http://sklep.martextruck.pl' . $transport_2;
        $get_html_martex_2 = new  CurlAll();
        $res_1 = $get_html_martex_2->get_html_martex_2($detail);

        $table_5 = phpQuery::newDocument($res_1);
        $str = "Wyszukiwarka";
        $error = strripos($table_5, $str);
        if (empty($error)) {
            $table_5 = str_replace('Marka', 'Марка', $table_5);
            $table_5 = str_replace('Model', 'Модель', $table_5);
            $table_5 = str_replace('Typ', 'Тип', $table_5);
            $table_5 = str_replace('Pojemność silnika [ccm]', 'Обєм двигуна(см)', $table_5);
            $table_5 = str_replace('Rok produkcji', 'Рік випуску', $table_5);
            $table_5 = strip_tags($table_5, '<table><tbody><td><tr>');
            $table_5 = str_replace('//', '', $table_5);

        } else {
            $table_5 = "  ";
        }

        $substitute = $cod->find('a')->eq(1);
        $substitute_2 = $substitute->attr("href");
        $detail = 'http://http://sklep.martextruck.pl' . $substitute_2;
        $get_html_martex_2 = new  CurlAll();
        $res_1 = $get_html_martex_2->get_html_martex_2($detail);
        $table_6 = phpQuery::newDocument($res_1);
        $table_6 = $table_6->find('.dgrid');
        $delete = $table_6->find('.header-pricegross')->remove();
        foreach ($table_6 as $el) {
            $pq = pq($el);
            $photo = $pq->find('img');
            foreach ($photo as $photos) {
                $photos = pq($photos);
                $photos->parents('a')->attr('href', 'javascript:;');
                $photos = $photos->attr('src', 'http://http://sklep.martextruck.pl/' . $photos->attr('src'));
            }

            $price = $pq->find('.pricenet');

            foreach ($price as $prices) {
                $prices = pq($prices);
                $pricess = $prices->text();
                $price = str_replace('PLN', '', $pricess);
                $price = str_replace(',', '.', $price);
                $price = trim($price);

                if (Yii::app()->session['session_info'] == 1) {
                    $price = round(($price) * $parsed_site1->logistic * ($exchange_rates->zloty), 0);
                    $admin_price = ($price * $parsed_site1->admin_coef) - $price;
                    $curator_price = ($price * $parsed_site1->curator_coef) - $price;
                    $manager_price = ($price * $parsed_site1->manager_coef) - $price;
                    $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                } else {

                    $price = round(($price) * $parsed_site1->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                    $admin_price = ($price * $parsed_site1->admin_coef) - $price;
                    $curator_price = ($price * $parsed_site1->curator_coef) - $price;
                    $manager_price = ($price * $parsed_site1->manager_coef) - $price;
                    $price = round($admin_price + $curator_price + $manager_price + $price, 0);

                };
                $prices = $prices->text($price);
            }
            $price_3 = $pq->find('.pricegross');

            foreach ($price_3 as $prices) {
                $prices = pq($prices);
                $pricess = $prices->remove();

            }
            $name = $pq->find('.code');
            foreach ($name as $names) {
                $names = pq($names);
                $names_2 = $names->find('a')->attr('href');
                $names_3 = $names->find('a')->attr('href', Yii::app()->controller->createUrl("info", array("result_info" => $names_2, "site" => 'http://http://sklep.martextruck.pl/')));
            }
        }
        $table_6 = str_replace('Kod towaru', ' Код товару&nbsp; ', $table_6);
        $table_6 = str_replace('Nazwa towaru', ' Назва товару&nbsp; ', $table_6);
        $table_6 = str_replace('Cena netto', ' Ціна,грн&nbsp;', $table_6);
        $table_6 = str_replace('Centrala', ' Відділення&nbsp;&nbsp; ', $table_6);
        $table_6 = str_replace('Oddziały', ' Центральний &nbsp;&nbsp;офіс&nbsp;&nbsp; ', $table_6);

        $name = $prom_name;
        $photo = $prom_photo;
        $photo_2 = $prom_photo_2;
        $manufacturer = $prom_manufactured;
        $price = $prom_prices_2;
        $martex_info = array(
            'table_1' => $table_1,
            'table_2' => $table_2,
            'table_3' => $table_3,
            'table_6' => $table_6,
            'item_info' => array(
                'price_one' => round($price, 0),
                'def_price' => $prom_price,
                'provider' => $_GET['site'],
                'cod' => trim($prom_cod->text())
            ),
            'item' => array(
                array(
                    'name' => $name,
                    'photo' => $photo,
                    'photo_2' => $photo_2,
                    'manufacturer' => $manufacturer,
                    'price' => $price,
                    'stock' => $availability . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_centr)) . ' )',
                    'stock_2' => $rzeshow . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_filia)) . ' )',
                )
            ),
        );
        return $martex_info;
    }

    public function DieselInfo($res_1, $parsed_site1, $exchange_rates, $data_calendar_centr, $data_calendar_filia)
    {
        $div = phpQuery::newDocument($res_1);
        $info = $div->find('.product-data-wrapper');
        $aviliability = 'Так';
        $table_1 = $div->find('.tab-content')->text();
        $cod = $info->find('.row-fluid')->eq(2)->find('.span7')->text();
        $table_1 = strip_tags($table_1);
        $table_1 = str_replace(' ', '', $table_1);
        $table_1 = str_replace('Potrzebujeszwięcejinformacji?Nieznalazłeśczęścijakich
szukasz?Skontaktujsięznamitel:+48426831338,e-mail:e-sklep@diesel-czesci.pl----Needmore
information?Youdidnotfindwhatyouarelookingforparts?Contactustel:
+48426831338,e-mail:e-sklep@diesel-czesci.pl', '', $table_1);
        $name = $_GET['name'];
        $photo = $_GET['photo'];
        $price = $_GET['price'];
        $diesel_info = array(
            'table_1' => $table_1,
            'item_info' => array(
                'price_one' => round($price, 0),
                'def_price' => $_GET['def_price'],
                'provider' => $_GET['site'],
                'cod' => trim($cod)
            ),
            'item' => array(
                array(
                    'name' => $name,
                    'photo' => $photo,
                    'price' => $price,
                    'stock' => $aviliability . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_centr)) . ' )',
                )
            ),
        );
        return $diesel_info;
    }

    public function getAutosToken($href_1)
    {
        $result = phpQuery::newDocument($href_1);
        $salt = $result->find('table#table_login')->find('table')->find('tr')->eq(0)->find('input')->eq(0)->attr('value');
        $number = $result->find('table#table_login')->find('table')->find('tr')->eq(0)->find('input')->eq(1)->attr('name');
        $number_value = $result->find('table#table_login')->find('table')->find('tr')->eq(0)->find('input')->eq(1)->attr('value');
        return $arr = array(
            'salt' => $salt,
            'number' => $number,
            'number_value' => $number_value
        );
    }

    /**
     * @param $href_3
     * @param $parsed_site6
     * @param $exchange_rates
     * @return bool
     */
    public function ParserAutos($result, $parsed_site6, $exchange_rates)
    {
        $result_2 = phpQuery::newDocument($result);
        $table = $result_2->find('table.table_border')->find('table#table_bsk_list');
        $remove = $table->find('tr.bg_gray')->eq(0)->remove();
        $remove = $table->find('tr.bg_gray')->eq(0)->remove();
        $remove_2 = $table->find('tr')->eq(1)->remove();
        $remove_2 = $table->find('tr')->eq(0)->remove();

        $table = $table->find('tr');
        foreach ($table as $items) {
            $items = pq($items);
            //trim($items->find('td')->eq(3)->text()) !== 'brak' &&
            if ((trim($items->find('td')->eq(3)->text()))) {
                $data['manufacturer'] = $items->find('td')->eq(2)->find('span.span_tow_prod')->find('i')->text();
                $data['cod'] = trim($items->find('td')->eq(1)->text());
                $array = $items->find('td')->eq(0)->find('a')->attr('href');
                if ($array) {
                    $array = explode(',', $array);
                    $href = 'https://sklep.autos.com.pl/' . str_replace('\'', '', $array[1]);
                    $curl = new CurlAll();
                    $href_4 = $curl->curl_token($href);
                    $result_3 = phpQuery::newDocument($href_4);
                    $infocontent = $result_3->find('tr.bg_white')->eq(0)->find('td');
                    $content = $infocontent->find('div');
                    $price_zln = trim($result_3->find('td.td_add_cena')->eq(0)->text());
                    $price_zln = str_replace(',','.',$price_zln);
                    if ($price_zln != '0') {

                        $data['def_price'] = $price_zln;
                        $data['info'] = $content->find('b')->eq(0)->text();
                        $data['comentar'] = $content->find('b')->eq(1)->text();
                        $data['photo'] = '/' . Yii::getPathOfAlias('photos') . '/Nophoto.jpg';
                        if (Yii::app()->session['session_info'] == 1) {
                            $price = round(($price_zln) * $parsed_site6->logistic * ($exchange_rates->zloty), 0);
                            $admin_price = ($price * $parsed_site6->admin_coef) - $price;
                            $curator_price = ($price * $parsed_site6->curator_coef) - $price;
                            $manager_price = ($price * $parsed_site6->manager_coef) - $price;
                            $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                        } else {
                            $price = round(($price_zln) * $parsed_site6->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                            $admin_price = ($price * $parsed_site6->admin_coef) - $price;
                            $curator_price = ($price * $parsed_site6->curator_coef) - $price;
                            $manager_price = ($price * $parsed_site6->manager_coef) - $price;
                            $price = round($admin_price + $curator_price + $manager_price + $price, 0);
                        };
                        $data['price_one'] = $price;
                        $hrefs = $result_3->find('.header_top');
                        //коди ОЕ
                        $oe = $hrefs->find('li')->eq(1)->find('a')->attr('href');
                        $href_5 = $curl->curl_token('https://sklep.autos.com.pl/' . $oe);
                        $result_5 = phpQuery::newDocument($href_5);
                        $table_4 = $result_5->find('table.bg_brown');
                        $data['codOE1'] = $table_4->find('tr')->eq(0)->find('td.bg_white')->text();
                        $data['codOE2'] = $table_4->find('tr')->eq(1)->find('td.bg_white')->text();
                        $data['name'] = $infocontent->find('span')->text() . ' ' . $table_4->find('tr')->eq(0)->find('td.bg_white')->text() . ' ' . $table_4->find('tr')->eq(1)->find('td.bg_white')->text();
//              Кінець кодів ОЕ
                        $qw = $hrefs->find('li')->eq(4)->find('a')->attr('href');
                        $href_6 = $curl->curl_token('https://sklep.autos.com.pl/' . $qw);
                        $result_6 = phpQuery::newDocument($href_6);
                        $table_5 = $result_6->find('table.bg_brown');
                        foreach ($table_5->find('tr') as $values) {
                            $values = pq($values);
                            if (trim($values->find('td')->eq('0')->text()) == 'CENTRALA') {
                                $centr = $values->find('td')->eq('2')->text();
                                if (trim($centr) == '*') {
                                    $data['rzeszow'] = 5;
                                } elseif (trim($centr) == '**') {
                                    $data['rzeszow'] = 10;
                                } elseif (trim($centr) == '***') {
                                    $data['rzeszow'] = '<10';
                                } else  $data['rzeszow'] = $centr;

                            } elseif (trim($values->find('td')->eq('0')->text()) == 'RZESZÓW') {
                                $rzeszow = $values->find('td')->eq('2')->text();
                                if (trim($rzeszow) == '*') {
                                    $data['center'] = 5;
                                } elseif (trim($rzeszow) == '**') {
                                    $data['center'] = 10;
                                } elseif (trim($rzeszow) == '***') {
                                    $data['center'] = '<10';
                                } else  $data['center'] = $rzeszow;
                            }
                        }

                    }
                    else continue;
                }
            } else {
                continue;
            }
            $products[] = $data;

            unset($data);
        }

        return $products;
    }
}
