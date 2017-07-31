<?php

/**
 * This is the model class for table "Calendar".
 *
 * The followings are the available columns in table 'Calendar':
 * @property integer $id
 * @property string $data
 * @property string $name
 * @property string $sklep
 * @property string $name_1
 * @property string $sklep_1
 * @property string $name_2
 * @property string $sklep_2
 * @property string $name_3
 * @property string $sklep_3
 * @property string $name_4
 * @property string $sklep_4
 * @property string $name_5
 * @property string $sklep_5
 * @property string $name_6
 * @property string $sklep_6
 * @property string $name_7
 * @property string $sklep_7
 * @property string $name_8
 * @property string $sklep_8
 * @property string $name_9
 * @property string $sklep_9
 */
class Calendar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calendar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('data', 'required'),
			array('name, sklep, name_1, sklep_1, name_2, sklep_2, name_3, sklep_3, name_4, sklep_4, name_5, sklep_5, name_6, sklep_6, name_7, sklep_7, name_8, sklep_8, name_9, sklep_9', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, data, name, sklep, name_1, sklep_1, name_2, sklep_2, name_3, sklep_3, name_4, sklep_4, name_5, sklep_5, name_6, sklep_6, name_7, sklep_7, name_8, sklep_8, name_9, sklep_9', 'safe', 'on'=>'search'),
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
			'data' => 'Дата',
			'name' => 'Імя',
			'sklep' => 'Склад',
			'name_1' => 'Імя',
			'sklep_1' => 'Склад',
			'name_2' => 'Імя',
			'sklep_2' => 'Склад',
			'name_3' => 'Імя',
			'sklep_3' => 'Склад',
			'name_4' => 'Імя',
			'sklep_4' => 'Склад',
			'name_5' => 'Імя',
			'sklep_5' => 'Склад',
			'name_6' => 'Імя',
			'sklep_6' => 'Склад',
			'name_7' => 'Імя',
			'sklep_7' => 'Склад',
			'name_8' => 'Імя',
			'sklep_8' => 'Склад',
			'name_9' => 'Імя',
			'sklep_9' => 'Склад',
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
		$criteria->compare('data',$this->data,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sklep',$this->sklep,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Calendar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave(){
		$this->data=date('Y-m-d',strtotime($this->data));
		return parent::beforeSave();
	}

    public function getDateInfo($date)
    {
        return Yii::app()->db->createCommand()
            ->select('*')
            ->from('calendar')
            ->where('data=:date', array(':date' => $date))
            ->queryRow();
    }
}
