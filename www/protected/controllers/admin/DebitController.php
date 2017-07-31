<?php

class DebitController extends Controller
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

            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'setStatus'),
                'users' => array('@'),
                'roles' => array('administrator')
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $debtAmount = 0;
        $debtors = array();
        $users = Users::model()->getAllUsers();

        foreach ($users as $user) {
            $userArrears = Orders::model()->getUserArrears($user->id);

            if ($userArrears != 0) {
                $debtors[] = $user;
                $debtAmount += $userArrears;
            }
        }

        $debtorsList = new  CArrayDataProvider($debtors, array(
            'pagination' => false
        ));

        $messagesList = new CArrayDataProvider(Messages::model()->getNotViewedMessages(), array(
            'pagination' => false
        ));

        return $this->render('index', array(
            'debtorsList' => $debtorsList,
            'debtAmount' => $debtAmount,
            'messagesList' => $messagesList
        ));

    }

    /**
     * Set message status as viewed
     */
    public function actionSetStatus()
    {
        if (Yii::app()->request->getQuery('id', '')) {
            Messages::model()->updateByPk(Yii::app()->request->getQuery('id'), array(
                'status' => 1
            ));
        }

        return $this->redirect(Yii::app()->request->urlReferrer);
    }
}