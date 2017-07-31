<?php

/**
 * This is the model class for table "provider_person".
 *
 * The followings are the available columns in table 'provider_person':
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $status_hint
 * @property integer $status_country
 * @property integer $data_count
 * @property integer $country_id
 * @property integer $country_delivery
 * @property double $country_logistic
 * @property double $country_vat
 * @property integer $uploading_status
 * @property integer $updating_status
 * @property integer $allowed_products_amount
 * @property integer $file_uploading_status
 * @property integer $file_updating_status
 * @property integer $relevance_check_status
 * @property integer $uploaded_products_amount
 * @property string $country_hint
 */
class ProviderPerson extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'provider_person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array(
                'user_id,
			     status,
			     status_hint,
			     status_country,
			     data_count, country_id,
			     country_delivery,
			     uploading_status,
			     updating_status,
			     allowed_products_amount,
			     file_uploading_status, 
			     file_updating_status,
			     relevance_check_status,
			     uploaded_products_amount',

                'numerical',
                'integerOnly' => true),
			array('country_logistic, country_vat', 'numerical'),
            array('country_hint', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
            array('id, user_id, status, status_hint, status_country, data_count, country_id, country_delivery, country_logistic, country_vat, uploading_status, updating_status, allowed_products_amount, file_uploading_status, file_updating_status, relevance_check_status, country_hint', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
			'country'=>array(self::BELONGS_TO,'Country','country_id'),
            'username'=>array(self::BELONGS_TO,'Users','user_id'),
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
            'status' => 'Статус',
            'status_hint' => 'Підказка внутрішньої логістики по країні',
            'status_country' => 'Відображати країну походження товару (біля назви товару)',
            'data_count' => 'Перевірка активності через',
            'country_id' => 'Країна поставки',
            'country_delivery' => 'Термін поставки',
            'country_logistic' => 'Коефіцієнт логістики від клієнта',
            'country_vat' => 'ВАТ',
            'uploading_status' => 'Дозволити клієнтові особисто завантажувати товар',
            'updating_status' => 'Дозволити клієнту редагувати завантажений товар',
            'allowed_products_amount' => 'Дозволена кількість поштучного завантаження',
            'file_uploading_status' => 'Дозволити клієнтові особисто завантажувати файл',
            'file_updating_status' => 'Дозволити клієнту редагувати завантажений файл',
            'relevance_check_status' => 'Перевірка актуальності товару через',
            'country_hint' => '',
            'uploaded_products_amount' => ''
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
		$criteria->compare('status',$this->status);
		$criteria->compare('status_hint',$this->status_hint);
		$criteria->compare('status_country',$this->status_country);
		$criteria->compare('data_count',$this->data_count);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('country_delivery',$this->country_delivery);
		$criteria->compare('country_logistic',$this->country_logistic);
		$criteria->compare('country_vat',$this->country_vat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProviderPerson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * cheks if user is a provider
     * @param $user_id
     * @return int
     */
    public static function getProviderStatus($user_id)
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $user_id));

        return $provider->status;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getProviderCountry($user_id)
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $user_id));

        return $provider->country->name;
    }
    /**
     * disable providering for user
     * @param $user_id
     * @return bool
     */
    public static function setDisabled($user_id)
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $user_id));
        if (!$provider) {
            $provider = new ProviderPerson();
            $provider->user_id = $user_id;
        }
        $provider->status = 0;

        if ($provider->save(false)) {
            return true;
        }

        return false;

    }

    /**
     * enable providering for user
     * @param $user_id
     * @return bool
     */
    public static function setEnabled($user_id)
    {
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' => $user_id));
        if (!$provider) {
            $provider = new ProviderPerson();
            $provider->user_id = $user_id;
        }
        $provider->status = 1;

        if ($provider->save(false)) {
            return true;
        }

        return false;

    }

    /**
     * get provider access data by user_id
     * @param $user_id
     * @return static
     */
    public static function getProviderAccess($user_id)
    {
        return self::model()->findByAttributes(array(
            'user_id' => $user_id
        ));
    }

    public static function getUploadedProductsCount($userId)
    {
        return Results_add::model()->countByAttributes(array('user_id' => $userId, 'file_id' => 0));
    }
}
