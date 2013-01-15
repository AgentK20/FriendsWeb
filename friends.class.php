<?php
class Friends {
	private $mainClass;

	public function __construct($mainClass){
		$this->mainClass = $mainClass;
	}
	public function friendData($playerName){
		$playerName = $this->mainClass->database->real_escape_string($playerName);
		$result = $this->mainClass->database->query("SELECT * FROM playerFriends WHERE playerName='$playerName'");
		if($result->num_rows>0){
			$data = $result->fetch_assoc();
			$friends = explode(",", $data['friends']);
		}else{
			// TODO write a new row.
		}
	}
}
