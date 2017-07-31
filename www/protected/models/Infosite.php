<?php

/**
 * This is the model class for table "infosite".
 *
 * The followings are the available columns in table 'infosite':
 * @property integer $site_id
 * @property string $name
 * @property string $url
 * @property string $login
 * @property string $password
 * @property integer $status
 */
class Infosite extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'infosite';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//			array('site_id, login, password, status', 'required'),
            array('site_id, status', 'numerical', 'integerOnly' => true),
            array('name, url', 'length', 'max' => 55),
            array('login, password', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, name, url, login, password, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'site_id' => 'Site',
            'name' => 'Name',
            'url' => 'Url',
            'login' => 'Login',
            'password' => 'Password',
            'status' => 'Status',
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

        $criteria = new CDbCriteria;

        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Infosite the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
