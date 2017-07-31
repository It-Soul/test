<?php

/**
 * This is the model class for table "country_coef".
 *
 * The followings are the available columns in table 'country_coef':
 * @property integer $id
 * @property integer $country_id
 * @property integer $user_id
 * @property double $vat
 * @property double $manager_coef
 * @property double $curator_coef
 * @property double $admin_coef
 * @property integer $status
 */
class CountryCoef extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'country_coef';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country_id, user_id,status', 'numerical', 'integerOnly' => true),
            array('vat, manager_coef, curator_coef, admin_coef', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, country_id, user_id, vat, manager_coef, curator_coef, admin_coef,status', 'safe', 'on' => 'search'),
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
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
//            'countrysad' => array(self::BELONGS_TO, 'Sites', 'site_name')


        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'country_id' => 'Країна',
            'user_id' => 'User',
            'vat' => 'ВАТ',
            'manager_coef' => 'Коеф.менеджера',
            'curator_coef' => 'Коеф.куратора',
            'admin_coef' => 'Коеф.адміна',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('vat', $this->vat);
        $criteria->compare('manager_coef', $this->manager_coef);
        $criteria->compare('curator_coef', $this->curator_coef);
        $criteria->compare('admin_coef', $this->admin_coef);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CountryCoef the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getFinalCoef($id, $country)
    {

        $coeficients = self::model()->findByAttributes(array('user_id' => $id, 'country_id' => $country));

        $rs =  $coeficients['manager_coef'] * $coeficients['curator_coef'] * $coeficients['admin_coef'];

        return array(
            'rs' => $rs,
            'status' => $coeficients['status']
        );
    }

}
