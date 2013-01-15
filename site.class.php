<?php
class Site {
	public $database;
	public $config;
	public $smarty;
	public $friends;
	public $user = array('loggedIn' => false);

	public function __construct(){
		$this->loadConfig();
		$this->initDatabase();
		$this->initDependencies();
		$this->handleUser();
		$this->makeFriends();
		$this->render($this->getPageVariables());
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
	private function initDependencies(){
		session_start();
		require_once('smarty/Smarty.class.php');
		$this->smarty = new Smarty();
		$this->smarty->setCompileDir($this->config->root."/smarty/templates_c");
		$this->smarty->setCacheDir($this->config->root."/smarty/cache");
		$this->smarty->setTemplateDir($this->config->root."/templates");
		$this->smarty->setConfigDir($this->config->root."/configs");
	}
	private function makeFriends() {
		require_once('friends.class.php');
		$this->friends = new Friends(this);
	}
	public function crash($error){
		if($this->config->debugMode){
			die("Sorry, we crashed: Error: ".$error);
		}else{
			die("Sorry, we crashed.");
		}
	}
	private function render($pageVariables){
		$this->smarty->assign($pageVariables);
		$this->smarty->display('index.tpl');
	}
	private function getPageVariables(){
		$arguments = explode('/', trim(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']), '/'));
		switch(strtolower($arguments[0])){
			case NULL:
			case "":
			case "home":
				return array('output' => 'home.tpl', 'pageTitle' => 'Minecraft Friends');
			case "friends":
				if(isset($arguments[1]) && $arguments[1]!=null){
					return array('output' => 'friends.tpl', 'pageTitle' => $arguments[1]."'s Friends", 'friendData' => $this->friends->friendData($arguments[1]));
				}else{
					return array('output' => '404.tpl', 'pageTitle' => '404 Error');
				}
		}
	}
}