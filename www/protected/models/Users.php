<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $organisation
 * @property string $username
 * @property string $phone
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string $hashcode
 * @property integer $status
 * @property string $role
 * @property string $curator
 * @property string $reg_like
 * @property string $default_note
 * @property integer $opole
 * @property integer $martecs
 * @property string $ip
 * @property string $user_rol
 * @property string $advance
 * @property string $show_codes
 *
 * The followings are the available model relations:
 * @property Blackclist[] $blackclists
 * @property Cart[] $carts
 * @property UserPayment[] $userPayments
 * @property UsersDiscount[] $usersDiscounts
 *
 */
class Users extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    const ROLE_ADMIN = 'administrator';
    const ROLE_MODER = 'moderator';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';

    public $password_2;
    public $old_password;
    public $new_password;

    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, organisation, username,organisation_status, phone, country, region, city, reg_like, carrier, district', 'required'),
            array('status, opole, martecs, curator, user_rol, advance, show_codes', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 255),
            array('password', 'length', 'min' => 6, 'max' => 255),
            array('password,password_2', 'required', 'on' => 'register'),
            array('old_password,new_password', 'length', 'max' => 255),
            array('password_2', 'compare', 'compareAttribute' => 'password', 'on' => 'register'),
            array('organisation, username,district, role', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 20),
            array('hashcode', 'length', 'max' => 128),
            array('reg_like', 'length', 'max' => 100),
            array('ip', 'length', 'max' => 32),
            array('default_note', 'safe'),

            array('email', 'email'),
            array('email', 'unique', 'on' => 'register'),
//				array('email',    'match',   'pattern'    => '/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/', 'message' => 'Не вірний формат.'),
//				array('name,organisation,city', 'match',   'pattern'    => '/^[A-Za-z0-9_-А-Яа-я\s,]+$/u','message'  => 'Поле містить недопустимі символи.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, email, password, organisation, username, phone, carrier, country, city, hashcode,district,region, user_rol, status, role, reg_like, curator, default_note, opole, martecs, ip,advance', 'safe', 'on' => 'search'),
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
            'blackclists' => array(self::HAS_MANY, 'Blackclist', 'user_id'),
            'carts' => array(self::HAS_MANY, 'Cart', 'user_id'),
            'userPayments' => array(self::HAS_MANY, 'UserPayment', 'user_id'),
            'usersDiscounts' => array(self::HAS_MANY, 'UsersDiscount', 'user_id'),
            'userCity' => array(self::BELONGS_TO, 'City', 'city'),
            'provider' => array(self::HAS_ONE, 'ProviderPerson', 'user_id')
        );
    }
//	public function validatePassword($password)
//	{
//		return CPasswordHelper::verifyPassword($password,$this->password);
//	}
//
//	public function hashPassword($password)
//	{
//		return CPasswordHelper::hashPassword($password);
//	}
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'old_password' => 'Старий пароль',
            'new_password' => 'Новий пароль',
            'password' => 'Пароль',
            'password_2' => 'Повторення паролю',
            'organisation' => 'Назва організації',
            'username' => 'Ім\'я клієнта',
            'phone' => 'Номер телефону',
            'city' => 'Місто',
            'country' => 'Країна',
            'region' => 'Область',
            'hashcode' => 'Hashcode',
            'status' => 'Доступ',
            'role' => 'Роль',
            'reg_like' => 'Ви представляєте:',
            'default_note' => 'Інформація про клієнта',
            'opole' => 'Статус',
            'organisation_status' => 'Статус організації',
            'district' => '№ відділення',
            'martecs' => 'Менеджер',
            'carrier' => 'Перевізник',
            'ip' => 'Ip',
            'curator' => 'Куратор',
            'date' => 'Час реєстрації',
            'user_rol' => 'Тип',
            'advance' => 'Режим передоплати',
            'show_codes' => 'показати №/Індекс'
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

        $user = self::model()->findByPk(Yii::app()->user->id);

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('organisation', $this->organisation, true);
        $criteria->compare('organisation_status', $this->organisation_status, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('hashcode', $this->hashcode, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('reg_like', $this->reg_like, true);
        $criteria->compare('default_note', $this->default_note, true);
        $criteria->compare('opole', $this->opole);
        $criteria->compare('curator', $this->curator);
        $criteria->compare('martecs', $this->martecs);
        $criteria->compare('district', $this->district);
        $criteria->compare('region', $this->region, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('user_rol', $this->user_rol);
        $criteria->compare('advance', $this->advance);
//        $criteria->addCondition('status<>2');
        if (Yii::app()->user->getRole() != 'administrator') {
            if ($user['user_rol'] == 1) {
                if (Yii::app()->user->getRole() == 'courier') {
                    $criteria->addCondition('role<>:admin');
                    $criteria->addCondition('curator=:curator_id');
                    $criteria->addCondition('martecs=:manager_id', 'or');
                    $criteria->addCondition('role<>:admin', 'and');
                    $criteria->params = array(
                        ':admin' => 'administrator',
                        ':curator_id' => $user['curator'],
                        ':manager_id' => $user['martecs']
                    );
                }
                if (Yii::app()->user->getRole() == 'manager') {
                    $criteria->addCondition('role<>:admin');
                    $criteria->addCondition('role<>:courier');
                    $criteria->addCondition('martecs=:manager_id');
                    $criteria->params = array(
                        ':admin' => 'administrator',
                        ':courier' => 'courier',
                        ':manager_id' => $user['martecs']
                    );
                }
            }
        }

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => false,
                'sort' => array('defaultOrder' => array(
                    'organisation' => ''
                ))
            )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getArrears()
    {
        return Orders::model()->getUserArrears($this->id);
    }

    public function getAllUsers()
    {
        return Users::model()->findAll();
    }

    /**
     * @param $id
     * @return static
     */
    public static function getCountry($id){

        return self::model()->findByAttributes(array('id' =>$id));
    }

    protected function beforeSave()
    {

        if ($this->isNewRecord) {
            $this->password = md5($this->password);
            $this->date = date('Y-m-d H:i:s');
            $this->status = 0;
            $this->role = 'user';
            $this->ip = 'new';
        };
        if ($this->status == 2) {
            $this->role = 'banned';
        } else $this->role = $this->role;
        $this->update_date = time();

        if ($this->ip == 'new' && $this->status != 0) {
            self::sendConfirmEmail($this->email);
            $this->ip = 'old';
        }
//		foreach($_POST['Users']['curator'] as $curator=>$key) {
//			$this->curator = json_encode($_POST['Users']['curator'][$key]);
//		}
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $country = array(
                '9908',
                '1012',
                '2897',
                '9705'
            );
            $sites = Sites::model()->getAllSites();
            foreach ($sites as $site) {
                Yii::app()->db->createCommand()->insert('coefficients', array(
                    'site_name' => $site->id,
                    'logistic' => 1,
                    'vat' => 1,
                    'manager_coef' => 1,
                    'curator_coef' => 1,
                    'admin_coef' => 1,
                    'user_id' => $this->id,
                    'status' => 1
                ));
            }
            Yii::app()->db->createCommand()->insert('provider_person', array(
                'user_id' => $this->id,
                'status' => 0,
                'status_hint' => 0,
                'status_country' => 0,
                'data_count' => 0,
                'country_id' => $this->country,
                'country_delivery' => 0,
                'country_logistic' => 1,
                'country_vat' => 1,
                'uploading_status' => 0,
                'updating_status' => 0,
                'allowed_products_amount' => 0,
                'file_uploading_status' => 0,
                'relevance_check_status' => 0,
                'country_hint' => '',
                'file_updating_status' => '',
                'uploaded_products_amount' => 0
            ));

            foreach ($country as $item) {
                Yii::app()->db->createCommand()->insert('country_coef', array(
                    'country_id' => $item,
                    'user_id' => $this->id,
                    'vat' => 1,
                    'manager_coef' => 1,
                    'curator_coef' => 1,
                    'admin_coef' => 1,
                    'status' => 0
                ));
            }
        }
        $provider = ProviderPerson::model()->findByAttributes(array('user_id' =>$this->id));
        if($provider){
            $provider->country_id = $this->country;
            $provider->update(false);
        }

        return parent::afterSave();
    }

    public function sendConfirmEmail($email)
    {

        $subject = 'Підтвердження акаунту на сайті ' . Yii::app()->request->hostInfo;
        $body = 'Ваш акаунт на сайті ' . Yii::app()->request->hostInfo . ' підтверджений і готовий до використання.<br/> Дякуємо що Ви з нами.<br/><br/> З повагою адміністрація сайту ' . Yii::app()->request->hostInfo;
        $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n" . 'From: Lc-parts' . "\r\n";

        mail($email, $subject, $body, $headers);

    }

    public function getUserName($user_id)
    {
        $user = Users::model()->findByAttributes(array('id' => $user_id));

        return '<a href="/admin/users/update?id=' . $user->id . '">' . $user->organisation . '&nbsp;&nbsp;&nbsp;' . $user->organisation_status . '</a>';
    }

    public function getFullName()
    {
        $phone = substr($this->phone, 3, strlen($this->phone));
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);

        return $this->organisation . " " . $this->organisation_status . ' (' . $phone . ')';
    }

    public function getById($userId)
    {
        return self::findByPk($userId);
    }
}
