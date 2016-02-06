<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/*$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;*/

		$username = $this->username;
		$password = $this->password;
		$user = Staff::model()->findByAttributes(array('username'=>$username));
		if(!empty($user) && $user->password == hash('sha256', (hash('sha256', $user->created_date)).$this->password)){
				
			$users=array(
				// username => password
				$user->username => $user->password,
				//'admin'=>'admin',
			);
			$role = Staff::model()->with('depart')->findByPk($user->staff_id);
			$role = $role->role;
			if(strtolower($role) == 'exco'){
				Yii::app()->user->setState('role', 'exco');
			}elseif(strtolower($role) == 'superadmin'){
				Yii::app()->user->setState('role', 'superadmin');
			}else{
				Yii::app()->user->setState('role', 'staff');
			}
			Yii::app()->session['fname'] = $user->fname;
			Yii::app()->session['lname'] = $user->lname;
			Yii::app()->session['uid'] = $user->staff_id;
			$this->errorCode=self::ERROR_NONE;
		}else{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}

		
		return !$this->errorCode;
	}
}