<?php

class ProductsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//    public $layout = '//admin/layouts/column1';

    /**
     * @return array action filters
     */
    public $providerAccess;
    public $edit_status;
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
                'actions' => array('create', 'update', 'delete','viewFile','uploadFile','archive','deleteFile','getFileProducts'),
                'users' => array('@'),
                'roles' => array('user')
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
    public function actionCreate()
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
        $model = new Results_add;

        if (isset($_POST['Results_add'])) {

            if (CUploadedFile::getInstance($model, 'image')) {
                $model->image = CUploadedFile::getInstance($model, 'image');
                $photoName = MainHelper::translit($model->image->getName());
                $model->photo = '/' . Yii::getPathOfAlias('photos') . '/' . $photoName;
            } else $model->photo = '/' . Yii::getPathOfAlias('photos') . '/Nophoto.jpg';

            $model->attributes = $_POST['Results_add'];
            $model->file_id = 0;
            $model->user_id = Yii::app()->user->id;
            $model->date = date('Y-m-d H:i:s');
            $model->last_check = date('Y-m-d H:i:s', time());

            if ((ProviderPerson::getUploadedProductsCount(Yii::app()->user->id) < $provider->allowed_products_amount) && $model->validate() && $model->save()) {
                $provider->uploaded_products_amount += 1;

                $provider->save(false);
                if ($model->image) {
                    $path = Yii::getPathOfAlias('photos') . '/' . $photoName;
                    $model->image->saveAs($path);
                }

                if (isset($_POST['Numbers_add']['number'])) {
                    foreach ($_POST['Numbers_add']['number'] as $item) {
                        $number = new Numbers_add();
                        $number->user_id = Yii::app()->user->id;
                        $number->results_add_id = $model->id;
                        $number->number = $item;
                        $number->save(false);
                    }
                }

                Yii::app()->user->setFlash('success', 'Зміни збережено.');

                $this->redirect(array('update', 'productId' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', 'Ви загрузили максимально дозволену кількість товарів');
                $this->redirect(array('create'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'id' => Yii::app()->user->id
        ));
    }

    /**
     * Update product
     *
     * @param $productId
     * @param bool $id
     */
    public function actionUpdate($productId)
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

                $this->redirect('archive');
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
    public function actionUploadFile()
    {
        $user = Users::model()->findByAttributes(array('id' => Yii::app()->user->id));
        $model = new ImportFiles();

        if (isset($_POST['ImportFiles'])) {

            $model->file = CUploadedFile::getInstance($model, 'file');

            $fileExtension = $model->file->extensionName;
            $fileName = uniqid('user_' . $user->id . '_import_') . '.' . $fileExtension;
            $filePath = Yii::getPathOfAlias('excel') . '/' . $fileName;

            $model->name = $_POST['ImportFiles']['name'];
            $model->real_file_name = $fileName;
            $model->user_id = $user->id;
            $model->created_at = date('Y-m-d H:i:s', time());
            $model->last_check = date('Y-m-d H:i:s', time());

            if ($model->save(false)) {
                if ($model->file->saveAs($filePath)) {
                    $positionsAmount = ImportHelper::processPriceFile(array(
                        'filePath' => $filePath,
                        'fileExtension' => $fileExtension,
                        'currency' => $_POST['ImportFiles']['currency'],
                        'user_id' => $user->id,
                        'file_id' => $model->id
                    ));

                    $model->positions_amount = $positionsAmount;
                    if ($model->save(false)) {
                        return $this->redirect(Yii::app()->createUrl('products/viewFile', array('fileId' => $model->id)));
                    }
                }

            }

        }

        $this->render('upload-file', array(
            'user' => $user,
            'model' => $model
        ));
    }

    /**
     * view products uploaded from file
     *
     * @param $id
     * @param $fileId
     */
    public function actionViewFile($fileId)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('file_id=' . $fileId);
        $products = new CActiveDataProvider('Results_add', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $this->providerAccess = ProviderPerson::getProviderAccess(Yii::app()->user->id);

        $this->render('view-file', array(
            'products' => $products,
//            'user_id' => Yii::app()->user->id
        ));
    }
    public function actionArchive()
    {
        $this->providerAccess = ProviderPerson::getProviderAccess(Yii::app()->user->id);
        $this->edit_status = ProviderPerson::getProviderAccess(Yii::app()->user->id)->updating_status;
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id=' . Yii::app()->user->id);
        $criteria->order = 'created_at DESC';

        $files = new CActiveDataProvider('ImportFiles',
            array(
                'criteria' => $criteria,
                'pagination' => false
            ));

        $productsCriteria = new CDbCriteria();
        $productsCriteria->addCondition('user_id=' . Yii::app()->user->id . ' AND file_id=0');
        $productsCriteria->order = 'date DESC';

        $products = new CActiveDataProvider('Results_add',
            array(
                'criteria' => $productsCriteria,
                'pagination' => false
            ));

        $this->render('archive', array(
            'id' => Yii::app()->user->id,
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
        $this->edit_status = ProviderPerson::getProviderAccess(Yii::app()->user->id)->file_updating_status;

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
}
