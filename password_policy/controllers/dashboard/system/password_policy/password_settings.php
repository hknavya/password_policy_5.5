<?php
/**
Module Name : password policy settings contoller
Description: controlls the password settings user interface.
Author Name: Navya H.K
**/
defined('C5_EXECUTE') or die(_("Access Denied."));
class DashboardSystemPasswordPolicyPasswordSettingsController extends Controller{
	/*gets the value from database and sets default values for the following fields in the ui*/
	public function view(){
		$co = new Config();
		$pkg=Package::getByHandle('password_policy');	
		$co->setPackageObject($pkg);
		$this->set('passwordResetInterval', $co->get('password_reset_interval'));
		$this->set('passwordRepeatInterval', $co->get('password_repeat_interval'));
		$this->set('passwordExpiryTime', $co->get('password_expiry_time'));
		$this->set('passwordLoginAttempt', $co->get('password_login_attempt'));
		$this->set('passwordLength', $co->get('password_length'));
		$this->set('minUppercase', $co->get('min_uppercase'));
		$this->set('minLowercase', $co->get('min_lowercase'));
		$this->set('minNumericCharacter', $co->get('min_numeric_character'));
		$this->set('minNonAlphanumeric', $co->get('min_non_alphanumeric'));
		$this->set('minConsecutiveCharacter', $co->get('min_consecutive_character'));




	}

	public function save(){
		/*Adds a required field and tests that it is integer only.*/
		$val = Loader::helper('validation/form');
		$val->setData($_POST);
		$val->addInteger('password_reset_interval', 'password reset interval should only contain numbers.');
		$val->addInteger('password_repeat_interval', 'password repeat interval should only contain numbers.');
		$val->addInteger('password_expiry_time', 'password expiry time should only contain numbers.');
		$val->addInteger('password_login_attempt', 'password expiry time should only contain numbers.');
		$val->addInteger('password_length', 'password length should only contain numbers.');
		$val->addInteger('min_uppercase', 'minimum Upper case should only contain numbers.');
		$val->addInteger('min_lowercase', 'minimum lower case should only contain numbers.');
		$val->addInteger('min_numeric_character', 'minimum numeric character should only contain numbers.');
		$val->addInteger('min_non_alphanumeric', 'minimum alpha numeric character should only contain numbers.');
		$val->addInteger('min_consecutive_character', 'minimum consecutive number should only contain numbers.');
		
		if ($val->test()) {
			/*saves the post values to database*/
			$co = new Config();
			$pkg=Package::getByHandle('password_policy');	
			$co->setPackageObject($pkg);
			$co->save('password_reset_interval',$this->post('password_reset_interval'));
			$co->save('password_repeat_interval',$this->post('password_repeat_interval'));
			$co->save('password_expiry_time',$this->post('password_expiry_time'));
			$co->save('password_login_attempt',$this->post('password_login_attempt'));
			$co->save('password_length',$this->post('password_length'));
			$co->save('min_uppercase',$this->post('min_uppercase'));
			$co->save('min_lowercase',$this->post('min_lowercase'));
			$co->save('min_numeric_character',$this->post('min_numeric_character'));
			$co->save('min_non_alphanumeric',$this->post('min_non_alphanumeric'));
			$co->save('min_consecutive_character',$this->post('min_consecutive_character'));
			$this->set('message',t('Settings saved.'));
			$this->view();

		}else{
			$error = array();
			$error = $val->getError()->getList();
 			$this->set('error', $error);
		}

		
		
	}

}
