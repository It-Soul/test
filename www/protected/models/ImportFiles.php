<?php

/**
 * This is the model class for table "import_files".
 *
 * The followings are the available columns in table 'import_files':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $real_file_name
 * @property integer $positions_amount
 * @property string $created_at
 * @property string $last_check
 */
class ImportFiles extends CActiveRecord
{

    public $currency;
    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'import_files';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('currency, name, file', 'required'),
//            array('user_id, positions_amount', 'numerical', 'integerOnly' => true),
//            array('name, real_file_name', 'length', 'max' => 255),
//            array('created_at, last_check, currency', 'safe'),
            array('file', 'file', 'types' => 'xls, xlsx, csv'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, name, real_file_name, positions_amount, created_at, last_check, currency', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'user_id' => 'User',
            'name' => 'Вкажіть ім\'я завантажуваного файлу',
            'real_file_name' => 'Real File Name',
            'positions_amount' => 'Positions Amount',
            'created_at' => 'Created At',
            'last_check' => 'Last Check',
            'currency' => 'Вкажіть валюту',
            'file' => 'Виберіть файл для завантаження',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('real_file_name', $this->real_file_name, true);
        $criteria->compare('positions_amount', $this->positions_amount);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('last_check', $this->last_check, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ImportFiles the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
