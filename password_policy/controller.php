<?php 
/**
	Module Name : password policy package controller
	Description: controlls the whole package by adding single pages, saving default values to database.
	Author Name: Navya H.K.  
**/ 
defined('C5_EXECUTE') or die(_("Access Denied."));

class PasswordPolicyPackage extends Package {

	protected $pkgHandle = 'password_policy';
	protected $appVersionRequired = '5.2.0';
	protected $pkgVersion = '1.1.0';

	public function getPackageDescription() {
		return t("Admin can set specific password settings for the users.");
	}

	public function getPackageName() {
		return t("Password Policy");
	}
	
	public function install() {
		$pkg = parent::install();
		$co = new Config(); 
		$pkgName = $pkg->getPackageName();
		$co->setPackageObject($pkg);
		/*saves default values to the database*/
		$co->save('password_reset_interval','30');
		$co->save('password_repeat_interval','3');
		$co->save('password_expiry_time','30');
		$co->save('password_login_attempt','5');
		$co->save('password_length','5');
		$co->save('min_uppercase','1');
		$co->save('min_lowercase','1');
		$co->save('min_numeric_character','1');
		$co->save('min_non_alphanumeric','1');
		$co->save('min_consecutive_character','1');
		/*installs all the  required system single pages */
		Loader::model('single_page');
		$p1 = SinglePage::add('/dashboard/system/password_policy/password_settings',$pkg);
		$p1->update(array('cName'=>t("Password Settings"), 'cDescription'=>t("Settings for Password.")));
		Page::getByPath('/login')->delete();
		Loader::model('single_page');
		$login = SinglePage::add('/login', $pkg);
		Page::getByPath('/register')->delete();
		$register = SinglePage::add('/register', $pkg);
		Page::getByPath('/dashboard/users/search')->delete();
		$search = SinglePage::add('/dashboard/users/search', $pkg);
		Page::getByPath('/profile/edit')->delete();
		$profile = SinglePage::add('/profile/edit', $pkg);
		Page::getByPath('/dashboard/users/add')->delete();
		$addUser = SinglePage::add('/dashboard/users/add', $pkg);
		/*inserts all the required user information to custom database table defined while installing */
		$db = Loader::db();
		$sql = "INSERT INTO `PasswordHistory` (`userID`,`password`,`username`,`userEmail`) (SELECT uID,uPassword,uName,uEmail FROM `Users`)";
		$db->Execute($sql);

	}

	public function uninstall() {
		$pkg = parent::uninstall();
		Loader::model('single_page');
		/*un-installs all the system single pages loaded*/
		$loginPage = SinglePage::add('/login');
		$registerPage = SinglePage::add('/register');
		$searchPage = SinglePage::add('/dashboard/users/search');
		$profilePage = SinglePage::add('/profile/edit');
		$addUserPage =  SinglePage::add('/dashboard/users/add');

	}  
}
