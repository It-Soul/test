<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $cod
 * @property integer $status
 * @property string $image
 * @property string $user_name
 * @property string $quantity
 * @property string $price_in
 * @property string $price_in_sum
 * @property string $price_out
 * @property string $price_out_sum
 * @property string $date
 * @property string $provider
 * @property string $ordered
 * @property string $send
 * @property string $manufacturer
 * @property string $com_course
 * @property string $vat
 * @property string $logistic_pln
 * @property string $logistic_grn
 * @property string $com_grn
 * @property string $logist_pln
 * @property string $manager
 * @property string $courier
 * @property string $admin
 * @property string $course
 * @property string $received
 * @property string $work
 * @property string $summary
 * @property string $date_logistic
 * @property string $is_advance
 * @property string $completion
 */
class Orders extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, status, quantity, ordered, send, is_advance,completion', 'numerical', 'integerOnly' => true),
            array('price_out, price_in, price_out_sum, price_in_sum, com_course, vat, logistic_pln, logistic_grn, com_grn, logist_pln, manager, courier, admin, course, received, work, summary,completion', 'numerical'),
            array('cod', 'length', 'max' => 50),
            array('manufacturer', 'length', 'max' => 255),
            array('image, provider', 'length', 'max' => 100),
            array('name, user_name', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, name, cod, status, image, user_name, price_out, price_in, price_out_sum, price_in_sum, date, date_logistic,ordered, send, provider, manufacturer, com_course, vat, logistic_pln, logistic_grn, com_grn, logist_pln, manager, courier, admin, course, received, work, summary,completion', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'ID Замовника',
            'name' => 'Назва запчастини',
            'cod' => '№ запчастини',
            'status' => 'Статус',
            'image' => 'Зображення',
            'user_name' => 'Замовник',
            'price' => 'Ціна',
            'quantity' => 'Кількість',
            'price_out' => 'Ціна грн',
            'price_in' => 'Ціна вхід',
            'price_out_sum' => 'Сума в гривнях',
            'price_in_sum' => 'Сума у валюті',
            'date' => 'Дата замовлення',
            'date_logistic' => 'Дата відгрузки',
            'provider' => 'Постачальник',
            'ordered' => 'Заказ',
            'send' => 'Відгрузка',
            'manufacturer' => 'Виробник',
            'com_course' => 'Ком. курс',
            'vat' => 'VAT',
            'logistic_pln' => 'Логіст. PLN',
            'logistic_grn' => 'Логіст. грн',
            'com_grn' => 'Ком. грн',
            'logist_pln' => 'Логіст. PLN',
            'manager' => 'Менедж',
            'courier' => 'Курат',
            'admin' => 'Адмін',
            'course' => 'Курс',
            'received' => 'Привезено'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
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
            $date = '"' . date('Y-m-d', time()) . '"';
            $criteria->addCondition('date=' . $date);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('cod', $this->cod, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('price_in', $this->price_in, true);
        $criteria->compare('price_out', $this->price_out, true);
        $criteria->compare('price_in_sum', $this->price_in_sum, true);
        $criteria->compare('price_out_sum', $this->price_out_sum, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('date_logistic', $this->date, true);
        $criteria->compare('provider', $this->provider, true);
        $criteria->compare('manufacturer', $this->manufacturer, true);
        $criteria->compare('com_course', $this->com_course, true);
        $criteria->compare('vat', $this->vat, true);
        $criteria->compare('logistic_pln', $this->logistic_pln, true);
        $criteria->compare('logistic_grn', $this->logistic_grn, true);
        $criteria->compare('com_grn', $this->com_grn, true);
        $criteria->compare('logist_pln', $this->logist_pln, true);
        $criteria->compare('manager', $this->manager, true);
        $criteria->compare('courier', $this->courier, true);
        $criteria->compare('admin', $this->admin, true);
        $criteria->compare('course', $this->course, true);
        $criteria->compare('received', $this->received, true);
        $criteria->compare('work', $this->work, true);
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('completion', $this->completion, true);
        $dataProvider =  new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
       $dataProvider->pagination = false;
        return $dataProvider;
    }

    protected function beforeSave()
    {

        if ($this->isNewRecord) {
            $data_activity = date('H:i', time());
            $data_worked = Data_worked::model()->findByPk(1);
            if ($data_activity >= date('H:i', strtotime($data_worked['date']))) {
                $this->date = date('Y-m-d', time() + 24 * 60 * 60);
            } else {
                $this->date = date('Y-m-d', time());
            }
            $echange_rate = new ExchangeRates();
            $echange_rate = $echange_rate->getExchangeRates();
            $coef = new Coefficients();
            $coef = $coef->getUserCoefficient($this->user_id, $this->provider);
            $this->com_course = number_format($this->price_in_sum * $echange_rate['zloty'], 2);
            $this->com_grn = number_format(($this->price_in_sum * $coef['logistic']) * $echange_rate['zloty'], 2);
            $this->work = number_format(($this->price_in_sum * $coef['logistic']) - $this->price_in_sum, 2);
            $this->vat = number_format(($this->price_in_sum * $coef['vat']) - $this->price_in_sum, 2);
            $this->logistic_pln = number_format($this->price_in_sum * $coef['logistic'], 2);
            $this->logistic_grn = number_format($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100)), 2);
            $this->summary = number_format((($this->price_in_sum * $coef['logistic']) - $this->price_in_sum) + $this->price_in_sum, 2);
            $this->logist_pln = number_format(($this->price_in_sum * $coef['logistic']) - $this->price_in_sum, 2);
            $this->manager = number_format((($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))) * $coef['manager_coef']) - ($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))), 2);
            $this->courier = number_format((($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))) * $coef['curator_coef']) - ($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))), 2);
            $this->admin = number_format((($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))) * $coef['admin_coef']) - ($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))), 2);
            $this->course = ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100));
            $this->received = NULL;

        } else {
            $echange_rate = new ExchangeRates();
            $echange_rate = $echange_rate->getExchangeRates();
            $coef = new Coefficients();
            $coef = $coef->getUserCoefficient($this->user_id, $this->provider);
            $this->price_in_sum = round($this->quantity * $this->price_in);
            $this->price_out_sum = round($this->quantity * $this->price_out);
            $this->com_course = number_format($this->price_in_sum * $echange_rate['zloty'], 2);
            $this->com_grn = number_format(($this->price_in_sum * $coef['logistic']) * $echange_rate['zloty'], 2);
            $this->work = number_format(($this->price_in_sum * $coef['logistic']) - $this->price_in_sum, 2);
            $this->vat = number_format(($this->price_in_sum * $coef['vat']) - $this->price_in_sum, 2);
            $this->logistic_pln = number_format($this->price_in_sum * $coef['logistic'], 2);
            $this->logistic_grn = number_format($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100)), 2);
            $this->summary = number_format((($this->price_in_sum * $coef['logistic']) - $this->price_in_sum) + $this->price_in_sum, 2);
            $this->logist_pln = number_format(($this->price_in_sum * $coef['logistic']) - $this->price_in_sum, 2);
            $this->manager = number_format((($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))) * $coef['manager_coef']) - ($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))), 2);
            $this->courier = number_format((($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))) * $coef['curator_coef']) - ($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))), 2);
            $this->admin = number_format((($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))) * $coef['admin_coef']) - ($this->price_in_sum * $coef['logistic'] * ($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100))), 2);
            $this->course = number_format(($echange_rate['zloty'] + (($echange_rate->zloty_repair * $echange_rate['zloty']) / 100)));
        }

        return parent::beforeSave();
    }

    public function getSum($date)
    {
        $items = Orders::model()->findAllByAttributes(array('date' => $date));

        return self::getFootersSum($items);
    }

    public function getUserSum($user_id)
    {
        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $from_date = Yii::app()->request->getQuery('from_date');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $items = Orders::model()->findAll('date>=:from_date and user_id=:user_id', array('from_date' => $from_date, 'user_id' => $user_id));
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $to_date = Yii::app()->request->getQuery('to_date');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            $items = Orders::model()->findAll('date<=:to_date and user_id=:user_id', array('to_date' => $to_date, 'user_id' => $user_id));

        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $from_date = Yii::app()->request->getQuery('from_date');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = Yii::app()->request->getQuery('to_date');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            $items = Orders::model()->findAll('date>=:from_date and date<=:to_date and user_id=:user_id', array('from_date' => $from_date, 'to_date' => $to_date, 'user_id' => $user_id));
        }
        if (!Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $date = date('Y-m-d', time());
            $items = Orders::model()->findAll('date=:date', array('date' => $date));
        }

        return self::model()->getFootersSum($items);
    }

    public function getAllSum()
    {
        if (Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $from_date = Yii::app()->request->getQuery('from_date');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));

            $items = Orders::model()->findAll('date>=:from_date ', array('from_date' => $from_date));
        }
        if (Yii::app()->request->getQuery('to_date') && !Yii::app()->request->getQuery('from_date')) {
            $to_date = Yii::app()->request->getQuery('to_date');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            $items = Orders::model()->findAll('date<=:to_date', array('to_date' => $to_date));

        }
        if (Yii::app()->request->getQuery('to_date') && Yii::app()->request->getQuery('from_date')) {
            $from_date = Yii::app()->request->getQuery('from_date');
            $from_date = str_replace('.', '-', $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = Yii::app()->request->getQuery('to_date');
            $to_date = str_replace('.', '-', $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            $items = Orders::model()->findAll('date>=:from_date and date<=:to_date', array('from_date' => $from_date, 'to_date' => $to_date));
        }
        if (!Yii::app()->request->getQuery('from_date') && !Yii::app()->request->getQuery('to_date')) {
            $date = date('Y-m-d', time());
            $items = Orders::model()->findAll('date=:date', array('date' => $date));
        }
        return self::model()->getFootersSum($items);
    }

    public function getUserSum_2($user_id, $ordered, $send)
    {
        $items = Orders::model()->findAllByAttributes(array('user_id' => $user_id, 'ordered' => $ordered, 'send' => $send));
        return self::getFootersSum($items);
    }

    public function getUserSumByDate($user_id, $date)
    {
        $items = Orders::model()->findAll('date=:date and user_id=:user_id', array('date' => $date, 'user_id' => $user_id));
        return self::getFootersSum($items);

    }
    public function getUserSumByDateOrders($user_id, $date)
    {
        $items = Orders::model()->findAll('date=:date and user_id=:user_id AND completion=:completion', array('date' => $date, 'user_id' => $user_id,'completion'=>0));
        return self::getFootersSum($items);

    }
    public function getUserSumByDateFin($user_id, $date,$completion)
    {
        $items = Orders::model()->findAll('date=:date and user_id=:user_id and completion =:completion AND ordered<>:ordered', array('date' => $date, 'user_id' => $user_id, 'completion'=> $completion,'ordered'=>1));
        return self::getFootersSum($items);

    }
    public function getUserSumByDateOrdered($user_id, $date, $ordered, $send, $completion = false)
    {
        $items = Orders::model()->findAll('date=:date and user_id=:user_id and send=:send and ordered=:ordered', array('date' => $date, 'user_id' => $user_id, 'send' => $send, 'ordered' => $ordered));
        return self::getFootersSum($items);
    }

    public function getUserSumByDateLogistic($user_id, $date, $ordered, $send)
    {
        $items = Orders::model()->findAll('date_logistic=:date and user_id=:user_id and send=:send and ordered=:ordered', array('date' => $date, 'user_id' => $user_id, 'send' => $send, 'ordered' => $ordered));
        return self::model()->getFootersSum($items);
    }

    public function getUserSumByDateCompletion($user_id, $date)
    {
        $items = Orders::model()->findAll('date=:date and user_id=:user_id and send=:send and ordered=:ordered AND completion=:completion', array('date' => $date, 'user_id' => $user_id, 'send' => 0, 'ordered' => 0, 'completion' => 1));
        return self::model()->getFootersSum($items);
    }

    public function getUserSumByDateProcess($user_id, $date, $ordered, $send, $cond)
    {
        if ($cond == true) {
            $items = Orders::model()->findAll('date=:date and user_id=:user_id and send=:send and ordered=:ordered ', array('date' => $date, 'user_id' => $user_id, 'send' => $send, 'ordered' => $ordered));
        } elseif ($cond == false) {
            $items = Orders::model()->findAll('date=:date and user_id=:user_id and send=:send and ordered=:ordered AND quantity<>received', array('date' => $date, 'user_id' => $user_id, 'send' => $send, 'ordered' => $ordered));
        }
        return self::model()->getFootersSum($items);
    }

    public function getUserSumProcess($user_id, $ordered, $send, $cond)
    {
        if ($cond == true) {
            $items = Orders::model()->findAll('user_id=:user_id and send=:send and ordered=:ordered ', array('user_id' => $user_id, 'send' => $send, 'ordered' => $ordered));
        } elseif ($cond == false) {
            $items = Orders::model()->findAll('user_id=:user_id and send=:send and ordered=:ordered AND quantity<>received', array('user_id' => $user_id, 'send' => $send, 'ordered' => $ordered));
        }
        return self::model()->getFootersSum($items);
    }

    public function getUserSumByDateDebit($user_id, $date)
    {
        $items = Orders::model()->findAll('date_logistic=:date and user_id=:user_id and send=:send and ordered=:ordered', array('date' => $date, 'user_id' => $user_id, 'send' => 1, 'ordered' => 1));
        return self::model()->getFootersSum($items);
    }
    public function getUserArrears($user_id)
    {
        $pay = Payments::model()->findAllByAttributes(array('user_id' => $user_id));
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
        $arrears = $suma_buy - $suma_opl;
        return $arrears;
    }

    public function getFootersSum($items)
    {
        $quantity = 0;
        $price_out_sum = 0;
        $price_in_sum = 0;
        $com_course = 0;
        $vat = 0;
        $logistic_pln = 0;
        $logistic_grn = 0;
        $com_grn = 0;
        $logist_pln = 0;
        $manager = 0;
        $courier = 0;
        $admin = 0;
        $course = 0;
        $work = 0;
        $summary = 0;

        foreach ($items as $item) {
            $quantity += $item['quantity'];
            $price_out_sum += $item['price_out_sum'];
            $price_in_sum += $item['price_in_sum'];
            $com_course += $item['com_course'];
            $vat += $item['vat'];
            $logistic_pln += $item['logistic_pln'];
            $logistic_grn += $item['logistic_grn'];
            $com_grn += $item['com_grn'];
            $logist_pln += $item['logist_pln'];
            $manager += $item['manager'];
            $courier += $item['courier'];
            $admin += $item['admin'];
            $course += $item['course'];
            $work += $item['work'];
            $summary += $item['summary'];
        }
        $result = array(
            'quantity' => $quantity,
            'price_out_sum' => $price_out_sum,
            'price_in_sum' => $price_in_sum,
            'com_course' => $com_course,
            'vat' => $vat,
            'logistic_pln' => $logistic_pln,
            'logistic_grn' => $logistic_grn,
            'com_grn' => $com_grn,
            'logist_pln' => $logist_pln,
            'manager' => $manager,
            'courier' => $courier,
            'admin' => $admin,
            'course' => $course,
            'work' => $work,
            'summary' => $summary
        );

        return $result;
    }

    public function getNotMatchLogistic()
    {
        return count(Orders::model()->findAll('completion=:completion AND ordered<>:ordered AND send<>:send', array(
            'completion' => 1,
            'send' => 1,
            'ordered' => 1,
        )));
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
