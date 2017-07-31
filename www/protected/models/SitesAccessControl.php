<?php

/**
 * This is the model class for table "sites_access_control".
 *
 * The followings are the available columns in table 'sites_access_control':
 * @property integer $id
 * @property integer $site_id
 * @property string $login
 * @property string $password
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Sites $sites
 */
class SitesAccessControl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sites_access_control';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('site_id, login, password, status', 'required'),
            array('site_id, status', 'numerical', 'integerOnly' => true),
            array('login, password', 'length', 'max' => 255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
            array('id, site_id, login, password, status', 'safe', 'on' => 'search'),
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
            'siteinfo' => array(self::HAS_ONE, 'Sites', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'site_id' => 'Сайт',
			'login' => 'Логін',
			'password' => 'Пароль',
            'status' => 'Статус',
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
        $criteria->compare('site_id', $this->site_id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
        $criteria->compare('status', $this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitesAccessControl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
