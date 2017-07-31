<?php

/**
 * This is the model class for table "cart".
 *
 * The followings are the available columns in table 'cart':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $cod
 * @property string $quantity
 * @property double $price_out
 * @property double $price_in
 * @property double $price_in_sum
 * @property string $provider
 * @property string $manufacturer
 * @property string $photo
 * @property string $date
 * @property string $user_name
 * @property double $price_out_sum
 * @property double $is_advance
 */
class Cart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cart';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('user_id, name, cod, quantity, price_out, price_in, price_in_sum, provider, manufacturer, photo, date, user_name, price_out_sum', 'required'),
			array('user_id, is_advance', 'numerical', 'integerOnly' => true),
			array('price_out, price_in, price_in_sum, price_out_sum', 'numerical'),
			array('name, cod, quantity, provider, manufacturer, photo, user_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, name, cod, quantity, price_out, price_in, price_in_sum, provider, manufacturer, photo, date, user_name, price_out_sum', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'cod' => 'Cod',
			'quantity' => 'Quantity',
			'price_out' => 'Price Out',
			'price_in' => 'Price In',
			'price_in_sum' => 'Price In Sum',
			'provider' => 'Provider',
			'manufacturer' => 'Manufacturer',
			'photo' => 'Photo',
			'date' => 'Date',
			'user_name' => 'User Name',
			'price_out_sum' => 'Price Out Sum',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cod',$this->cod,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('price_out',$this->price_out);
		$criteria->compare('price_in',$this->price_in);
		$criteria->compare('price_in_sum',$this->price_in_sum);
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('price_out_sum',$this->price_out_sum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	public function getCartSum($id)
	{
		$sum = 0;
		$cart = Cart::model()->findAllByAttributes(array(
				'user_id' => $id,
			)
		);
		if ($cart) {
			foreach ($cart as $value) {
				$sum += $value['price_out_sum'];
			}
		}
		return $sum;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cart the static model class
	 */
	protected function beforeSave()
	{

		if ($this->isNewRecord) {

			$this->date = date('Y-m-d H:i:s');

		};



		return parent::beforeSave();
	}






	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
