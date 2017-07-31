<?php

/**
 * This is the model class for table "results_admin".
 *
 * The followings are the available columns in table 'results_admin':
 * @property integer $id
 * @property integer $user_id
 * @property string $result_name
 * @property string $result_photo
 * @property string $result_manufacturer
 * @property double $result_price
 * @property string $result_info
 * @property double $def_price
 * @property string $site
 * @property string $result_cod
 * @property string $result_state
 * @property string $info
 * @property string $query
 * @property integer $product_id
 * @property integer provider_id
 */
class Results_admin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'results_admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id, result_name, result_photo, result_manufacturer, result_price, result_info, def_price, site, result_cod, result_state, info, query, product_id', 'required'),
			array('id, user_id, product_id,provider_id', 'numerical', 'integerOnly'=>true),
			array('result_price, def_price', 'numerical'),
			array('result_name, result_photo, result_manufacturer, result_info, site, result_cod, result_state, info, query', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, result_name, result_photo, provider_id,result_manufacturer, result_price, result_info, def_price, site, result_cod, result_state, info, query, product_id', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('result_name',$this->result_name,true);
		$criteria->compare('result_photo',$this->result_photo,true);
		$criteria->compare('result_manufacturer',$this->result_manufacturer,true);
		$criteria->compare('result_price',$this->result_price);
		$criteria->compare('result_info',$this->result_info,true);
		$criteria->compare('def_price',$this->def_price);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('result_cod',$this->result_cod,true);
		$criteria->compare('result_state',$this->result_state,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('query',$this->query,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('provider_id',$this->provider_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false,
		));
	}

    public function getProvider()
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $this->user_id));
        return $provider;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Results_admin the static model class
	 */

    public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
