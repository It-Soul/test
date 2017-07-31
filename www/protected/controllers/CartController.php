<?php

class CartController extends Controller
{
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

    public function actionIndex()
    {
        $cart = Cart::model()->findAllByAttributes(array(
                'user_id' => Yii::app()->user->id,
            )
        );

        $dataProvider = new CArrayDataProvider ($cart, array('pagination' => false));

        $sum = Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0);
        $sum_work = Orders::model()->getUserSum_2(Yii::app()->user->id, 1, 0);
        $orders_sum = Orders::model()->getUserSumByDateOrdered(Yii::app()->user->id, date('Y-m-d', time()), 0, 0)['price_out_sum'];
        $arrears = (Orders::model()->getUserSum_2(Yii::app()->user->id, 0, 0)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 0, true)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 1, false)['price_out_sum'] + Orders::model()->getUserSumProcess(Yii::app()->user->id, 1, 1, true)['price_out_sum']) - Payments::model()->getUserSum(Yii::app()->user->id);
        $cart_sum = Cart::model()->getCartSum(Yii::app()->user->id);

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'sum' => $sum,
            'sum_work' => $sum_work,
            'orders_sum' => $orders_sum,
            'arrears' => $arrears,
            'cart_sum' => $cart_sum
        ));
    }

    // Uncomment the following methods and override them if needed

    public function accessRules()
    {
        return array(

            array('allow',
                'actions' => array('index', 'add', 'buy', 'delete'),
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

        );
    }

    /*
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
    public function actionAdd()
    {
        $response = array(
            'status' => false
        );

        $model = new Cart();
        $cartAttributes = Yii::app()->request->getPost('Orders');
        if (!empty($cartAttributes)) {
            $model->attributes = $cartAttributes;
            $model->user_id = Yii::app()->user->id;

            $model->user_name = Yii::app()->user->name;
            if ($model->validate() && $model->save()) {
                $response['status'] = true;
            }

        }
        echo json_encode($response);
        Yii::app()->end();
    }

    public function actionBuy()
    {
        if (isset($_POST['Cart_id'])) {

            foreach ($_POST['Cart_id'] as $keys) {

                $cart = Cart::model()->findByAttributes(array(
                        'user_id' => Yii::app()->user->id,
                        'id' => $keys,
                ));

                $model = new Orders();

                $model->user_id = Yii::app()->user->id;
                $model->name = $cart['name'];
                $model->cod = $cart['cod'];
                $model->price_out_sum = $cart['price_out_sum'];
                $model->quantity = $cart['quantity'];
                $model->price_out = $cart['price_out'];
                $model->price_in = $cart['price_in'];
                $model->price_in_sum = $cart['price_in_sum'];
                $model->provider = $cart['provider'];
                $model->manufacturer = $cart['manufacturer'];
                $model->is_advance = $cart['is_advance'];
                $model->user_name = Yii::app()->user->name;
                $model->save();
                Yii::app()->db->createCommand()->delete('cart', 'id=:id', array(':id' => $keys));
            }
        }
        Yii::app()->user->setFlash('cart_success', 'Ваше замовлення прийнято.');

        $this->redirect('/cart/index');
    }

    public function actionDelete()
    {
        if (isset($_POST['Cart_id'])) {
            foreach ($_POST['Cart_id'] as $keys) {
                Yii::app()->db->createCommand()->delete('cart', 'id=:id', array(':id' => $keys));
            }
        }
        Yii::app()->user->setFlash('cart_error', 'Елементи видалено.');

        $this->redirect('/cart/index');
    }
}
