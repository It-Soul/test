<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
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

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('error', 'login', 'registration', 'logout', 'region', 'city', 'check', 'confirm', 'recovery'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('admin', 'login', 'index', 'create', 'update', 'error', 'info', 'logout', 'add', 'index_payment', 'index_payment_2'),
                'users' => array('@'),

            ),
            array('deny',
                'actions' => array(),
                'users' => array('*'),
            ),
        );
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    protected function beforeAction($event)
    {
        if (!Yii::app()->user->isGuest) {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            if ($user->role == 'banned' || $user->status != 1) {
                Yii::app()->user->logout();
                $this->redirect('/site/login');
            }
            return true;
        }
        return true;
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionLogin()
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/site/index');
        }

        $this->layout = 'login';

        $model = new LoginForm;


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];
            $email = strtolower($_POST['LoginForm']['email']);

            if ($model->validate() && $model->login()) {
                $this->redirect('/site/index');
            }

        }

        $this->render('login', array(
            'model' => $model,
        ));
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

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionAdd()
    {
        $response = array(
            'status' => false
        );
        $model = new Orders;
        $orderAttributes = Yii::app()->request->getPost('Orders');
        if (!empty($orderAttributes)) {
            $model->attributes = $orderAttributes;
            $model->user_id = Yii::app()->user->id;

            $model->user_name = Yii::app()->user->name;
            if ($model->validate() && $model->save()) {
                $response['status'] = true;
            }
        }
        echo json_encode($response);
        Yii::app()->end();
    }

    public function actionIndex()

    {
        $model_2 = new Results('search');
        $model_2->unsetAttributes();  // clear any default values
        if (isset($_GET['Results'])) {
            $model_2->attributes = $_GET['Results'];
        }
        $data_activity = date('H:i', time());
        $data_worked = Data_worked::model()->findByPk(1);
        $date = time() - 24 * 60 * 60;
        if ($data_activity >= date('H:i', strtotime('1970-01-01 09:00:00')) && $data_activity <= date('H:i', strtotime($data_worked['date']))) {
            $date = time();
        }
        $martex_work = 1;
        $opol_work = 1;
        $intercars_work = 1;
        $skuba_work = 1;
        $query = '';

        if (isset($_GET['query'])) {
            $query = trim($_GET['query']);
            $query = preg_replace('![^\/\w\d\-]*!', '', $query);
            $queryCars = trim($_GET['query']);
            $oldData = Results::model()->countByAttributes(array('query' => $query, 'user_id' => Yii::app()->user->id));
            if ($oldData == 0) {
                include('protected/vendors/phpQuery/phpQuery/phpQuery.php');
                $siteinfo = Infosite::model()->findAll();
                $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => 1, 'user_id' => Yii::app()->user->id));
                $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => 2, 'user_id' => Yii::app()->user->id));
                $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => 3, 'user_id' => Yii::app()->user->id));
                $parsed_site4 = Coefficients::model()->findByAttributes(array('site_name' => 4, 'user_id' => Yii::app()->user->id));
                $parsed_site5 = Coefficients::model()->findByAttributes(array('site_name' => 5, 'user_id' => Yii::app()->user->id));
                $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => 6, 'user_id' => Yii::app()->user->id));
                $exchange_rates = ExchangeRates::model()->findByPk(1);
                Results::model()->deleteAll('user_id=:user_id', array(':user_id' => Yii::app()->user->id));
                $flag = 0;
                Yii::import('ext.CurlAll.CurlAll');
                Yii::import('ext.Parsing.ParsingAll');
                $get_html_martex = new  CurlAll();
                $parsing = new  ParsingAll();
                $url_martex = 'http://sklep.martextruck.pl/clientcatalogue/searchform.aspx';
                $url_diesel = 'http://www.diesel-czesci.pl/pl/login_check';
                $site_martex = 'http://sklep.martextruck.pl/partscatalogue/-,12-' . $query . '.aspx?&inStock=True';
                $site_diesel = 'http://www.diesel-czesci.pl/pl/search?query=' . $query;
                $site_autos = 'https://sklep.autos.com.pl/?op=bsk';
                $autos_token = $get_html_martex->curl_token('https://sklep.autos.com.pl/?op=login');
                $autos_token_result = $parsing->getAutosToken($autos_token);

                $parsing_result = $get_html_martex->get_html($POST = null, $get_cookie = true, $JS = false, $other_set = null, $siteinfo[1]['login'], $siteinfo[1]['password'],
                    $url_martex, $url_diesel,
                    $siteinfo[0]['login'], $siteinfo[0]['password'], $site_martex, $site_diesel, $siteinfo[4]['login'], $siteinfo[4]['password'], $site_autos, $autos_token_result['salt'], $autos_token_result['number'], $autos_token_result['number_value'], $siteinfo[5]['login'], $siteinfo[5]['password']);

                if ($parsed_site1['status'] == 1) {
                    try {
                        Yii::import('ext.CurlAll.CurlAll');
                        Yii::import('ext.Parsing.ParsingAll');
                        $query = preg_replace('![^\/\w\d\-]*!', '', $query);
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
                        $insertResults = array();

                        if (!empty($result_final)) {
                            foreach ($result_final as $result) {
                                $insertResults[] = array(
                                    'result_name' => trim(strip_tags($result['name'])),
                                    'user_id' => Yii::app()->user->id,
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
                                );
                            }
                            Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results', $insertResults)->execute();
                        }
                    } catch (CException $e) {
                        echo $e;
                        die;
                    }
                }
                if ($parsed_site2['status'] == 1) {
                    try {
                        Yii::import('ext.CurlAll.CurlAll');
                        Yii::import('ext.Parsing.ParsingAll');
                        $query = preg_replace('![^\/\w\d\-]*!', '', $query);
                        $flag = 1;
                        $result_final_opol = new ParsingAll();
                        $products = $result_final_opol->ParsingOpol($parsing_result['opol'], $get_html_martex, $query);
                        $insertResults = array();

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
                                if (($product['availability'] > 0 || $product['rzeshow'] > 0) && (trim($product['availability']) != '' || trim($product['rzeshow']) != '') && $price != 0) {
                                    $insertResults[] = array(
                                        'result_name' => $product['product-name'],
                                        'user_id' => Yii::app()->user->id,
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
                                    );
                                }
                            }
                            if (!empty($insertResults)) {
                                Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results', $insertResults)->execute();
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
                    } catch (CException $e) {
                        echo $e;
                        die;
                    }
                }
                if ($parsed_site3['status'] == 1) {
                    Yii::import('ext.Parsing.InterCars');
                    $flag = 1;
                    $intercars_products = InterCars::getProductsByCod($queryCars);
                    $insertResults = array();

                    if (!empty($intercars_products)) {
                        foreach ($intercars_products as $product) {
                            $product_image = InterCars::getProductImage($product['tow_kod']);
                            if (Yii::app()->session['session_info'] == 1) {
                                $ex_rate = $exchange_rates->zloty;
                            } else {
                                $ex_rate = $exchange_rates->zloty + (($exchange_rates->zloty_repair * $exchange_rates->zloty) / 100);
                            };

                            $prices = InterCars::getProductPrices($product['kod_p'], $parsed_site3, $ex_rate);

                            $insertResults[] = array(
                                'result_name' => $product['naz_ru'],
                                'user_id' => Yii::app()->user->id,
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
                            );
                        }
                        Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results', $insertResults)->execute();
                    }
                }
                if ($parsed_site5['status'] == 1) {
                    try {
                        Yii::import('ext.CurlAll.CurlAll');
                        Yii::import('ext.Parsing.ParsingAll');
                        $query = preg_replace('![^\/\w\d\-]*!', '', $query);
                        $flag = 1;
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
                                array(':site_id' => '5')
                            );
                        }
                        $insertResults = [];

                        if (!empty($result_final)) {
                            foreach ($result_final as $result) {
                                if ($result['aviliability'] != '0') {
                                    $insertResults[] = array(
                                        'result_name' => trim(strip_tags($result['name'])),
                                        'user_id' => Yii::app()->user->id,
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
                                    );
                                }
                            }
                            Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results', $insertResults)->execute();
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
                                    'result_name' => $result['info'],
                                    'user_id' => Yii::app()->user->id,
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

                            Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results', $insertResults)->execute();
                        }
                    } catch (CException $e) {
                        echo $e;
                        die;
                    }
                }
//                if ($parsed_site4['status'] == 1) {
//                    $query = preg_replace('![^\w\d]*!', '', $query);
//                    $flag = 1;
//                    Yii::import('ext.CurlAll.CurlAll');
//                    $get_html_skuba = new  CurlAll();
//                    $login_4 = $skuba['login'];// 'LcParts';
//                    $pass_4 = $skuba['password'];// 'Lc754583';
//                    $site_4 = 'sklep.skuba.com.pl/emini/Default.aspx?tabid=54&v=' . $query . '&b=n';
//                    $url_4 = 'sklep.skuba.com.pl/emini/Default.aspx?tabid=36&ctl=Login&returnurl=%2femini%2fDefault.aspx%3ftabid%3d36';
//                    $html_4 = $get_html_skuba->get_html_skuba($url_4);
//                    $html_4_1 = $get_html_skuba->get_html_skuba_2($site_4, $url_4);
//                    $div = phpQuery::newDocument($html_4);
//                    $div_2 = phpQuery::newDocument($html_4_1);
//                    $contents = $div_2->find('#dnn_ctr447_ModuleContent');
//                    $href = $contents->find('tr')->find('a:contains("Sprzedaj")');
//
//                    if (isset($href)) {
//
//                        foreach ($href as $site) {
//
//                            $site = pq($site)->attr('href');
//                            $site = str_replace('tabid=66&o=add', 'tabid=55', $site);
//                            $site_5 = 'sklep.skuba.com.pl' . $site;
//                            $html_5 = $get_html_skuba->get_html_skuba_3($site_5);
//                            $div = phpQuery::newDocument($html_5);
//                            $results = $div->find('#dnn_ctr372_eMini_Stock_gvStock');
//
//                            if (isset($results)) {
//                                $name = $div->find('#dnn_ctr372_eMini_Stock_lblNameVal')->text();
//                                $photo = $div->find('#dnn_ctr372_eMini_Stock_divFotos');
//
//                            }
//                            foreach ($results as $result) {
//
//                                $pq = pq($result);
////									echo $pq;
//                                $a = $pq->find('tbody tr')->find('td')->eq(2);
//                                echo $a;
////foreach($pq as $tag){
//////echo $tag;
////	foreach(pq($tag)->find('td') as $td) {
////		//$table=pq($td)->eq(3);
////		//echo $td;
////	}
//////
//////
//////
////}
//
////									for($i=2;$i<200;$i++) {
////
////										if ($i < 10) {
////
////											$price = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_Label3')->text();
////											$price = str_replace('PLN', '', $price);
////											$price = str_replace(',', '.', $price);
////											$price = trim($price);
////											$def_price = (double)$price;
////											$data['def_price'] = $def_price;
////											$price = ((double)$price) * $parsed_site1->logistic * $parsed_site1->manager_coef * $parsed_site1->curator_coef * $parsed_site1->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100));
////											$data['price'] = round($price, 0);
////											$data['kod'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_lblCard')->text();
////											$data['count'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_lblQty')->text();
////											$data['sklep'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl0' . $i . '_lblStore')->text();
////											$data['manufactured'] =$pq->find('td')->eq(3)->text();
////
////											$products_44[] = $data;
////											unset($data);
////
////											foreach ($products_44 as $product) {
////												Yii::app()->db->createCommand()->insert('results', array(
////													'result_name' => $name,
////													'user_id' => Yii::app()->user->id,
////													'result_photo' => $photo,
////													'result_manufacturer' => $product['manufactured'],
////													'result_price' => round(((double)$product['price']) * $parsed_site2->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100))),
////													//'result_info' => $product['product-url'],
////													'site' => 'http://sklep.skuba.com.pl/',
////													'result_cod' => $product['kod'],
////													'def_price' => $product['price'],
////													//'result_state' => $product['product-state'],
////													//'info' => $product['info'],
////													'query' => $query,
////												));
//////						}
////											}
////										} else {
////											$price = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_Label3')->text();
////											$price = str_replace('PLN', '', $price);
////											$price = str_replace(',', '.', $price);
////											$price = trim($price);
////											$def_price = (double)$price;
////											$data['def_price'] = $def_price;
////											$price = ((double)$price) * $parsed_site4->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100));
////											$data['price'] = round($price, 0);
////											$data['kod'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_lblCard')->text();
////											$data['count'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_lblQty')->text();
////											$data['sklep'] = $pq->find('#dnn_ctr372_eMini_Stock_gvStock_ctl' . $i . '_lblStore')->text();
////											$data['manufactured'] =$pq->find('td')->eq(3)->text();
//////											echo 	$data['count'];
////											$products_44[] = $data;
////											unset($data);
//
////											foreach ($products_44 as $product) {
////												Yii::app()->db->createCommand()->insert('results', array(
////													'result_name' => $name,
////													'user_id' => Yii::app()->user->id,
////													'result_photo' => $photo,
////													'result_manufacturer' => $product['manufactured'],
////													'result_price' => round(((double)$product['price']) * $parsed_site2->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty +(($exchange_rates->zloty_repair*$exchange_rates->zloty)/100))),
////													//'result_info' => $product['product-url'],
////													'site' => 'http://sklep.skuba.com.pl/',
////													'result_cod' => $product['kod'],
////													'def_price' => $product['price'],
////													//'result_state' => $product['product-state'],
////													//'info' => $product['info'],
////													'query' => $query,
////												));
//////						}
////											}
//
//                            };
//
//                            //	}
//                            //}
////								if (!empty($products_44)) {
//
//
////								}
//
//                        }
//                    }
//                }
                $enteredCode = preg_replace('![^\w\d\s]*!', '', $_GET['query']);

                $results_add = Results_add::getProductsByCode($enteredCode);
//                $results_add = Yii::app()->db->cache(1000)->createCommand()
//                    -> selectDistinct('r.id,r.user_id,r.name,r.photo,r.manufacturer,r.price,r.cod,p.id AS providerperson')
//                    ->leftJoin('numbers_add n', 'n.results_add_id = r.id')
//                    ->join('provider_person p', 'r.user_id = p.user_id')
//                    ->from('results_add r')
//                    ->where('r.cod like :query or n.number like :query', array('query' => '%' . $enteredCode . '%'))
//                    ->queryAll();

                $insertResults = array();

                if (!empty($results_add)) {
                    foreach ($results_add as $item) {
                        $provider = ProviderPerson::model()->getProviderAccess($item['user_id']);
                        if(CountryCoef::getFinalCoef(Yii::app()->user->id,$provider->country_id)['status']!= 0){
                        $insertResults[] = array(
                            'user_id' => Yii::app()->user->id,
                            'product_id' => $item['id'],
                            'result_name' => $item['name'],
                            'result_photo' => $item['photo'],
                            'result_manufacturer' => $item['manufacturer'],
                            'def_price' => round($item['price'], 2),
                            'result_price' => round($item['price'] * CountryCoef::getFinalCoef(Yii::app()->user->id,$provider->country_id)['rs'] * $provider->country_logistic * ExchangeRates::model()->getActualCurs($item['currency']), 0),
                            'result_cod' => $item['cod'],
                            'provider_id' => $item['providerperson'],
                            'site' => 'private_person',
                        );

                        }
                    }
                    if(!empty($insertResults)){
                    Yii::app()->db->schema->commandBuilder->createMultipleInsertCommand('results', $insertResults)->execute();
                    }
                }
                if (!empty($results_2) || !empty($products) || !empty($intercars_products)) {
                    $query = $_GET['query'];
                    Yii::app()->db->createCommand()->insert('activity', array(
                        'user_id' => Yii::app()->user->id,
                        'date' => date('Y-m-d H:i:s', time()),
                        'search' => $query,
                        'status' => 1
                    ));
                }
                if (empty($results_2) && empty($products) && empty($intercars_products)) {
                    $query = $_GET['query'];
                    Yii::app()->db->createCommand()->insert('activity', array(
                        'user_id' => Yii::app()->user->id,
                        'date' => date('Y-m-d H:i:s', time()),
                        'search' => $query,
                        'status' => 0
                    ));
                }
            }
        }
        $empty = Results::model()->findAll();

        $this->render('index', array(
            'parsed_site1' => $parsed_site1,
            'exchange_rates' => $exchange_rates,
            'advance' => $advance,
            'results_2' => $results_2,
            'model_2' => $model_2,
            'flag' => $flag,
            'opol_results' => $products,
            'intercars_products' => $intercars_products,
            'query' => $query,
            'empty' => $empty,
            'data_worked' => $data_worked,
            'date' => $date,
            'calendarItems' => MainHelper::initCalendar()
        ));
    }

    public function actionInfo()
    {
        Yii::import('ext.CurlAll.CurlAll');
        include('protected/vendors/phpQuery/phpQuery/phpQuery.php');
        $exchange_rates = ExchangeRates::model()->findByPk(1);
        $siteinfo = Infosite::model()->findAll();
        $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => 1, 'user_id' => Yii::app()->user->id));
        $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => 2, 'user_id' => Yii::app()->user->id));
        $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => 5, 'user_id' => Yii::app()->user->id));
        $parsed_site4 = Coefficients::model()->findByAttributes(array('site_name' => 4, 'user_id' => Yii::app()->user->id));
        $parsed_site5 = Coefficients::model()->findByAttributes(array('site_name' => 3, 'user_id' => Yii::app()->user->id));
        $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => 6, 'user_id' => Yii::app()->user->id));
        $get_html = new  CurlAll();
        $data_activity = date('H:i', time());
        $data_worked = Data_worked::model()->findByPk(1);
        $date = time();
        $details = $_GET['result_info'];
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
            'params' => array('ordered' => date('Y-m-d', time())),
        )));


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
        } elseif ($_GET['site'] == 'private_person') {
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
        } elseif ($_GET['site'] == 'http://www.diesel-czesci.pl/') {
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
        } elseif ($_GET['site'] == 'https://sklep.autos.com.pl/') {

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
                'def_price' => $_GET['def_price'],
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

    public function actionRegistration()
    {
        $countries = new Country();
        $countries = $countries->getCountries();
        $model = new Users;
        $model->scenario = 'register';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate() && $model->save())
                Yii::app()->user->setFlash('registration', 'Реєстрація пройшла успішно. Очікуйте підтвердження адміністратором.');
            $this->redirect(array('registration', 'id' => $model->id));
        }

        $this->render('registration', array(
            'model' => $model,
            'countries' => $countries
        ));
    }

    public function actionIndex_payment($id)
    {
        Yii::app()->session['session_info'] = 1;

        $model = Results::model()->findAll();
        $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => 'http://sklep.martextruck.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => 'http://webcatalog.opoltrans.com.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => 'http://www.intercars.com.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site4 = Coefficients::model()->findByAttributes(array('site_name' => 'http://sklep.skuba.com.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => 'https://sklep.autos.com.pl/', 'user_id' => Yii::app()->user->id));
        $exchange_rates = ExchangeRates::model()->findByPk(1);

        foreach ($model as $items) {

            if ($items->site == 'http://sklep.martextruck.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site1->logistic * $parsed_site1->manager_coef * $parsed_site1->curator_coef * $parsed_site1->admin_coef * ($exchange_rates->zloty))), 0);
            };
            if ($items->site == 'http://webcatalog.opoltrans.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site2->logistic * $parsed_site2->manager_coef * $parsed_site2->curator_coef * $parsed_site2->admin_coef * ($exchange_rates->zloty))), 0);
            };
            if ($items->site == 'http://www.intercars.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site3->logistic * $parsed_site3->manager_coef * $parsed_site3->curator_coef * $parsed_site3->admin_coef * ($exchange_rates->zloty))), 0);
            };
            if ($items->site == 'http://sklep.skuba.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site4->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty))), 0);
            };
            if ($items->site == 'https://sklep.autos.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site6->logistic * $parsed_site6->manager_coef * $parsed_site6->curator_coef * $parsed_site6->admin_coef * ($exchange_rates->zloty))), 0);
            };
        }

        $this->redirect('/?query=' . $id);
    }

    public function actionIndex_payment_2($id)
    {
        Yii::app()->session['session_info'] = 0;
        $model = Results::model()->findAll();
        $parsed_site1 = Coefficients::model()->findByAttributes(array('site_name' => 'http://sklep.martextruck.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site2 = Coefficients::model()->findByAttributes(array('site_name' => 'http://webcatalog.opoltrans.com.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site3 = Coefficients::model()->findByAttributes(array('site_name' => 'http://www.intercars.com.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site4 = Coefficients::model()->findByAttributes(array('site_name' => 'http://sklep.skuba.com.pl/', 'user_id' => Yii::app()->user->id));
        $parsed_site6 = Coefficients::model()->findByAttributes(array('site_name' => 'https://sklep.autos.com.pl/', 'user_id' => Yii::app()->user->id));
        $exchange_rates = ExchangeRates::model()->findByPk(1);

        foreach ($model as $items) {

            if ($items->site == 'http://sklep.martextruck.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site1->logistic * $parsed_site1->manager_coef * $parsed_site1->curator_coef * $parsed_site1->admin_coef * ($exchange_rates->zloty + ($exchange_rates->zloty * $exchange_rates->zloty_repair / 100)))), 0);

            };
            if ($items->site == 'http://webcatalog.opoltrans.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site2->logistic * $parsed_site2->manager_coef * $parsed_site2->curator_coef * $parsed_site2->admin_coef * ($exchange_rates->zloty + ($exchange_rates->zloty * $exchange_rates->zloty_repair / 100)))), 0);
            };
            if ($items->site == 'http://www.intercars.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site3->logistic * $parsed_site3->manager_coef * $parsed_site3->curator_coef * $parsed_site3->admin_coef * ($exchange_rates->zloty + ($exchange_rates->zloty * $exchange_rates->zloty_repair / 100)))), 0);
            };
            if ($items->site == 'http://sklep.skuba.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site4->logistic * $parsed_site4->manager_coef * $parsed_site4->curator_coef * $parsed_site4->admin_coef * ($exchange_rates->zloty + ($exchange_rates->zloty * $exchange_rates->zloty_repair / 100)))), 0);
            };
            if ($items->site == 'https://sklep.autos.com.pl/') {
                $result = Results::model()->updateByPk($items->id, array('result_price' => round(($items->def_price) * $parsed_site6->logistic * $parsed_site6->manager_coef * $parsed_site6->curator_coef * $parsed_site6->admin_coef * ($exchange_rates->zloty+ ($exchange_rates->zloty * $exchange_rates->zloty_repair / 100)))), 0);
            };
        }

        $this->redirect('/?query=' . $id);
    }

    public function actionRegion()
    {
        $regions = new Region();
        $regions = $regions->getRegions($_POST['country_id']);
        echo json_encode($regions);
    }

    public function actionCity()
    {
        $cities = new City();
        $cities = $cities->getCities($_POST['region_id']);
        echo json_encode($cities);
    }

    public function actionRecovery()
    {
        if (Yii::app()->request->getPost('email')) {
            $user = Users::model()->findByAttributes(array('email' => Yii::app()->request->getPost('email')));
            if ($user) {
                $password = MainHelper::generatePassword(7);
                Users::model()->updateByPk($user->id, array('password' => md5($password)));
                $to = Yii::app()->request->getPost('email');
                $subject = 'Відновлення паролю на сайті ' . Yii::app()->request->hostInfo;
                $message = 'Ваш пароль: <strong>' . $password . '</strong>';
                mail($to, $subject, $message);
                Yii::app()->user->setFlash('recovery', 'На вказаний email відправлено новий пароль');
            } else Yii::app()->user->setFlash('error', 'Не знайдено вказаний email');
        }
        $this->render('recovery');
    }


    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionConfirm()
    {
        if (Yii::app()->request->getPost('phone', '')) {
            $code = MainHelper::generateConfirmCode(4);
            Yii::app()->session['confirm_code'] = $code;
            $phone = str_replace('(', '', Yii::app()->request->getPost('phone'));
            $phone = str_replace(')', '', $phone);
            $phone = str_replace('+', '', $phone);
            $phone = str_replace(' ', '', $phone);
            $phone = substr($phone, 2, strlen($phone));

            $url = 'https://gate.smsclub.mobi/http/httpsendsms.php?';
            $username = '380982919965';    // string User ID (phone number)
            $password = '142536789';        // string Password
            $from = 'lcp.com.ua';        // string, sender id (alpha-name) (as long as your alpha-name is not spelled out, it is necessary to use it)
            $to = $phone;
            $text = 'Код підтвердження реєстрації на сайті ' . Yii::app()->request->hostInfo . ' : ' . Yii::app()->session['confirm_code'];    // string Message
            $url_result = $url . 'username=' . $username . '&password=' . $password . '&from=' . urlencode($from) . '&to=' . $to . '&text=' . base64_encode(iconv("UTF-8", "windows-1251", $text));

            if ($curl = curl_init()) {
                curl_setopt($curl, CURLOPT_URL, $url_result);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($curl);
                curl_close($curl);

                echo json_encode(array('status' => 1, 'code' => Yii::app()->session['confirm_code']));
            }
        } else {
            echo json_encode(array('status' => 0));
        }
    }

    public function actionCheck()
    {
        if (Yii::app()->request->getPost('code', '')) {
            if (Yii::app()->session['confirm_code'] == Yii::app()->request->getPost('code')) {
                echo json_encode(array('status' => 1));
            } else {
                echo json_encode(array('status' => 0));
            }
        } else {
            echo json_encode(array('status' => 0));
        }
    }


}
