<?php
class API {
	public $database;
	public $config;
	public $friends;

	public function __construct(){
		$this->loadConfig();
		$this->initDatabase();
		$this->makeFriends();
	}
	public function loadConfig(){
		require('config.php');
		$this->config = new Config();
	}
	private function initDatabase(){
		$this->database = new MySQLi();
		$this->database->connect($this->config->database['host'], $this->config->database['user'], $this->config->database['pass'], $this->config->database['db'], $this->config->database['port']);
		if($this->database->connect_error!=null){
			$this->crash($this->database->connect_error);
		}
	}
	private function makeFriends() {
		require_once('friends.class.php');
		$this->friends = new Friends(this);
	}
	public function crash($error){
		if($this->config->debugMode){
			die(json_encode(array('success' => false, 'error' => 0, 'message' => 'We crashed: '.$error)));
		}else{
			die(json_encode(array('success' => false, 'error' => 0, 'message' => 'We crashed!')));
		}
	}
}
