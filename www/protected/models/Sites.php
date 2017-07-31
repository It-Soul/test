<?php

/**
 * This is the model class for table "sites".
 *
 * The followings are the available columns in table 'sites':
 * @property integer $id
 * @property string $name
 * @property string $url
 */
class Sites extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sites';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, url', 'length', 'max' => 55),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, url', 'safe', 'on' => 'search'),
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
            'selected' => array(self::HAS_MANY, 'Coefficients', 'site_name'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
        );
    }

    public function getSites()
    {
        $query = $this::model()->with(array('selected' => array(
            'joinType' => 'LEFT JOIN',
            'condition' => 'site_name is null'
        )))->findAll();
        $result = CHtml::listData($query, 'id', 'name');
        return $result;
    }

    /**
     * get list of all sites
     * @return static[]
     */
    public function getAllSites()
    {
        return self::model()->findAll();
    }

    /**
     * Get site by url
     * @param $url
     * @return static
     */
    public function getByUrl($url)
    {
        return self::model()->findByAttributes(array('url' => $url));
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sites the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
