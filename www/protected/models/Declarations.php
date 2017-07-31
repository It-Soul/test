<?php

/**
 * This is the model class for table "declarations".
 *
 * The followings are the available columns in table 'declarations':
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property string $declar_numb
 * @property integer $places_numb
  * @property integer $status
 * @property string $courier
 * @property string $comment
 */
class declarations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'declarations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('user_id, date, declar_numb, places_numb, comment', 'required'),
			array('user_id, places_numb,status', 'numerical', 'integerOnly'=>true),
			array('declar_numb', 'length', 'max'=>20),
			array('courier', 'length', 'max'=>50),
			array('comment', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, date, declar_numb, places_numb, courier,status, comment', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'date' => 'Дата',
			'declar_numb' => 'Номер декларації',
			'places_numb' => 'Кількість',
			'courier' => 'Перевізник',
			'comment' => 'Коментарі',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('declar_numb',$this->declar_numb,true);
		$criteria->compare('places_numb',$this->places_numb);
		$criteria->compare('courier',$this->courier,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->comment,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return declarations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave(){
		$this->date = date('Y-m-d',strtotime(Yii::app()->request->getPost('date')));
		return parent::beforeSave();
	}
}
