<?php

class EditorController extends Controller
{
    public $layout = '//admin/layouts/column1';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array(
                    'index', 'access', 'editCurrency', 'exchange', 'access', 'editAccess', 'worked', 'calendar',
                    'visualization', 'toggle', 'coefficients'
                ),
                'users' => array('@'),
                'roles' => array('administrator')
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Display editor index page
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Display exchange rates page
     */
    public function actionExchange()
    {
        $exchange_rates = new ExchangeRates('search');
        $exchange_rates->unsetAttributes();

        if (isset($_GET['ExchangeRates'])) {
            $exchange_rates->attributes = $_GET['ExchangeRates'];
        }

        return $this->render('exchange', array(
            'exchange_rates' => $exchange_rates,
        ));
    }

    /**
     * Update exchange rates
     */
    public function actionEditCurrency()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $es = new EditableSaver('ExchangeRates');
            return $es->update();
        }

        return false;
    }

    /**
     * Display sites access control page
     * @return string
     */
    public function actionAccess()
    {
        $criteria = new CDbCriteria();

        $accessControl = new CActiveDataProvider('SitesAccessControl', array(
            'criteria' => $criteria,
        ));

        return $this->render('access', array(
            'accessControl' => $accessControl
        ));

    }

    /**
     * Display set default coefficients page
     * @return string
     */
    public function actionCoefficients()
    {
        if (!empty(Yii::app()->request->getPost('Coefficients'))) {
            $products = Coefficients::model()->setCoefficients(Yii::app()->request->getPost('Coefficients'));

            if ($products) {
                Yii::app()->user->setFlash('success', 'Зміни збережено');
            } else {
                Yii::app()->user->setFlash('error', 'Помилка!');
            }
        }
        $model = new Coefficients();

        return $this->render('coefficients-setting', array(
            'sites' => Sites::model()->getSites(),
            'model' => $model
        ));
    }

    /**
     * Update site access credentials
     */
    public function actionEditAccess()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $es = new EditableSaver('SitesAccessControl');
            return $es->update();
        }

        return false;
    }

    /**
     * Get date info
     * @return bool
     */
    public function actionWorked()
    {
        if (Yii::app()->request->getPost('date', '')) {
            $model = Calendar::model()->getDateInfo(Yii::app()->request->getPost('date'));
            if ($model) {
                echo json_encode($model);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Display and save logistic calendar
     */
    public function actionCalendar()
    {
        $settings = Settings::model()->getSettings();

        if (Yii::app()->request->getQuery('hour', '') && Yii::app()->request->getQuery('minute', '')) {
            $settings->date = '1970-01-01 ' . Yii::app()->request->getQuery('hour') . ':' . Yii::app()->request->getQuery('minute') . ':00';
            $settings->update();
        }

        $model = new Calendar();

        if (isset($_POST['Calendar'])) {
            Yii::app()->session['reload'] = 0;

            if ($date = $model->getDateInfo(date('Y-m-d', strtotime($_POST['Calendar']['data'])))) {
                $model->attributes = $_POST['Calendar'];

                $isFilledShop = false;
                for ($i = 0; $i < 10; $i++) {
                    if ($i > 0) {
                        if ($_POST['Calendar']['name'] != '' || $_POST['Calendar']['sklep'] != '') {
                            $isFilledShop = true;
                        }
                    } else {
                        if ($_POST['Calendar']["name_$i"] != '' || $_POST['Calendar']["sklep_$i"] != '') {
                            $isFilledShop = true;
                        }
                    }
                }

                if ($isFilledShop) {
                    $shops = array();
                    $shops['data'] = date('Y-m-d', strtotime($_POST['Calendar']['data']));
                    $shops['name'] = $_POST['Calendar']['name'];
                    $shops['sklep'] = $_POST['Calendar']['sklep'];

                    for ($i = 1; $i < 10; $i++) {
                        $shops["name_$i"] = $_POST['Calendar']["name_$i"];
                        $shops["sklep_$i"] = $_POST['Calendar']["sklep_$i"];
                    }

                    if ($model->validate() && Calendar::model()->updateByPk($date['id'], $shops)) {
                        Yii::app()->session['reload'] = 1;
                        unset($_POST['Calendar']);
                        Yii::app()->user->setFlash('сalendar', 'Зміни збережено');
                    }
                } else {
                    Yii::app()->session['reload'] = 1;
                    unset($_POST['Calendar']);

                    if (Calendar::model()->deleteByPk($date['id'])) {
                        Yii::app()->user->setFlash('сalendar', 'Зміни збережено');
                    };
                }
            } else {
                $model->attributes = $_POST['Calendar'];

                if ($model->validate() && $model->save()) {
                    Yii::app()->session['reload'] = 1;
                    unset($_POST['Calendar']);
                    Yii::app()->user->setFlash('сalendar', 'Зміни збережено');
                }
            }
        }

        return $this->render('calendar', array(
            'items' => MainHelper::initCalendar(true),
            'model' => $model,
            'time' => Settings::model()->getSettings()
        ));

    }

    /**
     * Display visualization page
     */
    public function actionVisualization()
    {
        $model = Visualization::model()->getVisualization();

        if (isset($_POST['Visualization'])) {
            $model->attributes = $_POST['Visualization'];

            if ($model->validate() && $model->save()) {
                Yii::app()->user->setFlash('success', 'Зміни збережено');
            }
        }

        return $this->render('visualization', array(
            'model' => $model
        ));
    }

    public function actions()
    {
        return array(
            'toggle' => array(
                'class' => 'yiiwheels.widgets.grid.actions.WhToggleAction',
                'modelName' => 'ExchangeRates',
            )
        );
    }
}