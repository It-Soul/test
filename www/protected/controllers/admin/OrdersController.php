<?php

class OrdersController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//admin/layouts/column1';

    public function actions()
    {
        return array(
            'toggle' => array(
                'class' => 'yiiwheels.widgets.grid.actions.WhToggleAction',
                'modelName' => 'Orders',
            )
        );
    }

    /**
     * @return array action filters
     */
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
                'actions' => array('index', 'view', 'order', 'toggle', 'editOrder','completion', 'logistic', 'setSend', 'filtr', 'revaluation', 'setNotSend', 'setOrdered'),
                'users' => array('@'),
                'roles' => array('administrator')
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'order', 'updateLogistic'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'order'),
                'roles' => array('administrator'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Update order information
     * @param $id
     * @param bool $referrer
     */
    public function actionUpdate($id, $referrer = false)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            if ($model->save())
                $this->redirect($referrer);
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Update order logistic information
     * @param $id
     */
    public function actionUpdateLogistic($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Дані збережено");
            }
            $this->redirect(array('updateLogistic', 'id' => $model->id));
        }

        $this->render('update-logistic', array(
            'model' => $model,
        ));
    }

    /**
     * Delete order
     * @param $id
     * @param bool $referrer
     */
    public function actionDelete($id, $referrer = false)
    {
        $this->loadModel($id)->delete();

        $this->redirect($referrer);
    }

    /**
     * Display list of all not ordered orders
     */
    public function actionIndex()
    {
        $results = array();
        $date = date('Y-m-d', time());
        $ordersModel = new Orders();
        $dates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 't.date=:date',
            'params' => array('date' => $date)
        ));

        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $dates = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date',
                'params' => array(
                    'from_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date'))
                )
            ));
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $dates = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date<=:to_date',
                'params' => array(
                    'to_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date'))
                )
            ));
        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $dates = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date and t.date<=:to_date',
                'params' => array(
                    'to_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date')),
                    'from_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date'))
                )
            ));
        }

        foreach ($dates as $date) {
            $users = Orders::model()->findAll(array(
                'select' => 't.user_id',
                'group' => 't.user_id',
                'distinct' => true,
                'condition' => 't.date=:from_date',
                'params' => array('from_date' => $date->date)
            ));

            foreach ($users as $user) {
                $items = Orders::model()->findAllByAttributes(array(
                        'date' => $date->date,
                        'user_id' => $user->user_id,
                    )
                );

                $results[$date->date][$user->user_id] = new CArrayDataProvider($items, array(
                    'sort' => array(
                        'attributes' => array(
                            'provider',
                            'name',
                            'cod',
                            'manufacturer',
                            'quantity',
                            'price_in',
                            'price_in_sum',
                            'manager',
                            'courier',
                            'admin',
                            'course',
                            'price_out',
                            'price_out_sum',
                            'ordered'
                        )
                    ),
                    'pagination' => false,
                ));
            }
        }

        $this->render('index', array(
            'model' => $results,
            'notMatchLogistic' => $ordersModel->getNotMatchLogistic()
        ));
    }

    /**
     * Display list of all orders
     */
    public function actionFiltr()
    {
        $model = new Orders('search');
        $ordersModel = new Orders();

        $model->unsetAttributes();
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

        $users = Users::model()->findAll(array('order' => 't.organisation'));
        $users = CHtml::listData($users, 'id', 'fullname');

        $this->render('filtr', array(
            'model' => $model,
            'users' => $users,
            'notMatchLogistic' => $ordersModel->getNotMatchLogistic()
        ));


    }

    public function actionOrder($id)
    {
        $user = Orders::model()->findByAttributes(array('id' => $id));
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $user->user_id);
        $model = new CActiveDataProvider('Orders', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $this->renderPartial('_order', array(
            'model' => $model
        ));
    }

    /**
     * Mark order as ordered
     */
    public function actionSetOrdered()
    {
        if (Yii::app()->request->getQuery('id', '')) {
            Orders::model()->updateByPk(Yii::app()->request->getQuery('id'), array(
                'ordered' => 1
            ));
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Mark order as send
     */
    public function actionSetSend()
    {
        if (Yii::app()->request->getQuery('id', '')) {
            $model = Orders::model()->findByPk(Yii::app()->request->getQuery('id'));
            if ($model->quantity > $model->received) {
                $copy = new Orders();
                $copy->price_in = $model->price_in;
                $copy->price_out = $model->price_out;
                $copy->user_id = $model->user_id;
                $copy->name = $model->name;
                $copy->cod = $model->cod;
                $copy->status = $model->status;
                $copy->name = $model->name;
                $copy->image = $model->image;
                $copy->user_name = $model->user_name;
                $copy->price_in_sum = round(($model->quantity-$model->received) * $model->price_in);
                $copy->price_out_sum = round(($model->quantity-$model->received) * $model->price_out);
                $copy->quantity = $model->quantity - $model->received;
                $copy->provider = $model->provider;
                $copy->ordered = 0;
                $copy->send = 0;
                $copy->date = $model->date;
                $copy->manufacturer = $model->manufacturer;
                $copy->is_advance = $model->is_advance;
                $copy->received = NULL;
                $copy->completion = 1;


                $copy->save();
                $quantity = $model->quantity - ($model->quantity - $model->received);
                $model->send = 1;
                $model->date_logistic = date('Y-m-d H:i:s', time());
                $model->quantity = $quantity;
                $model->completion = 0;
                $model->save();
                Invoices::model()->createOrUpdateInvoice($model->date_logistic);
            }
            else {
                $model->send = 1;
                $model->date_logistic = date('Y-m-d', time());
                $model->save();
                Invoices::model()->createOrUpdateInvoice($model->date_logistic);

            }
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Mark order as not send
     */
    public function actionSetNotSend()
    {
        if (Yii::app()->request->getQuery('id', '')) {
            Orders::model()->updateByPk(Yii::app()->request->getQuery('id'), array(
                'send' => 0
            ));
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionCompletion(){
        $results = array();
        $date = date('Y-m-d', time());
        $ordersModel = new Orders();

        $dates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 'completion=:completion AND ordered<>:ordered',
            'params' => array('completion' => 1, 'ordered' => 1)
        ));

        foreach ($dates as $date) {
            $users = Orders::model()->findAll(array(
                'select' => 't.user_id',
                'group' => 't.user_id',
                'distinct' => true,
                'condition' => 'completion=:completion AND ordered<>:ordered',
                'params' => array('completion' => 1,'ordered'=>1)
            ));

            foreach ($users as $user) {
                $items = Orders::model()->findAllByAttributes(array(
                        'date' => $date->date,
                        'user_id' => $user->user_id,
                        'completion' => 1,
                        'ordered'=>0
                    )
                );

                $results[$date->date][$user->user_id] = new CArrayDataProvider($items, array(
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
                            'work',
                            'summary',
                            'send',
                            'received'
                        )
                    ),
                    'pagination' => false
                ));
            }
        }

        $this->render('completion', array(
            'model' => $results,
            'notMatchLogistic' => $ordersModel->getNotMatchLogistic()
        ));

    }
    public function actionLogistic()
    {
        $results = array();
        $ordersModel = new Orders();
        $date = date('Y-m-d', time());

        $dates = Orders::model()->findAll(array(
            'select' => 't.date',
            'group' => 't.date',
            'order' => 't.date DESC',
            'distinct' => true,
            'condition' => 't.date=:date AND ordered=:ordered',
            'params' => array('date' => $date, 'ordered' => 1)
        ));

        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $dates = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date AND ordered=:ordered',
                'params' => array(
                    'from_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date')),
                    'ordered' => 1
                )
            ));
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $dates = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date<=:to_date AND ordered=:ordered',
                'params' => array(
                    'to_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date')),
                    'ordered' => 1
                )
            ));
        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $dates = Orders::model()->findAll(array(
                'select' => 't.date',
                'group' => 't.date',
                'order' => 't.date DESC',
                'distinct' => true,
                'condition' => 't.date>=:from_date and t.date<=:to_date AND ordered=:ordered',
                'params' => array(
                    'to_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('to_date')),
                    'from_date' => DateFormatter::formatDateForSqlFilter(Yii::app()->request->getQuery('from_date')),
                    'ordered' => 1
                )
            ));
        }

        foreach ($dates as $date) {
            $users = Orders::model()->findAll(array(
                'select' => 't.user_id',
                'group' => 't.user_id',
                'distinct' => true,
                'condition' => 't.date=:from_date AND ordered=:ordered',
                'params' => array('from_date' => $date->date, 'ordered' => 1)
            ));

            foreach ($users as $user) {
                $items = Orders::model()->findAllByAttributes(array(
                        'date' => $date->date,
                        'user_id' => $user->user_id,
                        'ordered' => 1
                    )
                );

                $results[$date->date][$user->user_id] = new CArrayDataProvider($items, array(
                    'pagination'=>false,
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
                            'work',
                            'summary',
                            'send',
                            'received'
                        )
                    ),
                ));
            }
        }

        $this->render('logistic', array(
            'model' => $results,
            'notMatchLogistic' => $ordersModel->getNotMatchLogistic()
        ));
    }

    public function actionRevaluation()
    {
        $model = new Orders('search');
        $ordersModel = new Orders();

        if (isset($_POST['Order_id']) && (isset($_POST['exchangerates']))) {
            $zloty = (double)trim(str_replace(',', '.', $_POST['exchangerates']));
            foreach ($_POST['Order_id'] as $keys) {
                $query = Orders::model()->findByPk($keys);
                $coef = Coefficients::model()->getUserCoefficient($query->user_id, $query->provider);
                $price = round($query->price_in * $coef['logistic'] * $zloty , 0);

                $admin_price = ($price * $coef['admin_coef']) - $price;
                $curator_price = ($price * $coef['curator_coef']) - $price;
                $manager_price = ($price * $coef['manager_coef']) - $price;
                $price = round($admin_price + $curator_price + $manager_price + $price, 0);

                Orders::model()->updateByPk($query->id, array(
                    'com_course' => round($query->price_in_sum * $zloty, 0),
                    'com_grn' => round(($query->price_in_sum * $coef['logistic']) * $zloty, 0),
                    'work' => round(($query->price_in_sum * $coef['logistic']) - $query->price_in_sum, 0),
                    'vat' => round(($query->price_in_sum * $coef['vat']) - $query->price_in_sum, 0),
                    'logistic_pln' => round($query->price_in_sum * $coef['logistic'], 0),
                    'logistic_grn' => round($query->price_in_sum * $coef['logistic'] * $zloty, 0),
                    'summary' => round((($query->price_in_sum * $coef['logistic']) - $query->price_in_sum) + $query->price_in_sum, 0),
                    'logist_pln' => round(($query->price_in_sum * $coef['logistic']) - $query->price_in_sum, 0),
                    'manager' => round((($query->price_in_sum * $coef['logistic'] * $zloty * $coef['manager_coef']) - ($query->price_in_sum * $coef['logistic'] * $zloty)), 0),
                    'courier' => round((($query->price_in_sum * $coef['logistic'] * $zloty) * $coef['curator_coef']) - ($query->price_in_sum * $coef['logistic'] * $zloty), 0),
                    'admin' => round((($query->price_in_sum * $coef['logistic'] * $zloty) * $coef['admin_coef']) - ($query->price_in_sum * $coef['logistic'] * $zloty), 0),
                    'course' => $zloty,
                    'price_out' => $price,
                    'price_out_sum' => round($query->quantity * $price, 0),
                ));
            }
        }

        $this->render('revaluation', array(
            'model' => $model,
            'notMatchLogistic' => $ordersModel->getNotMatchLogistic()
        ));


    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Orders $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionEditOrder()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $order = Orders::model()->findByPk(Yii::app()->request->getPost('pk'));
            if ($order->send != 1) {
                Yii::import('ext.editable.EditableSaver'); //or you can add import 'ext.editable.*' to config
                $es = new EditableSaver('Orders');  // 'User' is classname of model to be updated
                $es->update();
            } else throw new CHttpException(403, 'Не можливо змінити відгружені замовлення');
        }
    }
}
