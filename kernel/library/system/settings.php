<?php
class Settings
{
	// VARIABLES
	private $___data = array();
	
	function __construct()
	{
		$currentDate = time();
		$commingDate = date("d-m-Y", System::DateAdd('m',1,$currentDate));
		
		$this->___data = array(
			////////////////////////////////////////////////////////////////////////////////////////
			// CORE INFO
            "core"			=> array("is_installed"=>"0", "theme"=>"default", "prefix"=>"default",
				"site_name"=>"", "comming_soon"=>"1", "comming_date"=>$commingDate,
				"admin_login"=>"admin", "admin_password"=>"admin", "admin_token"=>"",
				"admin_salt"=>"" ),
				
			"lang"			=> array("multi"=>"0", "default"=>"ru", "gen_url"=>0),
			
			////////////////////////////////////////////////////////////////////////////////////////
			// DATABASE INFO			
            "data_base"		=> array("pconnect"=>"0", "server"=>"localhost", "name"=>"",
				"user"=>"root", "password"=>"", "using"=>"0")
        );
		
		//asort($this->___data);
    }
	
	function __destruct()
	{
		unset($this->___data["core"]);
		unset($this->___data["data_base"]);
		unset($this->___data);
    }
	
	public function __set($name, $value) 
	{
		if (isset($this->___data[$name]))
		{
			$this->___data[$name] = $value;
		}
		else
		{
			$trace = debug_backtrace();
			_error("You can't add new data");
		}
	}

	public function &__get($name) 
	{
		if (array_key_exists($name, $this->___data)) {
			return $this->___data[$name];
		}

		$trace = debug_backtrace();
		_error("Undefined property '". $name ."'");
		return null;
	}

	public function __isset($name) 
	{
		 return isset($this->___data[$name]);
	}

	public function __unset($name) 
	{
		 unset($this->___data[$name]);
	}

	public function Init()
	{
		if (!file_exists(PATH_CONFIG))
			$this->Save();
		
		$this->Load();
	}
	
	public function Save($fileName = PATH_CONFIG)
	{
		$ini = new IniFile( $fileName );
		
		foreach ($this->___data as $___dataKey => $___dataValue)
		{
			foreach ($___dataValue as $key => $val)
			{
				$ini->write($___dataKey,$key,$val);
			}
		}
		$ini->updateFile();
	}
	
	public function Load($fileName = PATH_CONFIG)
	{
		$ini = new IniFile( $fileName );		
		
		foreach ($this->___data as $___dataKey => $___dataValue)
		{
			foreach ($___dataValue as $key => $val)
			{
				$this->___data[$___dataKey][$key] = $ini->read($___dataKey,$key,$val);
			}
		}
	}
}
?>