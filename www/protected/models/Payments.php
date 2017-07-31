<?php

/**
 * This is the model class for table "payments".
 *
 * The followings are the available columns in table 'payments':
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property double $summa
 */
class Payments extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'payments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
		//	array('summa', 'required'),
            array('user_id, status', 'numerical', 'integerOnly' => true),
            array('summa', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, date, summa', 'safe', 'on' => 'search'),
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
            'date' => 'Дата',
            'summa' => 'Сума',
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('summa', $this->summa);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getUserSum($id)
    {

        $sum = 0;
        $items = Payments::model()->findAllByAttributes(array('user_id' => $id));
        foreach ($items as $item) {
            $sum += $item['summa'];
        }
        return $sum;
    }

    public function getUserSumDate($id, $date)
    {

        $sum = 0;
        $items = Payments::model()->findAllByAttributes(array('user_id' => $id, 'date' => $date));
        foreach ($items as $item) {
            $sum += $item['summa'];
        }
        return $sum;
    }

    protected function beforeSave()
    {
        if (!empty(Yii::app()->request->getPost('arrears_date'))) {
            $date = Yii::app()->request->getPost('arrears_date');
            $date = str_replace('.', '-', $date);
            $date = date('Y-m-d', strtotime($date));
            $this->date = $date;
        } else {
            $this->date = date('Y-m-d H:i:s', time());
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Payments the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
