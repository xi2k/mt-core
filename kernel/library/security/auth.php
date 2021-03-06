<?php

class Auth {
	public static function Init()
	{
		if (self::IsAuth()) {
		}
	}
	
	public static function IsAuth()
	{
		$settings = System::GetSettings();
		$prefix = $settings->core["prefix"];
		
		$cookieId = (isset($_COOKIE[ $prefix."_key"])) ? $_COOKIE[ $prefix."_key"] : null;
		$cookieToken = (isset($_COOKIE[ $prefix."_token"])) ? $_COOKIE[ $prefix."_token"] : null;		
		
		if (empty($cookieId) || empty($cookieToken))
			return false;	

		$userId = $cookieId;
		$userIp = Security::GetIp();
		$userSalt = $settings->core["admin_salt"];
		$userToken = md5( crypt($userIp.$userSalt) );
		
		if (strcmp($cookieToken, $settings->core["admin_token"]) != 0)
		{
			return false;
		}
		
		return true;
	}
	
	public static function SignIn($id = null, $isGuest = null, $remember = true)
	{
		$settings = System::GetSettings();
		$prefix = $settings->core["prefix"];
		
		$userId = (empty($id)) ? 1 : $id;
		$userIp = Security::GetIp();
		$userSalt = Security::GetSalt(6);
		$userToken = md5( crypt($userIp.$userSalt) );
		
		if ($settings->data_base["using"] != 0) {
			_error("TODO this block");
		}
		else {
			$settings->core["admin_token"] = $userToken;
			$settings->core["admin_salt"] = $userSalt;
			$settings->Save();
			
			$expire = time() + 3600*24*3;
			
			if (!$remember)
				$expire = 0;
			
			setcookie( $prefix."_key", $userId, $expire, "/" );
			setcookie( $prefix."_token", $userToken, $expire, "/" ); 
		}
	}
	
	public static function SignOut()
	{
		$settings = System::GetSettings();
		$prefix = $settings->core["prefix"];
		
		setcookie( $prefix."_key", "", 0, "/" );
		setcookie( $prefix."_token", "", 0, "/" );

	}
	
	public static function Check($userId, $userLogin, $userPassword)
	{
		$settings = System::GetSettings();
		
		if ($settings->data_base["using"] != 0) {
			_error("TODO this block");
		}
		else {
			if ($settings->core["admin_login"] === $userLogin
				&& $settings->core["admin_password"] === $userPassword)
			{
				return true;
			}
		}
		return false;
	}
	
}
?>