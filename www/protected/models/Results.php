<?php

/**
 * This is the model class for table "Results".
 *
 * The followings are the available columns in table 'Results':
 * @property integer $id
 * @property string $result_name
 * @property string $result_photo
 * @property integer $result_manufacturer
 * @property double $result_price
 * @property double $result_state
 * @property double $info
 * @property double provider_id
 */
class results extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'results';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('result_name, result_photo, result_manufacturer, result_price', 'required'),
			array('user_id,product_id,provider_id', 'numerical', 'integerOnly'=>true),
			array('result_price,def_price', 'numerical'),
			array('result_name, result_photo,result_info,result_cod,site, result_state', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, query, result_name, result_photo, result_manufacturer,provider_id, result_price', 'safe'),
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
			'users'=>array(self::BELONGS_TO,'Users','user_id'),
            'providerinfo'=>array(self::BELONGS_TO,'ProviderPerson','provider_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'result_name' => 'Назва<i class="icon-chevron-down"></i><i class="icon-chevron-up"></i>',
			'result_photo' => 'Зображення',
			'result_manufacturer' => 'Виробник<i class="icon-chevron-down"></i><i class="icon-chevron-up"></i>',
			'result_price' => 'Ціна,грн<i class="icon-chevron-down"></i><i class="icon-chevron-up"></i>',
			'result_info' => '',

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

		$criteria->condition = 'user_id = :user_id';
		$criteria->params = array(':user_id' => Yii::app()->user->id);

		$criteria->compare('id',$this->id);
		$criteria->compare('result_name',$this->result_name,true);
		$criteria->compare('result_photo',$this->result_photo,true);
		$criteria->compare('result_manufacturer',$this->result_manufacturer);
		$criteria->compare('result_price',$this->result_price);
		$criteria->compare('result_info',$this->result_info);
		$criteria->compare('result_state',$this->result_state);
		$criteria->compare('info',$this->info);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('query',$this->query);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return results the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return static
     */
	public function getProvider(){
		$provider = ProviderPerson::model()->findByAttributes(array('user_id'=>$this->user_id));
		return $provider;
	}
}
