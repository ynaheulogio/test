<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Playon_Page_Logout extends Playon_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = NULL;
	protected $_class = NULL;
	protected $_template = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		unset($_SESSION['email']);
		session_destroy();
		header('Location: http://playon.com');
		exit;
	}


}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
