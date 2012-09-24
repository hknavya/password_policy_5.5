<?php
/**
Module Name : Password Policy
Description: defines all the password validation.
Author Name: Navya H.K.
**/
class PasswordPolicy 
{	 /* variables */
	private $rules;	// Array of policy rules
	private $errors; // Array of errors for the last validation
	 /**
     * Constructor
     *
     * Allows an array of policy parameters to be passed on construction.
     * For any rules not listed in parameter array default values are set.
     *
     * @param  array $params optional array of policy configuration parameters
     */
	function __construct ($params=array())
	{
		/**
         *    Key is rule identifier
         *    Value is rule parameter
         *      false is disabled (default)
         *    Type is type of parameter data
         *      permitted values are 'integer' or 'boolean'
         *    Test is php code condition returning true if rule is passed
         *      password string is $p
         *      rule value is $v
         *    Error is rule string definition
         *      use #VALUE# to insert value
         */
		
		$this->rules['min_length'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return strlen($p)>=$v;',
			'error' => 'Password must be more than #VALUE# characters long');
			
		$this->rules['max_length'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return (strlen($p)<=$v);',
			'error' => 'Password must be less than #VALUE# characters long');
			
		$this->rules['min_lowercase_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[a-z]/",$p,$x)>=$v;',
			'error' => 'Password must contain at least #VALUE# lowercase characters');
			
		$this->rules['max_lowercase_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[a-z]/",$p,$x)<=$v;',
			'error' => 'Password must contain no more than #VALUE# lowercase characters');
			
		$this->rules['min_uppercase_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[A-Z]/",$p,$x)>=$v;',
			'error' => 'Password must contain at least #VALUE# uppercase characters');
			
		$this->rules['max_uppercase_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[A-Z]/",$p,$x)<=$v;',
			'error' => 'Password must contain no more than #VALUE# uppercase characters');
			
		$this->rules['disallow_numeric_chars'] = array(
			'value' => false,
			'type'  => 'boolean',
			'test'  => 'return preg_match_all("/[0-9]/",$p,$x)==0;',
			'error' => 'Password may not contain numbers');
			
		$this->rules['disallow_numeric_first'] = array(
			'value' => false,
			'type'  => 'boolean',
			'test'  => 'return preg_match_all("/^[0-9]/",$p,$x)==0;',
			'error' => 'First character cannot be numeric');
			
		$this->rules['disallow_numeric_last'] = array(
			'value' => false,
			'type'  => 'boolean',
			'test'  => 'return preg_match_all("/[0-9]$/",$p,$x)==0;',
			'error' => 'Last character cannot be numeric');
			
		$this->rules['min_numeric_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[0-9]/",$p,$x)>=$v;',
			'error' => 'Password must contain at least #VALUE# numbers');
			
		$this->rules['max_numeric_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[0-9]/",$p,$x)<=$v;',
			'error' => 'Password must contain no more than #VALUE# numbers');
		
		$this->rules['disallow_nonalphanumeric_chars'] = array(
			'value' => false,
			'type'  => 'boolean',
			'test'  => 'return preg_match_all("/[\W]/",$p,$x)==0;',
			'error' => 'Password may not contain non-alphanumeric characters');
			
		$this->rules['disallow_nonalphanumeric_first'] = array(
			'value' => false,
			'type'  => 'boolean',
			'test'  => 'return preg_match_all("/^[\W]/",$p,$x)==0;',
			'error' => 'First character cannot be non-alphanumeric');
			
		$this->rules['disallow_nonalphanumeric_last'] = array(
			'value' => false,
			'type'  => 'boolean',
			'test'  => 'return preg_match_all("/[\W]$/",$p,$x)==0;',
			'error' => 'Last character cannot be non-alphanumeric');
			
		$this->rules['min_nonalphanumeric_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[\W]/",$p,$x)>=$v;',
			'error' => 'Password must contain at least #VALUE# non-aplhanumeric characters');
			
		$this->rules['max_nonalphanumeric_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/[\W]/",$p,$x)<=$v;',
			'error' => 'Password must contain no more than #VALUE# non-alphanumeric characters');

		$this->rules['disallow_consecutive_chars'] = array(
			'value' => false,
			'type'  => 'integer',
			'test'  => 'return preg_match_all("/^[\w ]*$/",$p,$x)==0;',
			'error' => 'Password must contain not more than #VALUE# consecutive characters');
		
		 // Apply params from constructor array
		foreach( $params as $k=>$v ) { $this->$k = $v; }
		
		// Errors by defaults is empty
		$this->errors = array();
		
		return 1;
	}

	// Get a rule configuration parameter
	public function __get($rule)
	{
		if( isset($this->rules[$rule]) ) return $this->rules[$rule]['value'];
										 return false;	
	}
	
	//Set a rule configuration parameter
	public function __set($rule, $value)
	{
		if( isset($this->rules[$rule]) )
		{
			if( 'integer' == $this->rules[$rule]['type'] && is_int($value) )
			return $this->rules[$rule]['value'] = $value;
			
			if( 'boolean' == $this->rules[$rule]['type'] && is_bool($value) )
			return $this->rules[$rule]['value'] = $value;
		}
		return false;
	}
	
	/*
     * Returns array of strings where each element is a string description of 
     * the active rules in the policy
     */
	public function policy()
	{
		$return = array();
		// Itterate over policy rules
		foreach( $this->rules as $k => $v )
		{ // If rule is enabled, add string to array
			$string = $this->get_rule_error($k);
			if( $string ) $return[$k] = $string;
		}
		
		return $return;
	}
	
	/*
     * Validate a password against the policy
     
     */
	public function validate($password)
	{
		foreach( $this->rules as $k=>$rule )
		{
			$p = $password;
			$v = $rule['value'];
			
			if( $rule['value'] && !eval($rule['test']) )
			$this->errors[$k] = $this->get_rule_error($k);
		}
	
		return sizeof($this->errors) == 0;
	}
	
	/*
     * Get the errors showing which rules were not matched on the last validation
     *
     * Returns array of strings where each element has a key that is the failed
     * rule identifier and a string value that is a human readable description 
     * of the rule
     */
	public function get_errors()
	{
		return $this->errors;
	}
	
	/*
     * Get the error description for a rule
     */
	private function get_rule_error($rule)
	{
		return ( isset($this->rules[$rule]) && $this->rules[$rule]['value'] ) 
		? str_replace( '#VALUE#', $this->rules[$rule]['value'], $this->rules[$rule]['error'] )
		: false;
	}

	public static function validatePassword($username,$password,&$e){
		Loader::library('password', 'password_policy');
		$pkg = Package::getByHandle('password_policy');
		//gets the values stored in database
		$passwordLength = $pkg->config('password_length');
		$minUppercase = $pkg->config('min_uppercase');
		$minLowercase = $pkg->config('min_lowercase');
		$minNumericCharacter = $pkg->config('min_numeric_character');
		$minNonAlphanumeric = $pkg->config('min_non_alphanumeric');

		$rules['min_length'] = intval($passwordLength);
		// Create password policy object
    	// Pass rule array in constructor
		$policy = new PasswordPolicy($rules);
		 // Rules defined on object
		$policy->min_lowercase_chars = intval($minLowercase);
		$policy->min_uppercase_chars = intval($minUppercase);
		$policy->min_numeric_chars = intval($minNumericCharacter);
		$policy->min_nonalphanumeric_chars = intval($minNonAlphanumeric);
		// Validate submitted password
		$valid = $policy->validate($password);
		$validMinConsecutive = self::minimumConsecutiveValidation($username,$password,$e);
		$valid = $valid && $validMinConsecutive;

		if(!$valid){
		foreach($policy->get_errors() as $error )
			$e->add($error);
		}
		
	}
	/*validation for minimum consecutive number allowed in password*/
	private static function minimumConsecutiveValidation($userName,$password,$e){
		$pkg = Package::getByHandle('password_policy');
		//gets the value from the config
		$minConsecutiveCharacter = $pkg->config('min_consecutive_character');
		//get the string length of the username
		$stringLength = strlen($userName);

		for($i=0;$i<($stringLength-($minConsecutiveCharacter+1));$i++){
			$matchString = substr($userName,$i,$minConsecutiveCharacter+1);
			//preg_match the matched string with the password
			if(preg_match('/'.$matchString.'/',$password)){
				//adds an error to the error list
				$e->add( t('Password cannot contain more than '.$minConsecutiveCharacter.' consecutive characters from username'));
				return false;
			}
		}
		return true;	
		
	}
	/*get the password updated time from database*/
	public static  function getPasswordUpdatedTime($passwordResetInterval,$userID){
		$pkg = Package::getByHandle('password_policy');
		/*gets the reset interval value from config*/
		$passwordResetInterval = $pkg->config('password_reset_interval');
		$db = Loader::db();
		$passwordResetQuery =  "SELECT updated FROM `PasswordHistory` WHERE userID=? ORDER BY `updated` DESC LIMIT 1";
		return $db->GetCol($passwordResetQuery,array($userID));
	
	}
	/*get all the password list from database limiting defined number in the config*/
	public static  function getPassword($passwordRepeatInterval,$userID){
		$pkg = Package::getByHandle('password_policy');
		/*gets the repeat interval value from config*/
		$passwordRepeatInterval = $pkg->config('password_repeat_interval');
		$db = Loader::db();
		$passwordRepeatQuery =  "SELECT password FROM `PasswordHistory` WHERE userID=? ORDER BY `updated` DESC LIMIT $passwordRepeatInterval";
		return $db->GetCol($passwordRepeatQuery,array($userID));
	
	}
	/*get the whole password list from database*/
	public static function getAllPasswords($userID,$password){
		$pkg = Package::getByHandle('password_policy');
		$passwordExpiryTime = $pkg->config('password_expiry_time');
		$db = Loader::db();
		$currentTime = date('Y-m-d 00:00:00',strtotime('-' . $passwordExpiryTime . ' days'));
		$passwordExpiryQuery = "SELECT count(*) FROM `PasswordHistory` WHERE userID=? AND password=? AND updated>=?";
		return $db->GetAll($passwordExpiryQuery,array($userID,$password,$currentTime));

	}
	/*get the number of login attempts of a particular user*/
	public static function getAttempts($userName){
		
		$db = Loader::db();
		$passwordAttemptQuery = "SELECT attempts,userID FROM `PasswordHistory` WHERE username=? OR userEmail=?";
		return $db->GetRow($passwordAttemptQuery,array($userName,$userName));

	}
	/*saves the user password information in the database*/
	public static function savePassword($password,$userID,$userName,$userEmail){
		$UpdatedTime = date("Y-m-d g:i:s "); 
		$db = Loader::db();
		$sql= "INSERT INTO `PasswordHistory` (`userID`,`password`, `updated`,`username`,`userEmail`) VALUES (?,?,?,?,?)";
		$db->Execute($sql,array($userID,$password,$UpdatedTime,$userName,$userEmail));
	}
}
