<?php

class ProviderController extends Controller
{
    public $layout = '//admin/layouts/column1';
    public $providerAccess;

    public function filters()
    {
        return array(
            'accessControl',
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
            array('allow',
                'actions' => array('settings', 'disable', 'enable', 'uploadFile', 'viewFile', 'deleteProduct', 'updateProduct'),
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
            $user = Users::model()->getById(Yii::app()->user->id);

            if ($user->role == 'banned' || $user->status != 1) {
                Yii::app()->user->logout();
                return $this->redirect('/site/login');
            }
            return true;
        }
        return true;
    }

    /**
     * display provider settings
     * @param $id
     */
    public function actionSettings($id)
    {
        $user = Users::model()->getById($id);
        $provider = $user->provider;

        if (isset($_POST['ProviderPerson'])) {
            $provider->attributes = $_POST['ProviderPerson'];
            $provider->country_logistic = MainHelper::setNumberFormat($_POST['ProviderPerson']['country_logistic']);

            if ($provider->save()) {
                Yii::app()->user->setFlash('success', "Дані збережено");
                return $this->redirect(array('settings', 'id' => $provider->user_id));
            } else {
                Yii::app()->user->setFlash('error', "Дані не збережено");
            }
        }

        return $this->render('settings', array(
            'provider' => $provider,
            'user' => $user,
            'country' => $provider->country
        ));
    }

    /**
     * prohibit the user to be a supplier
     * @param $id
     */
    public function actionDisable($id)
    {
        if (ProviderPerson::setDisabled($id)) {
            return $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * allows the user to be a supplier
     * @param $id
     */
    public function actionEnable($id)
    {
        if (ProviderPerson::setEnabled($id)) {
            return $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * upload and process price file
     * @param $id
     */
    public function actionUploadFile($id)
    {
        $user = Users::model()->getById($id);
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
                        return $this->redirect(Yii::app()->createUrl('/admin/provider/viewFile', array('id' => $user->id, 'fileId' => $model->id)));
                    }
                }

            }

        }

        return $this->render('upload-file', array(
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
    public function actionViewFile($id, $fileId)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('file_id=' . $fileId);
        $products = new CActiveDataProvider('Results_add', array(
            'criteria' => $criteria,
            'pagination' => false
        ));

        $this->providerAccess = ProviderPerson::getProviderAccess($id);

        return $this->render('view-file', array(
            'products' => $products,
            'user_id' => $id
        ));
    }

}