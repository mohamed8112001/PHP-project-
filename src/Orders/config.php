<?php
class Config
{
	private $host;
	private $user;
	private $password;
	private $database;
	public function __construct($host, $user, $password, $database)
	{
		$this->host=$host;
		$this->user=$user;
		$this->password=$password;
		$this->database=$database;
	}	
	public function getHost()
	{
		return $this->host;
	}
	public function getUser()
	{
		return $this->user;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function getDatabase()
	{
		return $this->database;
	}
}
?>

