<?php

/**
 * This is the model class for table "coefficients".
 *
 * The followings are the available columns in table 'coefficients':
 * @property integer $id
 * @property integer $site_name
 * @property double $logistic
 * @property double $vat
 * @property double $manager_coef
 * @property double $curator_coef
 * @property double $admin_coef
 * @property double $status
 */
class Coefficients extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'coefficients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_name, logistic, vat, manager_coef, curator_coef, admin_coef, status', 'required'),
            array('site_name,logistic, vat, manager_coef, curator_coef, admin_coef, status', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_name, logistic, vat, manager_coef, curator_coef, admin_coef, status', 'safe', 'on'=>'search'),
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
            'names' => array(self::BELONGS_TO, 'Sites', 'site_name')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'site_name' => 'Сайт',
			'logistic' => 'Логістика',
			'vat' => 'ВАТ',
			'manager_coef' => 'Коеф. менеджера',
			'curator_coef' => 'Коеф. куратора',
			'admin_coef' => 'Коеф. адміністратора',
			'status' => 'Статус'
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
        $criteria->compare('site_name', $this->sitename, true);
		$criteria->compare('logistic',$this->logistic);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('manager_coef',$this->manager_coef);
		$criteria->compare('curator_coef',$this->curator_coef);
		$criteria->compare('admin_coef',$this->admin_coef);
		$criteria->compare('status',$this->admin_coef);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getUserCoefficient($userId, $siteUrl)
    {
        $site = Sites::model()->getByUrl($siteUrl);

        return self::model()->findByAttributes(array(
            'user_id' => $userId,
            'site_name' => $site->id
        ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Coefficients the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function setCoefficients($coefficients)
    {
        return Yii::app()->db->createCommand("CALL coeficients_add(:logistic,:vat,:manager,:curator,:admin,:status,:site)")
            ->bindValue(':logistic', $coefficients['logistic'])
            ->bindValue(':vat', $coefficients['vat'])
            ->bindValue(':manager', $coefficients['manager_coef'])
            ->bindValue(':curator', $coefficients['curator_coef'])
            ->bindValue(':admin', $coefficients['admin_coef'])
            ->bindValue(':status', $coefficients['status'])
            ->bindValue(':site', $coefficients['site_name'])
            ->execute();
    }
}
