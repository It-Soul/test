<?php

class ProductsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//admin/layouts/column1';

    public $providerAccess;

    /**
     * @return array action filters
     */
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
                'actions' => array('create', 'update', 'delete', 'archive', 'deleteFile', 'getFileProducts'),
                'users' => array('@'),
                'roles' => array('administrator')
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
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
     * Creates a new product.
     * @param $id
     */
    public function actionCreate($id)
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $id));
        $model = new Results_add;

        if (isset($_POST['Results_add'])) {

            if (CUploadedFile::getInstance($model, 'image')) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $photoName = MainHelper::translit($model->image->getName());
                $model->photo = $photoName;
                $model->photo = '/' . Yii::getPathOfAlias('photos') . '/' . $photoName;
            } else $model->photo = '/' . Yii::getPathOfAlias('photos') . '/Nophoto.jpg';

            $model->attributes = $_POST['Results_add'];
            $model->file_id = 0;
            $model->user_id = $id;
            $model->date = date('Y-m-d H:i:s');
            $model->last_check = date('Y-m-d H:i:s', time());

            if ((ProviderPerson::getUploadedProductsCount($id) < $provider->allowed_products_amount) && $model->validate() && $model->save()) {
                $provider->uploaded_products_amount += 1;

                $provider->save(false);
                if ($model->image) {
                    $path = Yii::getPathOfAlias('photos') . '/' . $photoName;
                    $model->image->saveAs($path);
                }


                if (isset($_POST['Numbers_add']['number'])) {
                    foreach ($_POST['Numbers_add']['number'] as $item) {
                        $number = new Numbers_add();
                        $number->user_id = $id;
                        $number->results_add_id = $model->id;
                        $number->number = $item;
                        $number->save(false);
                    }
                }

                Yii::app()->user->setFlash('success', 'Товар додано.');

                $this->redirect(array('update', 'productId' => $model->id, 'id' => $id));
            } else {
                Yii::app()->user->setFlash('error', 'Ви загрузили максимально дозволену кількість товарів');
                $this->redirect(array('create', 'id' => $id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'id' => $id
        ));
    }

    /**
     * Update product
     *
     * @param $productId
     * @param bool $id
     */
    public function actionUpdate($productId, $id = false)
    {
        $model = $this->loadModel($productId);
        $numbers = Numbers_add::getNumbersByProductId($productId);

        if (isset($_POST['Results_add'])) {


            if (CUploadedFile::getInstance($model, 'image')) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $photoName = MainHelper::translit($model->image->getName());
                $model->photo = '/' . Yii::getPathOfAlias('photos') . '/' . $photoName;
            }

            $model->attributes = $_POST['Results_add'];
            $model->last_check = date('Y-m-d H:i:s', time());

            if ($model->validate() && $model->save()) {
                if ($model->image) {
                    $path = Yii::getPathOfAlias('photos') . '/' . $photoName;
                    $model->image->saveAs($path);
                }

                if (isset($_POST['Numbers_add']['number'])) {
                    Numbers_add::model()->deleteAllByAttributes(array('results_add_id' => $productId));
                    foreach ($_POST['Numbers_add']['number'] as $item) {
                        $number = new Numbers_add();
                        $number->user_id = $model->user_id;
                        $number->results_add_id = $model->id;
                        $number->number = $item;
                        $number->save(false);
                    }
                }

                Yii::app()->user->setFlash('success', 'Зміни збережено.');

                $this->redirect(array('archive', 'id' => $model->user_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'numbers' => $numbers
        ));
    }

    /**
     * Delete product
     *
     * @param $id
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            return $this->redirect(Yii::app()->request->urlReferrer);
        }

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Results_add the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Results_add::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Results_add $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'results-add-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionArchive($id)
    {
        $this->providerAccess = ProviderPerson::getProviderAccess($id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . $id);
        $criteria->order = 'created_at DESC';

        $files = new CActiveDataProvider('ImportFiles',
            array(
                'criteria' => $criteria,
                'pagination' => false
            ));

        $productsCriteria = new CDbCriteria();
        $productsCriteria->addCondition('user_id=' . $id . ' AND file_id=0');
        $productsCriteria->order = 'date DESC';

        $products = new CActiveDataProvider('Results_add',
            array(
                'criteria' => $productsCriteria,
                'pagination' => false
            ));

        $this->render('archive', array(
            'id' => $id,
            'files' => $files,
            'products' => $products
        ));
    }

    public function actionDeleteFile($id)
    {
        if (ImportFiles::model()->deleteByPk($id)) {
            Results_add::model()->deleteAllByAttributes(array('file_id' => $id));
            Yii::app()->user->setFlash('error', 'Файл видалено.');
            return $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionGetFileProducts()
    {
        if (Yii::app()->request->getQuery('id')) {

            $criteria = new CDbCriteria();
            $criteria->addCondition('file_id=' . Yii::app()->request->getQuery('id'));
            $products = new CActiveDataProvider('Results_add', array(
                'criteria' => $criteria,
                'pagination' => false
            ));
            $this->renderPartial('_products', array('products' => $products));
        }
    }
}
