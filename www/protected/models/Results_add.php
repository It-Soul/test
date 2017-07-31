<?php

/**
 * This is the model class for table "results_add".
 *
 * The followings are the available columns in table 'results_add':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $photo
 * @property string $manufacturer
 * @property double $price
 * @property double $weight
 * @property integer $file_id
 * @property string $state
 * @property string $currency
 * @property string $cod
 * @property string $date
 * @property string $last_check
 */
class Results_add extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $image;
	public function tableName()
	{
		return 'results_add';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name, cod', 'required'),
            array('user_id, file_id', 'numerical', 'integerOnly' => true),
            array('price, weight', 'numerical'),
            array('name, photo, manufacturer, state, cod, currency', 'length', 'max' => 255),
		//	array('image', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1048576),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
            array('id, user_id, name, photo, manufacturer, price, weight, file_id, state, currency,date,cod', 'safe', 'on' => 'search'),
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
			'user_id' => 'User',
			'name' => 'Назва запчастини',
			'photo' => 'Фото',
			'manufacturer' => 'Виробник запчастини',
			'price' => 'ціна на запчастину',
            'weight' => 'weight',
            'file_id' => 'Info',
			'state' => 'Кількість яка в наявності',
			'image' =>'Фото',
			'cod' =>'Оригінальний № запчастини'

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
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('manufacturer',$this->manufacturer,true);
		$criteria->compare('price',$this->price);
        $criteria->compare('weight', $this->weight);
        $criteria->compare('file_id', $this->file_id, true);
		$criteria->compare('state',$this->state,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	protected function beforeSave(){

        $this->cod = preg_replace('![^\w\d\s]*!', '', $this->cod);
		return parent::beforeSave();
	}
//	protected function afterSave()
//	{
//        if (isset($_POST['Numbers_add']['number'])) {
//            foreach ($_POST['Numbers_add']['number'] as $items) {
//                Yii::app()->db->createCommand()->insert('numbers_add', array(
//                    'user_id' => Yii::app()->user->id,
//                    'results_add_id' => $this->id,
//                    'number' => $items,
//                ));
//            }
//        }
//
//		parent::afterSave(); // TODO: Change the autogenerated stub
//	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Results_add the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getProvider()
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $this->user_id));

        return $provider;
    }

    public static function getProductsByCode($code)
    {
        $productIds = [];

        $numbersQuery = Yii::app()->db->cache(1000)->createCommand()
            ->select('n.results_add_id AS product_id')
            ->from('numbers_add n ')
            ->where('n.number LIKE :query', array('query' => "%$code"))
            ->getText();

        $products = Yii::app()->db->cache(1000)->createCommand()
            ->select('r.id AS product_id')
            ->from('results_add r')
            ->where('r.cod LIKE :query', array('query' => "%$code"))
            ->union($numbersQuery)
            ->queryAll();

        if ($products) {
            foreach ($products as $product) {
                $productIds[] = $product['product_id'];
            }
        }

        return Yii::app()->db->cache(1000)->createCommand()
            ->select('r.id, r.user_id, r.name, r.photo, r.manufacturer, r.price, r.cod,r.currency, p.id AS providerperson')
            ->from('results_add r')
            ->join('provider_person p', 'r.user_id = p.user_id')
            ->where(array('in', 'r.id', array_values($productIds)))
            ->andWhere('status=:status', array('status' => 1))
            ->queryAll();
    }
}
