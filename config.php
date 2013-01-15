<?php
class Config{
	public $database;
	public $debugMode;
	public $site;
	public $root;
	public function __construct(){
		$this->database['host'] = 'localhost';
		$this->database['port'] = 3306;
		$this->database['user'] = 'friends';
		$this->database['pass'] = "a.1Z:*9CGuV'G{O3P";
		$this->database['db'] = 'Friends';
		$this->debugMode = true;
		//ini_set('display_errors', $this->debugMode);
		$this->site = "http://friends.araeosia.com/";
		$this->root = "/media/hdd2/friends/";
	}
}