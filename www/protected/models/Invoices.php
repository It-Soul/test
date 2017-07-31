<?php

/**
 * This is the model class for table "invoices".
 *
 * The followings are the available columns in table 'invoices':
 * @property integer $id
 * @property string $date
 * @property double $sum
 * @property integer $user_id
 */
class Invoices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('sum', 'numerical'),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, sum, user_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Дата',
			'sum' => 'Сума',
			'user_id' => 'User',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function createOrUpdateInvoice($date)
	{
		$users = Orders::model()->findAll(array(
			'select' => 't.user_id',
			'group' => 't.user_id',
			'order' => 't.user_id DESC',
            'condition' => 't.date_logistic=:date_logistic AND t.ordered=:ordered AND t.send=:send AND quantity<>0',
			'params' => array('date_logistic' => $date, 'ordered' => 1, 'send' => 1),
		));
		if ($users) {
			foreach ($users as $user) {

				$invoice = Invoices::findByAttributes(array('date' => $date, 'user_id' => $user->user_id));
				if (!$invoice) {
					$invoice = new Invoices();
				}
				$invoice->date = $date;
				$invoice->sum = Orders::model()->getUserSumByDateLogistic($user->user_id, $date, 1, 1)['price_out_sum'];
				$invoice->user_id = $user->user_id;
				$invoice->save(false);

				$status = Payments::model()->findByAttributes(array('date' => $date, 'user_id' => $user->user_id));
				if (!$status) {
					$status = new Payments();
				}
				$status->date = $date;
				$status->user_id = $user->user_id;
				$status->summa = Orders::model()->getUserSumByDateLogistic($user->user_id, $date, 1, 1)['price_out_sum'];
				$status->status = 1;
				$status->save(false);
			}
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
