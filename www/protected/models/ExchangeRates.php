<?php

/**
 * This is the model class for table "exchange_rates".
 *
 * The followings are the available columns in table 'exchange_rates':
 * @property integer $id
 * @property double $zloty
 * @property double $zloty_repair
 * @property double $euro
 * @property double $euro_repair
 * @property double $us_dollar
 * @property double $us_dollar_repair
 * @property double $auto
 * @property double $status
 * @property double $advance
 */
class ExchangeRates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exchange_rates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, zloty, zloty_repair, euro, euro_repair, us_dollar, us_dollar_repair', 'required'),
			array('id, auto, status', 'numerical', 'integerOnly'=>true),
			array('zloty, zloty_repair, euro, euro_repair, us_dollar, us_dollar_repair', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, zloty, zloty_repair, euro, euro_repair, us_dollar, us_dollar_repair, auto, status', 'safe', 'on'=>'search'),
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
			'zloty' => 'PLN',
			'zloty_repair' => 'Коригування курсу (PLN)',
			'euro' => 'EUR',
			'euro_repair' => 'Коригування курсу (EUR)',
			'us_dollar' => 'USD',
			'us_dollar_repair' => 'Коригування курсу (USD)',
			'auto' => 'auto',
			'status' => 'status'
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
		$criteria->compare('zloty',$this->zloty);
		$criteria->compare('zloty_repair',$this->zloty_repair);
		$criteria->compare('euro',$this->euro);
		$criteria->compare('euro_repair',$this->euro_repair);
		$criteria->compare('us_dollar',$this->us_dollar);
		$criteria->compare('us_dollar_repair',$this->us_dollar_repair);
		$criteria->compare('auto',$this->auto);
		$criteria->compare('status',$this->status);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getExchangeRates(){
		$result = ExchangeRates::model()->findByPk(1);
		return $result;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExchangeRates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getFinalZlotyCourse()
    {
        return round($this->zloty + (($this->zloty * $this->zloty_repair) / 100), 2);
    }

    public function getFinalEuroCourse()
    {
        return round($this->euro + (($this->euro * $this->euro_repair) / 100), 2);
    }

    public function getFinalUsDollarCourse()
    {
        return round($this->us_dollar + (($this->us_dollar * $this->us_dollar_repair) / 100), 2);
    }

    public static function getActualCurs($currency){
        $exchange_rates =   self::model()->getExchangeRates();
        switch ($currency){
            case 'PLN':
                return $exchange_rates->getFinalZlotyCourse();
                break;
            case 'USD':
                return $exchange_rates->getFinalUsDollarCourse();
                break;
            case 'EUR':
                return $exchange_rates->getFinalEuroCourse();
                break;
            default:
                return 1;
        }
    }
}
