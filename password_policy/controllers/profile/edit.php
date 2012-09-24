<?php 
/**
Module Name : Edit user
Description: Edits the existing user with the additional validations for password.
Author Name: Navya H.K
 **/
defined('C5_EXECUTE') or die("Access Denied.");
Loader::model('user_attributes');
Loader::model('attribute/categories/collection');
class ProfileEditController extends Controller {

	public $helpers = array('html', 'form', 'date');
	
	public function __construct() {
		$html = Loader::helper('html');
		parent::__construct();
		$u = new User();
		if (!$u->isRegistered()) {
			$this->set('intro_msg', t('You must sign in order to access this page!'));
			Loader::controller('/login');
			$this->render('/login');
		}
		$this->set('ui', UserInfo::getByID($u->getUserID()));
		$this->set('av', Loader::helper('concrete/avatar'));
	}
	
	public function on_start() {
		$this->addHeaderItem(Loader::helper('html')->css('ccm.profile.css'));
	}

	public function save_complete() {
		$this->set('message', t('Profile Information Saved.'));
	}
	
	
	public function save() { 
		$ui = $this->get('ui');

		$uh = Loader::helper('concrete/user');
		$th = Loader::helper('text');
		$vsh = Loader::helper('validation/strings');
		$cvh = Loader::helper('concrete/validation');
		$e = Loader::helper('validation/error');
		/*loads password policy library*/
		Loader::library('password', 'password_policy');

	
		$data = $this->post();
		
		/* 
		 * Validation
		*/
		
		// validate the user's email
		$email = $this->post('uEmail');
		if (!$vsh->email($email)) {
			$e->add(t('Invalid email address provided.'));
		} else if (!$cvh->isUniqueEmail($email) && $ui->getUserEmail() != $email) {
			$e->add(t("The email address '%s' is already in use. Please choose another.",$email));
		}

		// password
		$userName = $ui->getUserName();
		if(strlen($data['uPasswordNew'])) {
			$passwordNew = $data['uPasswordNew'];
			$passwordNewConfirm = $data['uPasswordNewConfirm'];
			
			/*if ((strlen($passwordNew) < USER_PASSWORD_MINIMUM) || (strlen($passwordNew) > USER_PASSWORD_MAXIMUM)) {
				$e->add(t('A password must be between %s and %s characters', USER_PASSWORD_MINIMUM, USER_PASSWORD_MAXIMUM));
			}*/		
			
			if (strlen($passwordNew) >= USER_PASSWORD_MINIMUM && !$cvh->password($passwordNew)) {
				$e->add(t('A password may not contain ", \', >, <, or any spaces.'));
			}
			/*validates the entered password */
			PasswordPolicy::validatePassword($userName ,$passwordNew,$e);
			$pkg = Package::getByHandle('password_policy');
			$passwordRepeatInterval = $pkg->config('password_repeat_interval');
			$userID = $ui->getUserID();
			/*encrypts the given password*/
			$encryptedPassword = User::encryptPassword($passwordNew);
			$passwordList = PasswordPolicy::getPassword($passwordRepeatInterval,$userID);
			$allPasswords = PasswordPolicy::getAllPasswords($userID,$encryptedPassword);
			/*validation for password expiry date*/
						$passwordCount = intval($allPasswords[0]['count(*)']);
		
						if($passwordCount>0){
							$this->error->add(t('You cannot use this password for '.$passwordExpiryTime.' day(s).'));
						}
			/*checks password if the user enters the same old password again*/
			if (in_array($encryptedPassword, $passwordList)) {
					$e->add(t('The Password was already used by you .please enter diffrent password'));
			
			}

			if ($passwordNew) {
				if ($passwordNew != $passwordNewConfirm) {
					$e->add(t('The two passwords provided do not match.'));
				}
			}
			$data['uPasswordConfirm'] = $passwordNew;
			$data['uPassword'] = $passwordNew;
		}	
		
		$aks = UserAttributeKey::getEditableInProfileList();

		foreach($aks as $uak) {
			if ($uak->isAttributeKeyRequiredOnProfile()) {
				$e1 = $uak->validateAttributeForm();
				if ($e1 == false) {
					$e->add(t('The field "%s" is required', $uak->getAttributeKeyName()));
				} else if ($e1 instanceof ValidationErrorHelper) {
					$e->add($e1);
				}
			}
		}

		if (!$e->has()) {		
			$data['uEmail'] = $email;		
			if(ENABLE_USER_TIMEZONES) {
				$data['uTimezone'] = $this->post('uTimezone');
			}
			
			$ui->update($data);
			if($encryptedPassword!=NULL){
				/*saves all updated user information to the database*/
				PasswordPolicy::savePassword($encryptedPassword,$ui->getUserID(),$ui->getUserName(),$ui->getUserEmail());
			}
			
			foreach($aks as $uak) {
				$uak->saveAttributeForm($ui);				
			}
			$this->redirect("/profile/edit", "save_complete");
		} else {
			$this->set('error', $e);
		}
	}
}

?>
