<?php

class User extends Eden_Class {
	public $database = null;

	public function __construct(){
		$this->_app = Eden::i()->getActiveApp();
		$this->database = $this->_app->database();
	}

	//adds new user to database
	public function insertNewData($tableName = null, $settings = null) {
		$this->database->insertRow($tableName, $settings);
	}

	//get users and infos
	public function getUsers() {
		return $this->database
				->search('user')
				->getRows();
	}
	//update database
	public function updateTable($tableName = null, $tableColumn = null, $tableColVal = null, $settings = null) {
		$this->database->setRow($tableName, $tableColumn, $tableColVal, $settings);
	}

	public function getUserWith($rowName = null, $value = null) {
		return $this->database
				->search('user')
				->addFilter($rowName. '=%s', $value)
				->getRows();
	}
}