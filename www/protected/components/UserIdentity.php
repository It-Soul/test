<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_email;
	public function authenticate()
	{
		$email = $_POST['LoginForm']['email'];
		$user = Users::model()->find('LOWER(email)=?',array($email));


		if(($user===null) || (md5($this->password)!==$user->password) || $user->role=='banned' || $user->status!=1)
			$this->errorCode=self::ERROR_USERNAME_INVALID;

		else
		{
			$this->_id=$user->id;
			$this->_email=$user->email;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->_id;
	}

}