<?php

class CabinetController extends Controller
{
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('error', 'login', 'logout'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('print', 'arrears', 'deleteOrder', 'declarations', 'editOrders', 'index', 'orders', 'editOrder', 'suborders', 'suborders_2', 'sale_offer', 'sendedOrders'),
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

    public function actionArrears()
    {
        $model = new Messages;
        if (isset($_POST['Messages'])) {
            $model->attributes = $_POST['Messages'];

            if ($model->validate() && $model->save()) {
                Yii::app()->user->setFlash('arrears', 'Повідомлення надіслане.');
                $this->redirect(array('arrears', 'model' => $model->id));
            }
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . Yii::app()->user->id);
        $criteria->order = 'date DESC';
        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $from_date = '"' . date('Y-m-d', strtotime(str_replace('.', '-', Yii::app()->request->getQuery('from_date')))) . '"';
            $criteria->addCondition('date>=' . $from_date);
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $to_date = '"' . date('Y-m-d', strtotime(str_replace('.', '-', Yii::app()->request->getQuery('to_date')))) . '"';
            $criteria->addCondition('date<=' . $to_date);
        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $from_date = date('Y-m-d', strtotime(str_replace('.', '-', Yii::app()->request->getQuery('from_date'))));
            $to_date = date('Y-m-d', strtotime(str_replace('.', '-', Yii::app()->request->getQuery('to_date'))));
            $criteria->addBetweenCondition('date', $from_date, $to_date);
        }
        if (!Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $to_date = date('Y-m-d', time());
            $from_date = date('Y-m-d', strtotime("-30 days"));
            $criteria->addBetweenCondition('date', $from_date, $to_date);

        }
        $model_2 = new Payments();
        $criteria_2 = new CDbCriteria();
        $criteria_2->addCondition('user_id=' . Yii::app()->user->id);
        $criteria_2->order = 'date DESC';
        $pay = Payments::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        if (Yii::app()->request->getQuery('from_date_2') && !Yii::app()->request->getQuery('to_date_2')) {
            $from_date = Yii::app()->request->getQuery('from_date_2');
            $from_date = str_replace('.', '-', $from_date);
            $from_date_2 = date('Y-m-d', strtotime($from_date));
            $from_date = '"' . date('Y-m-d', strtotime($from_date)) . '"';
            $criteria_2->addCondition('date>=' . $from_date);
            $pay = Payments::model()->findAll('user_id=:user_id AND date>=:date', array('user_id' => Yii::app()->user->id, 'date' => $from_date_2));
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date_2')) {

            $to_date = Yii::app()->request->getQuery('to_date_2');
            $to_date = str_replace('.', '-', $to_date);
            $to_date_2 = date('Y-m-d', strtotime($to_date));
            $to_date = '"' . date('Y-m-d', strtotime($to_date)) . '"';
            $criteria_2->addCondition('date<=' . $to_date);
            $pay = Payments::model()->findAll('user_id=:user_id AND date<=:date', array('user_id' => Yii::app()->user->id, 'date' => $to_date_2));

        }
        if (Yii::app()->request->getQuery('to_date_2') && Yii::app()->request->getQuery('from_date_2')) {
            $from_date = Yii::app()->request->getQuery('from_date_2');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = Yii::app()->request->getQuery('to_date_2');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            $criteria_2->addBetweenCondition('date', $from_date, $to_date);
            $pay = Payments::model()->findAll('user_id=:user_id AND (date>=:from_date AND date<=:to_date)', array('user_id' => Yii::app()->user->id, 'from_date' => $from_date, 'to_date' => $to_date));
        }
        if (!Yii::app()->request->getQuery('to_date_2') && !Yii::app()->request->getQuery('from_date_2')) {
            $criteria_2->addCondition('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())');
            $pay = Payments::model()->findAll('user_id=:user_id AND MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())', array('user_id' => Yii::app()->user->id));
        }
        $dataProvider = new CActiveDataProvider('Payments',
            array(
                'criteria' => $criteria_2,
                'pagination' => false
            ));
        $suma_buy = 0;
        $suma_opl = 0;
        if (!empty($pay)) {
            foreach ($pay as $pays) {
                if ($pays['status'] == 1) {
                    $suma_buy += Orders::model()->getUserSumByDateLogistic($pays['user_id'], $pays['date'], 1, 1)['price_out_sum'];
                }
                if ($pays['status'] == 0) {
                    $suma_opl += $pays['summa'];
                }
            }
        }

        $invoices = new CActiveDataProvider('Invoices', array(
            'criteria' => $criteria,
            'pagination' => false
        ));
        $sum = Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0);
        $sum_work = Orders::model()->getUserSum_2(Yii::app()->user->id, 1, 0);
        $orders_sum = Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, date('Y-m-d', time()), 0, 0)['price_out_sum'];
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . Yii::app()->user->id);
        $criteria->addCondition('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())');
        $dataProvider_2 = new CActiveDataProvider('Messages',
            array(
                'criteria' => $criteria,
                'pagination' => false
            ));
        $this->render('arrears', array(
            'model' => $model,
            'sum' => $sum,
            'sum_work' => $sum_work,
            'invoices' => $invoices,
            'orders_sum' => $orders_sum,
            'arrears' => $suma_buy - $suma_opl,
            'dataProvider' => $dataProvider,
            'suma_opl' => $suma_opl,
            'suma_buy' => $suma_buy,
            'dataProvider_2' => $dataProvider_2
        ));
    }

    public function actionDeclarations()
    {
        $command = Yii::app()->db->createCommand();
        $command->update('declarations', array(
            'status' => '1',
        ), 'user_id=:user_id', array(':user_id' => Yii::app()->user->id));

        $model = new Declarations();
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . Yii::app()->user->id);
        $criteria->order = 'date DESC';
        $declarations = new CActiveDataProvider('Declarations', array(
            'criteria' => $criteria,
            'pagination' => false
        ));
        $this->render('declarations', array(
            'model' => $model,
            'declarations' => $declarations));
    }

    public function actionIndex()
    {
        $countries = new Country();
        $countries = $countries->getCountries();

        $model = Users::model()->findByPk(Yii::app()->user->id);
        $regions = Region::model()->findAllByAttributes(array('country_id' => $model->country));
        $regions = CHtml::listData($regions, 'region_id', 'name');

        $cities = City::model()->findAllByAttributes(array('region_id' => $model->region));
        $cities = CHtml::listData($cities, 'city_id', 'name');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if (isset($_POST['Users']['old_password']) && (isset($_POST['Users']['new_password'])) && ($_POST['Users']['old_password'] != '') && ($_POST['Users']['new_password'] != '')) {
                if (md5($_POST['Users']['old_password']) == ($model->password)) {
                    if ($model->validate() && $model->save() && $model->updateByPk(Yii::app()->user->id, array('password' => md5($_POST['Users']['new_password'])))) {

                        Yii::app()->user->setFlash('index', 'Зміни збережено');
                    }
                } else Yii::app()->user->setFlash('error', 'Старий пароль невірний!');
            } elseif ($model->validate() && $model->save()) {
                Yii::app()->user->setFlash('index', 'Зміни збережено');
            }
            $this->redirect(array('index', 'id' => $model->id));
        }

        $this->render('index', array(
            'model' => $model,
            'countries' => $countries,
            'regions' => $regions,
            'cities' => $cities,
        ));
    }

    public function actionSale_offer()
    {
        $model = new Results_add();

        $model_2 = new Numbers_add();

        if (isset($_POST['Results_add'])) {

            if (CUploadedFile::getInstance($model, 'image')) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $model->photo = '/photos/' . $model->image->getName();
            } else {
                $model->photo = '/photos/ArticleImage.jpg';
            }

            $model->attributes = $_POST['Results_add'];

            if ($model->validate() && $model->save()) {
                if ($model->image) {
                    $path = Yii::getPathOfAlias('webroot') . '/photos/' . $model->image->getName();
                    $model->image->saveAs($path);
                }

                Yii::app()->user->setFlash('sale_offer', 'Зміни збережено.');

                $this->redirect(array('sale_offer'));
            }
        }


        $this->render('sale_offer', array(
            'model' => $model,
            'model_2' => $model_2
        ));


    }
    public function actionEditOrders($id){

        $model = Orders::model()->findByPk($id);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            if ($model->save()) {
                $this->redirect('/cabinet/orders');
            }
        }

        $this->render('editorders',array(
            'model'=>$model,
        )
        );
    }
    public function actionOrders()
    {
        $model = $this->loadModel(Yii::app()->user->id);

        $todayOrdersDates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => '((t.ordered=:not_ordered AND t.send=:not_send) OR (t.ordered=:ordered AND t.send=:send)) AND t.completion=:completion AND user_id=:user_id AND date=:date',
            'params' => array('not_ordered' => 0, 'not_send' => 0, 'ordered' => 1, 'send' => 0, 'completion' => 0, 'user_id' => Yii::app()->user->id, 'date' => date('Y-m-d', time())),

        ));

        foreach ($todayOrdersDates as $date) {
            $items = Orders::model()->findAll(array(
                'condition' => 't.date=:date AND t.user_id=:user_id AND t.completion=:completion AND ((t.ordered=:not_ordered AND t.send=:not_send) OR (t.ordered=:ordered AND t.send=:send))',
                'params' => array(
                    'date' => $date->date,
                    'user_id' => Yii::app()->user->id,
                    'not_ordered' => 0,
                    'not_send' => 0,
                    'ordered' => 1,
                    'send' => 0,
                    'completion' => 0
                )
            ));

            $todayOrders[$date->date] = new CArrayDataProvider($items, array(
                'sort' => array(
                    'attributes' => array(
                        'name',
                        'manufacturer',
                        'quantity',
                        'price_out',
                        'price_out_sum',
                        'cod'
                    )
                ),
                'pagination' => false,
            ));
        }

        $dates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 't.ordered=:ordered AND t.send=:send AND t.completion=:completion AND user_id=:user_id',
            'params' => array('ordered' => 0, 'send' => 0, 'user_id' => Yii::app()->user->id, 'completion' => 1),

        ));
        foreach ($dates as $date) {
            $items = Orders::model()->findAll(array(
                'condition' => 't.ordered=:ordered AND t.send=:send AND t.completion=:completion AND user_id=:user_id AND date=:date',
                'params' => array(
                    'date' => $date->date,
                    'user_id' => Yii::app()->user->id,
                    'ordered' => 0,
                    'send' => 0,
                    'completion' => 1
                )
            ));

            $orders_3[$date->date] = new CArrayDataProvider($items, array(
                'sort' => array(
                    'attributes' => array(
                        'name',
                        'manufacturer',
                        'quantity',
                        'price_out',
                        'price_out_sum',
                        'cod'
                    )
                ),
                'pagination' => false,
            ));
        }


        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . Yii::app()->user->id);
        $criteria->order = 'date DESC';

        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $from_date = Yii::app()->request->getQuery('from_date');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = '"' . date('Y-m-d', strtotime($from_date)) . '"';
            $criteria->addCondition('date>=' . $from_date);
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $to_date = Yii::app()->request->getQuery('to_date');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = '"' . date('Y-m-d', strtotime($to_date)) . '"';
            $criteria->addCondition('date<=' . $to_date);
        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $from_date = Yii::app()->request->getQuery('from_date');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = Yii::app()->request->getQuery('to_date');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            $criteria->addBetweenCondition('date', $from_date, $to_date);
        }
        if (!Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $criteria->addCondition('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())');
        }
        $invoices = new CActiveDataProvider('Invoices', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));

        $results_2 = array();
        $date_2 = date('Y-m-d', time());
        $from_date = date('Y-m-d', strtotime("-30 days"));
        $dates_2 = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 'MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW()) AND user_id=:user_id',
            'params' => array('user_id' => Yii::app()->user->id)
        ));

        if (Yii::app()->request->getQuery('from_date_2') && !Yii::app()->request->getQuery('to_date_2')) {
            $from_date = Yii::app()->request->getQuery('from_date_2');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $dates_2 = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date AND user_id=:user_id',
                'params' => array('from_date' => $from_date, 'user_id' => Yii::app()->user->id)
            ));
        }
        if (Yii::app()->request->getQuery('to_date_2') && !Yii::app()->request->getQuery('from_date_2')) {
            $to_date = Yii::app()->request->getQuery('to_date_2');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));

            $dates_2 = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date<=:to_date AND user_id=:user_id',
                'params' => array('to_date' => $to_date, 'user_id' => Yii::app()->user->id)
            ));
        }
        if (Yii::app()->request->getQuery('to_date_2') && Yii::app()->request->getQuery('from_date_2')) {
            $from_date = Yii::app()->request->getQuery('from_date_2');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = Yii::app()->request->getQuery('to_date_2');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));

            $dates_2 = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date and t.date<=:to_date AND user_id=:user_id',
                'params' => array('to_date' => $to_date, 'from_date' => $from_date, 'user_id' => Yii::app()->user->id)
            ));
        }

        $datesHistory = new CArrayDataProvider($dates_2, array(
            'keyField' => 'date',
            'pagination' => false
        ));

        $sum = Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0);
        $sum_work = Orders::model()->getUserSum_2(Yii::app()->user->id, 1, 0);
        $this->render('orders', array(
                'sum' => $sum,
                'sum_work' => $sum_work,
                'orders_3' => $orders_3,
                'invoices' => $invoices,
                'model' => $model,
                'orders_2' =>$results_2,
                'datesHistory' => $datesHistory,
                'todayOrders' => $todayOrders
            )
        );
    }

    public function actionEditOrder()
    {
        if (Yii::app()->request->isAjaxRequest) {

            Yii::import('ext.editable.EditableSaver'); //or you can add import 'ext.editable.*' to config
            $es = new EditableSaver('Orders');
            $es->onBeforeUpdate = function ($event) {
                $order = Orders::model()->findByPk(Yii::app()->request->getPost('pk'));
                $event->sender->setAttribute('price_out_sum', Yii::app()->request->getPost('value') * $order->price_out);
            };
            $es->update();

        }
    }


    public function actionSuborders_2()
    {
        if (Yii::app()->request->getQuery('id')) {
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $payment = Payments::model()->findByPk(Yii::app()->request->getQuery('id'));
            if ($payment['status'] == 1) {
                $invoice = Invoices::model()->findByAttributes(array('date' => $payment['date']));
                $criteria = new CDbCriteria();
                $criteria->addCondition('user_id=' . Yii::app()->user->id);
                $criteria->addCondition('ordered=1');
                $criteria->addCondition('send=1');
                $criteria->addCondition('date_logistic="' . $payment['date'] . '"');

                $orders = new CActiveDataProvider('Orders', array(
                    'criteria' => $criteria,
                    'pagination' => false
                ));
                $render = array('orders' => $orders, 'invoice' => $payment, 'user' => $user);
            } else {
                $render = array('message' => 'Для операції оплати список замовлень недоступний');
            }
            $this->renderPartial('_suborders_2', $render);
        }

    }
    public function actionPrint($id)
    {

        $this->layout = 'print';
        $user = Users::model()->findByPk(Yii::app()->user->id);
        $invoice = Invoices::model()->findByPk($id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . Yii::app()->user->id);
        $criteria->addCondition('ordered=1');
        $criteria->addCondition('send=1');
        $criteria->addCondition('date_logistic="' . $invoice['date'] . '"');

        $orders = new CActiveDataProvider('Orders', array(
            'criteria' => $criteria,
            'pagination' => false
        ));
        $this->render('_print', array('orders' => $orders, 'invoice' => $invoice, 'user' => $user));
    }
    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Дані не знайдені');
        return $model;
    }

    public function actionDeleteOrder($id)
    {
        Orders::model()->deleteByPk($id);
        return $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionSuborders()
    {
        if (Yii::app()->request->getQuery('id')) {
            if (strpos(Yii::app()->request->getQuery('id'), '-')) {
                $datesCriteria = new CDbCriteria();
                $datesCriteria->addCondition('user_id=' . Yii::app()->user->id . ' AND date="' . Yii::app()->request->getQuery('id') . '"AND quantity>0');
                $orders = new CActiveDataProvider('Orders', array(
                    'criteria' => $datesCriteria,
                    'pagination' => false
                ));
                $this->renderPartial('_sendedOrders', array('orders' => $orders, 'date' => Yii::app()->request->getQuery('id')));
            } else {
                $user = Users::model()->findByPk(Yii::app()->user->id);
                $invoice = Invoices::model()->findByPk(Yii::app()->request->getQuery('id'));
                $criteria = new CDbCriteria();
                $criteria->addCondition('user_id=' . Yii::app()->user->id);
                $criteria->addCondition('ordered=1');
                $criteria->addCondition('send=1');
                $criteria->addCondition('date_logistic="' . $invoice['date'] . '"');
                $criteria->addCondition('quantity>0');

                $orders = new CActiveDataProvider('Orders', array(
                    'criteria' => $criteria,
                    'pagination' => false
                ));
                $this->renderPartial('_suborders', array('orders' => $orders, 'invoice' => $invoice, 'user' => $user));
            }
        }
    }
}