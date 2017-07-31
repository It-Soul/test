<?php

class SiteController extends Controller

{
    public $layout = '//admin/layouts/main';
    public $defaultAction = 'login';

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('error', 'login', 'logout'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('admin', 'login', 'index', 'create', 'update', 'error', 'info', 'logout', 'add'),
                'users' => array('@'),
                'roles' => array('administrator')
            ),
            array('deny',
                'actions' => array(),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        include('protected/vendors/phpQuery/phpQuery/phpQuery.php');
        $model_2 = new Results_admin('search');
        $model_2->unsetAttributes();  // clear any default values
        $martex_work = 1;
        $opol_work = 1;
        $intercars_work = 1;
        $skuba_work = 1;
        $siteinfo = Infosite::model()->findAll();
        if (isset ($_GET['Users']['id'])) {
            Yii::app()->session['user'] = $_GET['Users']['id'];
        } else {
            Yii::app()->session['user'] = Yii::app()->user->id;
        }
        if (isset($_GET['Results__admin']))
            $model_2->attributes = $_GET['Results_admin'];

        if (isset(Yii::app()->session['user'])) {

            $arrears = (Orders::model()->getUserSum_2(Yii::app()->session['user'], 0, 0)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->session['user'], 1, 0, true)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->session['user'], 1, 1, false)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->session['user'], 1, 1, true)['price_out_sum']) - Payments::model()->getUserSum(Yii::app()->session['user']);
            $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => 1, 'user_id' => Yii::app()->session['user']));
            $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => 2, 'user_id' => Yii::app()->session['user']));
            $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => 3, 'user_id' => Yii::app()->session['user']));
            $parsed_site4 = Coefficients::model()->findByAttributes(array('site_name' => 4, 'user_id' => Yii::app()->session['user']));
            $parsed_site5 = Coefficients::model()->findByAttributes(array('site_name' => 5, 'user_id' => Yii::app()->session['user']));
            $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => 6, 'user_id' => Yii::app()->session['user']));
            $exchange_rates = ExchangeRates::model()->findByPk(1);

        } else {

            $arrears = (Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 0, true)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 1, false)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 1, true)['price_out_sum']) - Payments::model()->getUserSum(Yii::app()->user->id);
            $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => 1, 'user_id' => Yii::app()->user->id));
            $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => 2, 'user_id' => Yii::app()->user->id));
            $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => 3, 'user_id' => Yii::app()->user->id));
            $parsed_site4 = Coefficients::model()->findByAttributes(array('site_name' => 4, 'user_id' => Yii::app()->user->id));
            $parsed_site5 = Coefficients::model()->findByAttributes(array('site_name' => 5, 'user_id' => Yii::app()->user->id));
            $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => 6, 'user_id' => Yii::app()->user->id));
            $exchange_rates = ExchangeRates::model()->findByPk(1);

        };
        $query = '';
        if (isset($_GET['query']) && isset($_GET['Users']['id'])) {

            Yii::app()->session['user'] = $_GET['Users']['id'];

            $query = trim($_GET['query']);
            $query = preg_replace('![^\/\w\d\-]*!', '', $query);
            $queryCars = trim($_GET['query']);
            $oldData = Results_admin::model()->countByAttributes(array('query' => $query));
            if ($oldData == 0) {
                Yii::app()->db->createCommand()->truncateTable('results_admin');
                $flag = 0;
                Yii::import('ext.CurlAll.CurlAll');
                $get_html_martex = new  CurlAll();
                $site_diesel = 'http://www.diesel-czesci.pl/pl/search?query=' . $query;
                $url_martex = 'http://sklep.martextruck.pl/clientcatalogue/searchform.aspx';
                $url_diesel = 'http://www.diesel-czesci.pl/pl/login_check';
                $url_martex = 'http://sklep.martextruck.pl/clientcatalogue/searchform.aspx';
                $site_martex = 'http://sklep.martextruck.pl/partscatalogue/-,12-' . $query . '.aspx?&inStock=True';
                $url_opol = 'http://webcatalog.opoltrans.com.pl/pl/shop/operator/login';
                $site_opol = 'http://webcatalog.opoltrans.com.pl/shop/searcher/products/find?utf8=%E2%9C%93&tab=1&phrase=' . $query . '&commit=Szukaj&page=' . $page;
                $site_autos = 'https://sklep.autos.com.pl/?op=bsk';
                $autos_token = $get_html_martex->curl_token('https://sklep.autos.com.pl/?op=login');

                Yii::import('ext.CurlAll.CurlAll');
                Yii::import('ext.Parsing.ParsingAll');
                $parsing = new  ParsingAll();
                $autos_token_result = $parsing->getAutosToken($autos_token);
                $parsing_result = $get_html_martex->get_html($POST = null, $get_cookie = true, $JS = false, $other_set = null, $siteinfo[1]['login'], $siteinfo[1]['password'],
                    $url_martex, $url_diesel,
                    $siteinfo[0]['login'], $siteinfo[0]['password'], $site_martex, $site_diesel, $siteinfo[4]['login'], $siteinfo[4]['password'], $site_autos, $autos_token_result['salt'], $autos_token_result['number'], $autos_token_result['number_value'], $siteinfo[5]['login'], $siteinfo[5]['password']);
                if ($parsed_site1['status'] == 1) {
                    try {
                        $query = preg_replace('![^\w\d\-]*!', '', $query);
                        $flag = 1;
                        $result_final = $parsing->ParserMartext($parsing_result['martex'], $parsed_site1, $exchange_rates);
                        if ($result_final[1]['martex_work'] == 0) {
                            Yii::app()->db->createCommand()->update('sites_access_control', array(
                                'status' => 0),
                                'site_id=:site_id',
                                array(':site_id' => 1)
                            );
                        } else {
                            Yii::app()->db->createCommand()->update('sites_access_control', array(
                                'status' => 1),
                                'site_id=:site_id',
                                array(':site_id' => 1)
                            );
                        }

                        if (!empty($result_final)) {

                            foreach ($result_final as $result) {

                                Yii::app()->db->createCommand()->insert('results_admin', array(
                                    'result_name' => trim(strip_tags($result['name'])),
                                    'user_id' => Yii::app()->session['user'],
                                    'result_photo' => mb_substr($result['photo'], 0, strlen($result['photo']) - 2, 'UTF-8'),
                                    'result_manufacturer' => $result['manufacturer'],
                                    'result_price' => $result['price'],
                                    'result_info' => $result['details'],
                                    'site' => 'http://sklep.martextruck.pl/',
                                    'result_cod' => $result['number'],
                                    'def_price' => $result['def_price'],
                                    'result_state' => '',
                                    'info' => '',
                                    'query' => $query,
                                ));
                            }
                        }
                    } catch (CException $e) {
                        echo $e;
                        die;
                    }
                }
                if ($parsed_site2['status'] == 1) {
                    $query = preg_replace('![^\/\w\d\-]*!', '', $query);
                    $flag = 1;
                    $result_final_opol = new ParsingAll();
                    $products = $result_final_opol->ParsingOpol($parsing_result['opol'], $get_html_martex, $query);
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
                            if ((trim($product['availability']) != '0' || trim($product['rzeshow']) != '0') && (trim($product['availability']) != '' || trim($product['rzeshow']) != '') && $price != 0) {
                                Yii::app()->db->createCommand()->insert('results_admin', array(
                                    'result_name' => $product['product-name'],
                                    'user_id' => Yii::app()->session['user'],
                                    'result_photo' => (isset($product['photo']) && $product['photo'] != 'http://tdfoto.flkat24.pl:40000/-1') ? $product['photo'] : 'http://sklep.martextruck.pl/Handlers/ArticleImage.ashx?id=no-image&size=1',
                                    'result_manufacturer' => $product['product-producer-name'],
                                    'result_price' => $price,
                                    'result_info' => $product['product-url'],
                                    'site' => 'http://webcatalog.opoltrans.com.pl/',
                                    'result_cod' => $product['product-symbol'],
                                    'def_price' => $product['price'],
                                    'result_state' => $product['product-state'],
                                    'info' => $product['info'],
                                    'query' => $query,
                                ));
                            }
                        }
                    }
                    if ($products[1]['opol_work'] == 0) {
                        Yii::app()->db->createCommand()->update('sites_access_control', array(
                            'status' => 0),
                            'site_id=:site_id',
                            array(':site_id' => '2')
                        );
                    } else {
                        Yii::app()->db->createCommand()->update('sites_access_control', array(
                            'status' => 1),
                            'site_id=:site_id',
                            array(':site_id' => '1')
                        );
                    }
                }
                if ($parsed_site3['status'] == 1) {
                    Yii::import('ext.Parsing.InterCars');
                    $flag = 1;
                    $intercars_products = InterCars::getProductsByCod($queryCars);

                    if (!empty($intercars_products)) {
                        foreach ($intercars_products as $product) {
                            $product_image = InterCars::getProductImage($product['tow_kod']);


                            if (Yii::app()->session['session_info'] == 1) {
                                $ex_rate = $exchange_rates->zloty;
                            } else {
                                $ex_rate = $exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100);
                            }
                            $prices = InterCars::getProductPrices($product['kod_p'], $parsed_site3, $ex_rate);

                            Yii::app()->db->createCommand()->insert('results_admin', array(
                                'result_name' => $product['naz_ru'],
                                'user_id' => Yii::app()->session['user'],
                                'result_photo' => '/photos_online/' . $product_image['image_folder'] . '/' . $product_image['image_name'],
                                'result_manufacturer' => $product['name_brend'],
                                'result_price' => $prices['price'],
                                'result_info' => 'intercars',
                                'site' => 'http://www.intercars.com.pl/',
                                'result_cod' => $product['kod_p'],
                                'def_price' => $prices['wholesalePrice'],
                                'result_state' => 0,
                                'info' => $product['info'],
                                'query' => $query,
                            ));
                        }
                    }
                }
                if ($parsed_site5['status'] == 1) {
                    try {
                        $query = preg_replace('![^\/\w\d\-]*!', '', $query);
                        $flag = 1;
                        Yii::import('ext.CurlAll.CurlAll');
                        Yii::import('ext.Parsing.ParsingAll');
                        $result_final_diesel = new ParsingAll();
                        $result_final = $result_final_diesel->ParsingDiesel($parsing_result['diesel'], $parsed_site5, $exchange_rates);
                        if (!empty($result_final) && $result_final[0]['diesel_work'] == 0) {
                            Yii::app()->db->createCommand()->update('sites_access_control', array(
                                'status' => 0),
                                'site_id=:site_id',
                                array(':site_id' => '3')
                            );
                        } else {
                            Yii::app()->db->createCommand()->update('sites_access_control', array(
                                'status' => 1),
                                'site_id=:site_id',
                                array(':site_id' => '3')
                            );
                        }
                        if (!empty($result_final)) {
                            foreach ($result_final as $result) {
                                if ($result['aviliability'] != '0') {
                                    Yii::app()->db->createCommand()->insert('results_admin', array(
                                        'result_name' => trim(strip_tags($result['name'])),
                                        'user_id' =>  Yii::app()->session['user'],
                                        'result_photo' => $result['photo'],
                                        'result_manufacturer' => '',
                                        'result_price' => $result['price'],
                                        'result_info' => $result['details'],
                                        'site' => 'http://www.diesel-czesci.pl/',
                                        'result_cod' => '',
                                        'def_price' => $result['def_price'],
                                        'result_state' => '',
                                        'info' => '',
                                        'query' => $query,
                                    ));
                                }
                            }
                        }
                    } catch (CException $e) {
                        echo $e;
                        die;
                    }
                }
                if ($parsed_site6['status'] == 1) {
                    try {
                        Yii::import('ext.CurlAll.CurlAll');
                        Yii::import('ext.Parsing.ParsingAll');
                        $query = preg_replace('![^\/\w\d\-]*!', '', $query);
                        $flag = 1;
                        $result_final = $parsing->ParserAutos($parsing_result['autos'], $parsed_site6, $exchange_rates);


                        if ($result_final[1]['autos_work'] == 0) {
                            Yii::app()->db->createCommand()->update('sites_access_control', array(
                                'status' => 0),
                                'site_id=:site_id',
                                array(':site_id' => 6)
                            );
                        } else {
                            Yii::app()->db->createCommand()->update('sites_access_control', array(
                                'status' => 1),
                                'site_id=:site_id',
                                array(':site_id' => 6)
                            );
                        }
                        $insertResults = array();

                        if (!empty($result_final)) {

                            foreach ($result_final as $result) {
                                $insertResults[] = array(
                                    'user_id' => Yii::app()->session['user'],
                                    'result_name' => $result['info'],
                                    'result_photo' => $result['photo'],
                                    'result_manufacturer' => $result['manufacturer'],
                                    'result_price' => $result['price_one'],
                                    'site' => 'https://sklep.autos.com.pl/',
                                    'result_cod' => $result['cod'],
                                    'def_price' => $result['def_price'],
                                    'result_state' => $result['codOE1'] . ',' . $result['codOE2'],
                                    'info' => $result['rzeszow'] . ',' . $result['center'],
                                    'query' => $query,

                                );
                            }

                            Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results_admin', $insertResults)->execute();
                        }
                    } catch (CException $e) {
                        echo $e;
                        die;
                    }
                }
                if ($parsed_site4['status'] == 1) {
                    $query = preg_replace('![^\w\d]*!', '', $query);
                    $flag = 1;
                    Yii::import('ext.CurlAll.CurlAll');
                    $get_html_skuba = new  CurlAll();
                    $login_4 = $skuba['login'];
                    $pass_4 = $skuba['password'];
                    $site_4 = 'sklep.skuba.com.pl/emini/Default.aspx?tabid=54&v=' . $query . '&b=n';
                    $url_4 = 'sklep.skuba.com.pl/emini/Default.aspx?tabid=36&ctl=Login&returnurl=%2femini%2fDefault.aspx%3ftabid%3d36';
                    $html_4 = $get_html_skuba->get_html_skuba($url_4);
                    $html_4_1 = $get_html_skuba->get_html_skuba_2($site_4, $url_4);
                    $div = phpQuery::newDocument($html_4);
                    $div_2 = phpQuery::newDocument($html_4_1);
                    $contents = $div_2->find('#dnn_ctr447_ModuleContent');
                    $href = $contents->find('tr')->find('a:contains("Sprzedaj")');
                    if (isset($href)) {
                        foreach ($href as $site) {
                            $site = pq($site)->attr('href');
                            $site = str_replace('tabid=66&o=add', 'tabid=55', $site);
                            $site_5 = 'sklep.skuba.com.pl' . $site;
                            $html_5 = $get_html_skuba->get_html_skuba_3($site_5);
                            $div = phpQuery::newDocument($html_5);
                            $results = $div->find('#dnn_ctr372_eMini_Stock_gvStock');

                            if (isset($results)) {
                                $name = $div->find('#dnn_ctr372_eMini_Stock_lblNameVal')->text();
                                $photo = $div->find('#dnn_ctr372_eMini_Stock_divFotos');
                            }
                            foreach ($results as $result) {
                                $pq = pq($result);
//									echo $pq;
                                $a = $pq->find('tbody tr')->find('td')->eq(2);
                                echo $a;
//foreach($pq as $tag){
////echo $tag;
//	foreach(pq($tag)->find('td') as $td) {
//		//$table=pq($td)->eq(3);
//		//echo $td;
//	}
////
////
////
//}

//									for($i=2;$i<200;$i++) {
//
//										if ($i < 10) {
//
//											$price = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_Label3')->text();
//											$price = str_replace('PLN', '', $price);
//											$price = str_replace(',', '.', $price);
//											$price = trim($price);
//											$def_price = (double)$price;
//											$data['def_price'] = $def_price;
//											$price = ((double)$price) * $parsed_site1->logistic * $parsed_site1->manager_coef * $parsed_site1->curator_coef * $parsed_site1->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100));
//											$data['price'] = round($price, 0);
//											$data['kod'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_lblCard')->text();
//											$data['count'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_lblQty')->text();
//											$data['sklep'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_lblStore')->text();
//											$data['manufactured'] =$pq->find('td')->eq(3)->text();
//
//											$products_44[] = $data;
//											unset($data);
//
//											foreach ($products_44 as $product) {
//												Yii::app()->db->createCommand()->insert('results', array(
//													'result_name' => $name,
//													'user_id' => Yii::app()->user->id,
//													'result_photo' => $photo,
//													'result_manufacturer' => $product['manufactured'],
//													'result_price' => round(((double)$product['price']) * $parsed_site2->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100))),
//													//'result_info' => $product['product-url'],
//													'site' => 'http://sklep.skuba.com.pl/',
//													'result_cod' => $product['kod'],
//													'def_price' => $product['price'],
//													//'result_state' => $product['product-state'],
//													//'info' => $product['info'],
//													'query' => $query,
//												));
////						}
//											}
//										} else {
//											$price = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_Label3')->text();
//											$price = str_replace('PLN', '', $price);
//											$price = str_replace(',', '.', $price);
//											$price = trim($price);
//											$def_price = (double)$price;
//											$data['def_price'] = $def_price;
//											$price = ((double)$price) * $parsed_site4->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100));
//											$data['price'] = round($price, 0);
//											$data['kod'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_lblCard')->text();
//											$data['count'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_lblQty')->text();
//											$data['sklep'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_lblStore')->text();
//											$data['manufactured'] =$pq->find('td')->eq(3)->text();
////											echo 	$data['count'];
//											$products_44[] = $data;
//											unset($data);

//											foreach ($products_44 as $product) {
//												Yii::app()->db->createCommand()->insert('results', array(
//													'result_name' => $name,
//													'user_id' => Yii::app()->user->id,
//													'result_photo' => $photo,
//													'result_manufacturer' => $product['manufactured'],
//													'result_price' => round(((double)$product['price']) * $parsed_site2->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100))),
//													//'result_info' => $product['product-url'],
//													'site' => 'http://sklep.skuba.com.pl/',
//													'result_cod' => $product['kod'],
//													'def_price' => $product['price'],
//													//'result_state' => $product['product-state'],
//													//'info' => $product['info'],
//													'query' => $query,
//												));
////						}
//											}

                            };

                            //	}
                            //}
//								if (!empty($products_44)) {


//								}
                        }
                    }
                }

                $enteredCode = preg_replace('![^\w\d\s]*!', '', trim($_GET['query']));
                $results_add = Results_add::getProductsByCode($enteredCode);
                $insertResults = array();
                if (!empty($results_add)) {
                    foreach ($results_add as $item) {

                        $provider = ProviderPerson::model()->getProviderAccess($item['user_id']);
                        if (CountryCoef::getFinalCoef(Yii::app()->session['user'], $provider->country_id)['status'] != 0) {
                            $insertResults[] = array(
                                'user_id' => Yii::app()->session['user'],
                                'product_id' => $item['id'],
                                'result_name' => $item['name'],
                                'result_photo' => $item['photo'],
                                'result_manufacturer' => $item['manufacturer'],
                                'def_price' => round($item['price'], 2),
                                'result_price' => round($item['price'] * CountryCoef::getFinalCoef(Yii::app()->session['user'], $provider->country_id)['rs'] * $provider->country_logistic * ExchangeRates::model()->getActualCurs($item['currency']), 0),
                                'result_cod' => $item['cod'],
                                'provider_id' => $item['providerperson'],
                                'site' => 'private_person',
                            );

                        }

                    }
                    if(!empty($insertResults)) {
                        Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results_admin', $insertResults)->execute();
                    }
                    }
                if (!empty($results_2) || !empty($products) || !empty($intercars_products)) {
                    $query = $_GET['query'];
                    Yii::app()->db->createCommand()->insert('activity', array(
                        'user_id' => Yii::app()->session['user'],
                        'date' => date('Y-m-d H:i:s', time()),
                        'search' => $query,
                        'status' => 1
                    ));
                }
                if (empty($results_2) && empty($products) && empty($intercars_products)) {
                    $query = $_GET['query'];
                    Yii::app()->db->createCommand()->insert('activity', array(
                        'user_id' => Yii::app()->session['user'],
                        'date' => date('Y-m-d H:i:s', time()),
                        'search' => $query,
                        'status' => 0
                    ));
                }
            }
        }
        // collect user input data
        $model = new Users();
        $empty = Results_admin::model()->findAll();
        $orders_sum = Orders::model()->getUserSumByDateOrdered(Yii::app()->session['user'], date('Y-m-d', time()), 0, 0)['price_out_sum'];
        $users = Users::model()->findAll();
        $users = CHtml::listData($users, 'id', 'fullname');

        $this->render('index', array('model' => $model,
            'parsed_site1' => $parsed_site1,
            'exchange_rates' => $exchange_rates,
            'results_2' => $results_2,
            'model_2' => $model_2,
            'flag' => $flag,
            'opol_results' => $products,
            'intercars_products' => $intercars_products,
            'query' => $query,
            'arrears' => $arrears,
            'orders_sum' => $orders_sum,
            'empty' => $empty,
            'users' => $users
        ));
    }

    public function actionInfo()
    {
        $data_activity = date('H:i', time());
        $data_worked = Data_worked::model()->findByPk(1);
        $date = time();
        if ($data_activity >= date('H:i', strtotime($data_worked['date']))) {
            $date = $date + 24 * 60 * 60;
        }
        $condition_centr = 't.data>:ordered';
        if ($data_activity >= date('H:i', strtotime($data_worked['date']))) {
            $condition_centr = 't.data>:ordered';
        }
        $data_calendar_centr = Calendar::model()->findAll((array(
            'select' => 't.data',
            'limit' => 1,
            'order' => 't.data ',
            'condition' => $condition_centr,
            'params' => array('ordered' => date('Y-m-d', $date)),

        )));
        $condition = 't.data>:ordered';
        if ($data_activity >= date('H:i', strtotime($data_worked['date']))) {
            $condition = 't.data>:ordered';
        }
        $data_calendar_filia = Calendar::model()->findAll((array(
            'select' => 't.data',
            'limit' => 1,
            'order' => 't.data ',
            'condition' => $condition,
//			'condition'=>'t.data>:ordered AND (t.sklep=:sklep OR t.sklep_1=:sklep OR t.sklep_2=:sklep OR t.sklep_3=:sklep OR t.sklep_4=:sklep OR t.sklep_5=:sklep OR t.sklep_6=:sklep OR t.sklep_7=:sklep OR t.sklep_8=:sklep OR t.sklep_9=:sklep)',
//			'params'=>array('ordered' =>  date('Y-m-d',time()), 'sklep' => 'filia'),
            'params' => array('ordered' => date('Y-m-d', time())),
        )));
        Yii::import('ext.CurlAll.CurlAll');
        include('protected/vendors/phpQuery/phpQuery/phpQuery.php');
        $exchange_rates = ExchangeRates::model()->findByPk(1);
        $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => '1', 'user_id' => Yii::app()->session['user']));
        $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => '2', 'user_id' => Yii::app()->session['user']));
        $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => '3', 'user_id' => Yii::app()->session['user']));
        $parsed_site5 = Coefficients::model()->findByAttributes(array('site_name' => '5', 'user_id' => Yii::app()->session['user']));
        $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => '6', 'user_id' => Yii::app()->session['user']));
        $details = $_GET['result_info'];
        $siteinfo = Infosite::model()->findAll();
        $get_html = new  CurlAll();
        if ($_GET['site'] == 'http://webcatalog.opoltrans.com.pl/') {
            try {
                $result = $get_html->get_html_opol('http://webcatalog.opoltrans.com.pl/pl/shop/operator/login');
                Yii::import('ext.Parsing.ParsingAll');
                $info = new ParsingAll();
                $result_opol_info = $info->OpolInfo($result[content], $siteinfo[1]['login'], $siteinfo[1]['password'], $get_html, $parsed_site2, $exchange_rates, $data_calendar_centr[0]['data'], $data_calendar_filia[0]['data']);
                $item = $result_opol_info['item'];
                $item_info = $result_opol_info['item_info'];
                $table_1 = $result_opol_info['table_1'];
                $table_2 = $result_opol_info['table_2'];
                $table_3 = $result_opol_info['table_3'];
                $table_6 = $result_opol_info['table_6'];
                $table_7 = $result_opol_info['table_7'];
            } catch (CException $e) {
                echo $e;
                die;
            }
        } elseif ($_GET['site'] == 'http://www.intercars.com.pl/') {
            Yii::import('ext.Parsing.InterCars');

            $tow_kod = trim($_GET['cod']);
            $product = InterCars::getProductInfo($tow_kod, $exchange_rates, $parsed_site3);
            $table_1 = $this->renderPartial('//site/tables/table_1', array('articles' => $product['articles']), true);
            $table_2 = $this->renderPartial('//site/tables/table_2', array('kat_oe' => $product['kat_oe']), true);
            $table_6 = $this->renderPartial('//site/tables/table_6', array('substitutes' => $product['substitutes']), true);

            if (Yii::app()->session['session_info'] == 1) {
                $ex_rate = $exchange_rates->zloty;
            } else {
                $ex_rate = $exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100);
            }
            $prices = InterCars::getProductPrices($product['info']['kod_p'], $parsed_site3, $ex_rate);

            $item = array(
                array(
                    'name' => $product['info']['naz_ru'],
                    'photo' => '/photos_online/' . $product['image']['image_folder'] . '/' . $product['image']['image_name'],
                    'manufacturer' => $product['info']['name_brend'],
                    'price' => round($prices['price'], 0),
                    'stock' => $product['avaliability_czo']['ile_d'] . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_centr[0]['data'])) . ' )',
                    'stock_2' => $product['avaliability_rze'] ? ($product['avaliability_rze']['ile_d'] . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_filia[0]['data'])) . ' )') : '--',
                )
            );
            $item_info = array(
                'price_one' => round($prices['price'], 0),
                'def_price' => $prices['wholesalePrice'],
                'provider' => $_GET['site'],
                'cod' => $_GET['cod']
            );
        }elseif  ($_GET['site'] == 'http://www.diesel-czesci.pl/') {
            try {
                Yii::import('ext.CurlAll.CurlAll');
                Yii::import('ext.Parsing.ParsingAll');
                $get_html_diesel_2 = new  CurlAll();
                $get_html_diesel_2_info = new  ParsingAll();
                $res_1 = $get_html_diesel_2->get_html_diesel_2($details);
                $diesel_info = $get_html_diesel_2_info->DieselInfo($res_1, $parsed_site5, $exchange_rates, $data_calendar_centr[0]['data'], $data_calendar_filia[0]['data']);
                $item = $diesel_info['item'];
                $table_1 = $diesel_info['table_1'];
                $item_info = $diesel_info['item_info'];
            } catch (CException $e) {
                echo $e;
                die;
            }
        }
        elseif ($_GET['site'] == 'private_person') {

            $info = Results_add::model()->findByPk($_GET['product_id']);
            $symbols = Numbers_add::model()->findAllByAttributes(array('results_add_id' => $info['id']));
            $provider = ProviderPerson::getProviderAccess($info->user_id);

            $item = array(
                array(
                    'name' => $info->name . ' ' . $info->cod . (isset($info->weight) && $info->weight > 0 ? (' ' . $info->weight . ' кг') : ''),
                    'photo' => $info->photo,
                    'manufacturer' => $info->manufacturer,
                    'price' => $_GET['price'],
                    'stock' => $info->state,
                    'stock_2' => 0,
                    'status_hint' => $provider->status_hint,
                    'country_hint' => $provider->country_hint,
                    'country_name' => $provider->country->name,
                    'status_country' => $provider->status_country,
                )
            );
            $item_info = array(
                'price_one' => round($info->price, 0),
                'provider' => $provider->username->organisation,
                'cod' => $info->cod,
                'def_price' => $info->price,
            );

            if (isset($symbols)) {
                $table_7 = '<table id="replacementgrid" class="dgrid" width="100%">';
                foreach ($symbols as $items) {

                    $table_7 .= '<tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">';
                    $table_7 .= '<td>' . $items['number'] . '</td>';
                }
                $table_7 .= '</table>';
            }

        } elseif ($_GET['site'] == 'http://sklep.martextruck.pl/') {
            try {
                $detail = 'http://sklep.martextruck.pl' . $details;
                Yii::import('ext.CurlAll.CurlAll');
                Yii::import('ext.Parsing.ParsingAll');
                $get_html_martex_2 = new  CurlAll();
                $get_html_martex_2_info = new  ParsingAll();
                $res_1 = $get_html_martex_2->get_html_martex_2($detail);
                $martex_info = $get_html_martex_2_info->MartexInfo($res_1, $parsed_site1, $exchange_rates, $data_calendar_centr[0]['data'], $data_calendar_filia[0]['data']);
                $item = $martex_info['item'];
                $item_info = $martex_info['item_info'];
                $table_1 = $martex_info['table_1'];
                $table_2 = $martex_info['table_2'];
                $table_3 = $martex_info['table_3'];
                $table_6 = $martex_info['table_6'];
            } catch (CException $e) {
                echo $e;
                die;
            }
        }
        elseif ($_GET['site'] == 'https://sklep.autos.com.pl/') {

            $array = explode(',', $_GET['info']);
            $array_2 = explode(',', $_GET['state']);

            $item = array(
                array(
                    'name' => $_GET['name'],
                    'photo' => $_GET['photo'],
                    'manufacturer' => $_GET['manufacturer'],
                    'price' => round($_GET['price'], 0),
                    'stock' => $array[0] . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_centr[0]['data'])) . ' )',
                    'stock_2' => $array[1] ? ($array[1] . '( дата доставки - ' . date('d.m.Y', strtotime($data_calendar_filia[0]['data'])) . ' )') : '--',
                )
            );
            $prom_price =  $_GET['def_price'];
            if (Yii::app()->session['session_info'] == 1) {
                $price = round(($prom_price) * $parsed_site6->logistic * ($exchange_rates->zloty), 0);
                $admin_price = ($price * $parsed_site6->admin_coef) - $price;
                $curator_price = ($price * $parsed_site6->curator_coef) - $price;
                $manager_price = ($price * $parsed_site6->manager_coef) - $price;
                $prom_prices_2 = round($admin_price + $curator_price + $manager_price + $price, 0);
            } else {
                $price = round(($prom_price) * $parsed_site6->logistic * ($exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100)), 0);
                $admin_price = ($price * $parsed_site6->admin_coef) - $price;
                $curator_price = ($price * $parsed_site6->curator_coef) - $price;
                $manager_price = ($price * $parsed_site6->manager_coef) - $price;
                $prom_prices_2 = round($admin_price + $curator_price + $manager_price + $price, 0);
            };
            $item_info = array(
                'price_one' => $prom_prices_2,
                'def_price' => $prom_price,
                'provider' => $_GET['site'],
                'cod' => $_GET['cod']
            );
            $table_2 = '';
            foreach ($array_2 as $items) {
                $table_2 .= $items. ' ';
            }
        }

        $dataProvider = new CArrayDataProvider($item, array());
        $this->render('info', array(
            'table_1' => $table_1,
            'table_2' => $table_2,
            'table_3' => $table_3,
            'table_4' => $table_4,
            'table_5' => $table_5,
            'table_6' => $table_6,
            'table_7' => $table_7,
            'item' => $dataProvider,
            'item_info' => $item_info,
            'data_calendar' => $data_calendar_centr,
            'data_worked' => $data_worked));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if (Yii::app()->user->isGuest) {
            $this->layout = 'login';
        }

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLogin()

    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/admin/site/index');
        }
        $this->layout = 'login';
        $model = new LoginForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect('/admin/site/index', array('model' => $model));
            }
        }
        $this->render('login', array('model' => $model));
    }

    public function actionAdd()
    {
        $response = array(
            'status' => false
        );
        $model = new Orders;
        $orderAttributes = Yii::app()->request->getPost('Orders');
        $user = Users::model()->findByAttributes(array(
            'id' => Yii::app()->session['user']
        ));

        if (!empty($orderAttributes)) {
            $model->attributes = $orderAttributes;
            $model->user_id = $user['id'];
            $model->user_name = $user['username'];
            if ($model->validate() && $model->save()) {
                $response['status'] = true;
            }
        }
        echo json_encode($response);
        Yii::app()->end();
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/admin/site');
    }
}