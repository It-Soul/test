<?php

class UsersController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//admin/layouts/column1';
    public $user_id;

    /**
     * @return array action filters
     */

    public function actions()
    {
        return array(
            'toggle' => array(
                'class' => 'yiiwheels.widgets.grid.actions.WhToggleAction',
                'modelName' => 'Coefficients',
            ),
            'toggle_provider' => array(
                'class' => 'yiiwheels.widgets.grid.actions.WhToggleAction',
                'modelName' => 'ProviderPerson',
            ),
            'toggle_countrycof' => array(
                'class' => 'yiiwheels.widgets.grid.actions.WhToggleAction',
                'modelName' => 'CountryCoef',
            )

        );
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'userCart', 'toggle_provider', 'editprovider', 'coefficients', 'editCoefficients', 'editCountryCoef', 'countryCoef','orders', 'order', 'declarations', 'deleteUser', 'toggle', 'updateDeclaration', 'getManagers', 'deleteDeclaration', 'debit', 'suborders', 'suborders_2', 'registerUser', 'region', 'city', 'provider_person', 'toggle_countrycof'),
                'users' => array('@'),
                'roles' => array('administrator')
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'roles' => array('administrator'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Display user debit analyze
     * @param $id
     */
    public function actionDebit($id)
    {
        $model = new Payments();
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $id);
        $criteria->order = 'date DESC';
        $invoices = new CActiveDataProvider('Invoices', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $criteria_payments = new CDbCriteria();
        $criteria_payments->addCondition('user_id=' . $id);
        $criteria_payments->order = 'date DESC';
        $payments = new CActiveDataProvider('Payments', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        if (isset($_POST['Payments'])) {
            $model->attributes = $_POST['Payments'];
            $model->status = 0;
            if ($model->save()) {
                $this->redirect('/admin/users/debit?id=' . $id);
            }
        }

        $arrears = Orders::model()->getUserArrears($id);
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $id);

        $pay = Payments::model()->findAllByAttributes(array('user_id' => $id));

        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $criteriaFromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date'), true);
            $queryFromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date'));
            $criteria->addCondition('date>=' . $criteriaFromDate);
            $pay = Payments::model()->findAll('user_id=:user_id AND date>=:date', array(
                'user_id' => $id,
                'date' => $queryFromDate
            ));
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $criteriaToDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date'), true);
            $queryToDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date'));
            $criteria->addCondition('date<=' . $criteriaToDate);
            $pay = Payments::model()->findAll('user_id=:user_id AND date<=:date', array(
                'user_id' => $id,
                'date' => $queryToDate
            ));
        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date'));
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date'));
            $criteria->addBetweenCondition('date', $fromDate, $toDate);
            $pay = Payments::model()->findAll('user_id=:user_id AND (date>=:from_date AND date<=:to_date)', array(
                'user_id' => $id,
                'from_date' => $fromDate,
                'to_date' => $toDate
            ));
        }
        if (!Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $criteria->addCondition('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())');
            $pay = Payments::model()->findAll('user_id=:user_id AND MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())', array('user_id' => $id));
        }

        $criteria->order = 'date';
        $dataProvider = new CActiveDataProvider('Payments',
            array(
                'criteria' => $criteria,
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

        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $id);
        $dataProvider_2 = new CActiveDataProvider('Messages',
            array(
                'criteria' => $criteria,
                'pagination' => false
            ));


        $this->render('debit', array(
            'model' => $model,
            'user_id' => $id,
            'invoices' => $invoices,
            'payments' => $payments,
            'dataProvider' => $dataProvider,
            'dataProvider_2' => $dataProvider_2,
            'arrears' => $arrears,
            'suma_opl' => $suma_opl,
            'suma_buy' => $suma_buy,
            'user' => Users::model()->findByAttributes(array('id' => $id))
        ));


    }

    public function actionCreate()
    {
        $model = new Users;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Display ans update user information
     * @param $id
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $countries = new Country();
        $countries = $countries->getAdminCountries();
        $regions = Region::model()->findAllByAttributes(array('country_id' => $model->country));
        $regions = CHtml::listData($regions, 'region_id', 'name');

        $cities = City::model()->findAllByAttributes(array('region_id' => $model->region));
        $cities = CHtml::listData($cities, 'city_id', 'name');

        $managers = CHtml::listData(self::actionGetManagers($model->curator), 'id', 'name');

        $lastOrder = Orders::model()->getUserSumByDate($id, date('Y-m-d', time()));
        $arrears = Orders::model()->getUserArrears($id);
        $lastPayment = Payments::model()->findAllByAttributes(array('user_id' => $id), array('order' => 'date DESC', 'limit' => 1));

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Дані збережено");
                $this->redirect(array('update', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', "Дані не збережено");
            }
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $id);
        $criteria->order = 'date DESC';

        if (Yii::app()->request->getPost('from_date') && !Yii::app()->request->getPost('to_date')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('from_date'), true);
            $criteria->addCondition('date>=' . $fromDate);
        }
        if (Yii::app()->request->getPost('to_date') && !Yii::app()->request->getPost('from_date')) {
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('to_date'), true);
            $criteria->addCondition('date<=' . $toDate);
        }
        if (Yii::app()->request->getPost('to_date') && Yii::app()->request->getPost('from_date')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('from_date'));
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('to_date'));
            $criteria->addBetweenCondition('date', $fromDate, $toDate);
        }

        $activity = new CActiveDataProvider('Activity', array(
            'criteria' => $criteria,
            'pagination' => false
        ));
        $day_activity = Activity::model()->findAll('user_id=:user_id AND (date>=:day_start AND date <=:day_finish)', array(
            'user_id' => $id,
            'day_start' => date('Y-m-d H:i', mktime(0, 0, 0)),
            'day_finish' => date('Y-m-d H:i', mktime(23, 59, 0))
        ));
        $count = count($day_activity);

        if (Yii::app()->request->getPost('to_date') || Yii::app()->request->getPost('from_date')) {
            $count = $activity->getTotalItemCount();
        }

        $this->render('update', array(
            'model' => $model,
            'regions' => $regions,
            'cities' => $cities,
            'countries' => $countries,
            'activity' => $activity,
            'count' => $count,
            'lastOrder' => $lastOrder,
            'managers' => $managers,
            'arrears' => $arrears,
            'lastpayment' => $lastPayment
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(array('index'));
    }

    /**
     * Delete user
     * @param $id
     */
    public function actionDeleteUser($id)
    {
        $this->loadModel($id)->delete();

        $this->redirect(array('/admin/users'));
    }

    /**
     * Delete declaration
     * @param $id
     * @param $user_id
     */
    public function actionDeleteDeclaration($id, $user_id)
    {
        Declarations::model()->findByPk($id)->delete();

        $this->redirect(array('declarations', 'id' => $user_id));
    }

    /**
     * Display site coefficients for the user
     * @param $id
     */
    public function actionCoefficients($id)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'user_id=' . $id,
            'with' => array('names')
        ));

        $model = new CActiveDataProvider('Coefficients', array(
            'criteria' => $criteria,
        ));

        $this->render('coefficients', array(
            'model' => $model,
            'user_id' => $id
        ));
    }

/*
 *
 *
 */
    public function actionCountryCoef($id)
    {
        $cof = new CDbCriteria(array(
            'condition' => 'user_id=' . $id,
            'with' => array('country')
        ));

        $model = new CActiveDataProvider('CountryCoef', array(
            'criteria' => $cof,
        ));

        $this->render('countrycoef', array(
            'model' => $model,
            'user_id' => $id
        ));
    }

    /**
     * Update site coefficient for the user
     */
    public function actionEditCoefficients()
    {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('ext.editable.EditableSaver'); //or you can add import 'ext.editable.*' to config
            $es = new EditableSaver('Coefficients');  // 'User' is classname of model to be updated
            $es->update();
        }
    }

    public function actionEditCountryCoef()
    {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('ext.editable.EditableSaver'); //or you can add import 'ext.editable.*' to config
            $es = new EditableSaver('CountryCoef');  // 'User' is classname of model to be updated
            $es->update();
        }
    }

    /**
     * Display list of declarations
     * @param $id
     */
    public function actionDeclarations($id)
    {
        $model = new Declarations();
        $criteria = new CDbCriteria();

        $criteria->addCondition('user_id=' . $id);

        if (Yii::app()->request->getPost('from_date') && !Yii::app()->request->getPost('to_date')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('from_date'), true);
            $criteria->addCondition('date>=' . $fromDate);
        }
        if (Yii::app()->request->getPost('to_date') && !Yii::app()->request->getPost('from_date')) {
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('to_date'), true);
            $criteria->addCondition('date<=' . $toDate);
        }
        if (Yii::app()->request->getPost('to_date') && Yii::app()->request->getPost('from_date')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('from_date'));
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getPost('to_date'));
            $criteria->addBetweenCondition('date', $fromDate, $toDate);
        }
        if (!Yii::app()->request->getPost('to_date') && !Yii::app()->request->getPost('from_date')) {
            $criteria->addCondition('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())');
        }

        $criteria->order = 'date DESC';

        if (isset($_POST['declarations'])) {
            $model->attributes = $_POST['declarations'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Дані збережено");
            }

            $this->redirect(array('/admin/users/declarations', 'id' => $id));
        }

        $declarations = new CActiveDataProvider('Declarations', array(
            'criteria' => $criteria,
            'pagination' => false
        ));
        $this->render('declarations', array(
            'model' => $model,
            'declarations' => $declarations,
            'user_id' => $id,
        ));
    }

    /**
     * Display list of orders for user
     * @param $id
     */
    public function actionOrders($id)
    {
        $this->user_id = $id;
        $model = $this->loadModel($id);

        $results = array();

        $date = date('Y-m-d', time());

        $dates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 't.date=:date AND t.user_id=:user_id AND t.completion=:completion AND ((t.ordered=:not_ordered AND t.send=:not_send) OR (t.ordered=:ordered AND t.send=:send))',

            'params' => array(
                'date' => $date,
                'user_id' => $id,
                'not_ordered' => 0,
                'not_send' => 0,
                'ordered' => 1,
                'send' => 0,
                'completion' => 0
            )
        ));

        foreach ($dates as $date) {
            $items = Orders::model()->findAll(array(
                    'condition' => 't.date=:date AND t.user_id=:user_id AND t.completion=:completion AND ((t.ordered=:not_ordered AND t.send=:not_send) OR (t.ordered=:ordered AND t.send=:send))',
                    'params' => array(
                        'date' => $date->date,
                        'user_id' => $id,
                        'not_ordered' => 0,
                        'not_send' => 0,
                        'ordered' => 1,
                        'send' => 0,
                        'completion' => 0
                    )
                )
            );

            $results[$date->date] = new CArrayDataProvider($items, array(
                'sort' => array(
                    'attributes' => array(
                        'provider',
                        'name',
                        'cod',
                        'manufacturer',
                        'quantity',
                        'price_in',
                        'price_in_sum',
                        'vat',
                        'price_out',
                        'price_out_sum',
                        'com_course',
                        'logistic_pln',
                        'logistic_grn',
                        'com_grn',
                        'logist_pln',
                        'manager',
                        'courier',
                        'admin',
                        'course'
                    )
                ),
                'pagination' => false,
            ));
        }
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $id);
        $criteria->order = 'date DESC';

        if (Yii::app()->request->getQuery('from_date_3') && !Yii::app()->request->getQuery('to_date_3')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date_3'), true);
            $criteria->addCondition('date>=' . $fromDate);
        }
        if (Yii::app()->request->getQuery('to_date_3') && !Yii::app()->request->getQuery('from_date_3')) {
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date_3'), true);
            $criteria->addCondition('date<=' . $toDate);
        }
        if (Yii::app()->request->getQuery('to_date_3') && Yii::app()->request->getQuery('from_date_3')) {
            $fromDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date_3'));
            $toDate = DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date_3'));
            $criteria->addBetweenCondition('date', $fromDate, $toDate);
        }

        if (!Yii::app()->request->getQuery('from_date_3') && !Yii::app()->request->getQuery('to_date_3')) {
            $criteria->addCondition('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())');
        }

        $invoices = new CActiveDataProvider('Invoices', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $dates_2 = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => '(MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())) AND user_id=:user_id',
            'params' => array('user_id' => $id)
        ));

        if (Yii::app()->request->getQuery('from_date_2') && !Yii::app()->request->getQuery('to_date_2')) {
            $dates_2 = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date AND user_id=:user_id',
                'params' => array(
                    'from_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date_2')),
                    'user_id' => $id
                )
            ));
        }
        if (Yii::app()->request->getQuery('to_date_2') && !Yii::app()->request->getQuery('from_date_2')) {
            $dates_2 = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date<=:to_date AND user_id=:user_id',
                'params' => array(
                    'to_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date_2')),
                    'user_id' => $id
                )
            ));
        }
        if (Yii::app()->request->getQuery('to_date_2') && Yii::app()->request->getQuery('from_date_2')) {
            $dates_2 = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date and t.date<=:to_date AND user_id=:user_id',
                'params' => array(
                    'to_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date_2')),
                    'from_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date_2')),
                    'user_id' => $id
                )
            ));
        }

        $datesHistory = new CArrayDataProvider($dates_2, array(
            'keyField' => 'date',
            'pagination' => false
        ));

        $dates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 't.ordered=:ordered AND t.send=:send AND t.completion=:completion AND user_id=:user_id',
            'params' => array('ordered' => 0, 'send' => 0, 'user_id' => $id, 'completion' => 1),

        ));
        $orders_3 = array();
        foreach ($dates as $date) {
            $items = Orders::model()->findAll(array(
                'condition' => 't.ordered=:ordered AND t.send=:send AND t.completion=:completion AND user_id=:user_id AND date=:date',
                'params' => array(
                    'date' => $date->date,
                    'user_id' => $id,
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

        $this->render('orders', array(
            'model' => $model,
            'orders' => $results,
            'user_id' => $id,
            'invoices' => $invoices,
            'orders_3' => $orders_3,
            'datesHistory' => $datesHistory
        ));
    }


    /**
     * Display list of users
     */
    public function actionIndex()
    {
        $regions = Region::model()->getAllRegions();
        $cities = City::model()->getAllCities();

        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }

        $this->render('index', array(
            'model' => $model,
            'regions' => $regions,
            'cities' => $cities
        ));
    }

    /**
     * Update declaration
     * @param $id
     * @param $user_id
     */
    public function actionUpdateDeclaration($id, $user_id)
    {
        $model = Declarations::model()->findByPk($id);

        if (isset($_POST['declarations'])) {
            $model->attributes = $_POST['declarations'];
            if ($model->save()) {
                $this->redirect(array('declarations', 'id' => $user_id));
            }
        }

        $this->render('update_declaration', array(
            'model' => $model,
            ''
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Дані не знайдені');
        return $model;
    }

    public function actionSuborders()
    {
        if (Yii::app()->request->getQuery('id')) {
            if (strpos(Yii::app()->request->getQuery('id'), '-')) {
                $datesCriteria = new CDbCriteria();
                $datesCriteria->addCondition('user_id=' . Yii::app()->request->getQuery('user_id') . ' AND date="' . Yii::app()->request->getQuery('id') . '"');
                $orders = new CActiveDataProvider('Orders', array(
                    'criteria' => $datesCriteria,
                    'pagination' => false
                ));
                $this->renderPartial('_sendedOrders', array('orders' => $orders, 'date' => Yii::app()->request->getQuery('id'), 'user_id' => Yii::app()->request->getQuery('user_id')));
            } else {
                $user = Users::model()->findByPk(Yii::app()->request->getQuery('user_id'));
                $invoice = Invoices::model()->findByPk(Yii::app()->request->getQuery('id'));

                $criteria = new CDbCriteria();
                $criteria->addCondition('user_id=' . Yii::app()->request->getQuery('user_id'));
                $criteria->addCondition('ordered=1');
                $criteria->addCondition('send=1');
                $criteria->addCondition('date_logistic="' . $invoice['date'] . '"');

                $orders = new CActiveDataProvider('Orders', array(
                    'criteria' => $criteria,
                    'pagination' => false
                ));
                $this->renderPartial('_suborders', array('orders' => $orders, 'invoice' => $invoice, 'user' => $user));
            }
        }
    }

    public function actionSuborders_2()
    {

        if (Yii::app()->request->getQuery('id')) {
            $user = Users::model()->findByPk(Yii::app()->request->getQuery('user_id'));
            $payment = Payments::model()->findByPk(Yii::app()->request->getQuery('id'));
            if ($payment['status'] == 1) {
                $criteria = new CDbCriteria();
                $criteria->addCondition('user_id=' . Yii::app()->request->getQuery('user_id'));
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

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetManagers($curator_id = false)
    {
        $managers = array();
        if (Yii::app()->request->getPost('curator_id', '')) {
            $curator_id = Yii::app()->request->getPost('curator_id');
        }
        $managers[0] = array(
            'id' => '0',
            'name' => ''
        );
        if ($curator_id == -1) {
            $managers[0] = array(
                'id' => '-1',
                'name' => ''
            );
        }
        for ($i = 0; $i <= 9; $i++) {
            if ($curator_id == -1) {
                $managers[] = array(
                    'id' => $i,
                    'name' => 'Менеджер ' . $i
                );
            } else {
                $managers[] = array(
                    'id' => $curator_id . $i,
                    'name' => 'Менеджер ' . $curator_id . $i
                );
            }
        }

        if (Yii::app()->request->getPost('curator_id', '')) {
            echo json_encode($managers);
        }

        return $managers;
    }

    public function actionRegisterUser()
    {
        $countries = new Country();
        $countries = $countries->getAdminCountries();
        $model = new Users;
        $model->scenario = 'register';

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->status = 1;
            if ($model->validate() && $model->save())
                Yii::app()->user->setFlash('success_2', 'Реєстрація пройшла успішно. Для початку роботи профіль клієнта потрібно підтвердити.');
            $this->redirect(array('update', 'id' => $model->id));
        }

        $this->render('register-user', array(
            'model' => $model,
            'countries' => $countries
        ));
    }

    /**
     * Get regions list
     */
    public function actionRegion()
    {
        $regions = new Region();
        $regions = $regions->getRegions($_POST['country_id']);
        echo json_encode($regions);
    }

    /**
     * Get cities list
     */
    public function actionCity()
    {
        $cities = new City();
        $cities = $cities->getCities($_POST['region_id']);
        echo json_encode($cities);
    }


    public function actionUserCart($id)
    {

        $cart = Cart::model()->findAllByAttributes(array(
                'user_id' => $id,
            )
        );
        $items = new CArrayDataProvider($cart, array(
            'pagination' => false,
        ));

        $this->render('user-cart', array(
            'id' => $id,
            'items' => $items,
        ));
    }
}
