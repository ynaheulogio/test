<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Playon_Page_Facebookauth extends Playon_Page {
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

		$fb_key = '475803239220613';
		$fb_secret = '70775b12db1eb2a9c71b4404b7a4b53d';
		$redirect = 'http://playon.com/facebookauth';
		$permissions = array('email', 'publish_actions');
		$emails = array();

		//session_destroy();
		//exit;
		//get auth
		$auth = eden('facebook')->auth($fb_key, $fb_secret, $redirect);

		
		if(!isset($_GET['code']) && !isset($_SESSION['fb_token'])) {
		    $loginUrl = $auth->getLoginUrl($permissions);
		    header('Location: '.$loginUrl);
		    exit;
		}

		//echo $_GET['code'];
		//exit;
		
		if(isset($_GET['code'])) {
		    $access = $auth->getAccess($_GET['code']);
		    $_SESSION['fb_token'] = $access['access_token'];

		    $graph = eden('facebook')->graph($_SESSION['fb_token']);
			$userinfo = $graph->getUser();
			$_SESSION['email'] = $userinfo['email'];

			//echo $_SESSION['email'];

			$this->checkUser();

		    header('Location: http://playon.com/home');
		    exit;
		}
	}

	public function checkUser() {
		$user = playon()->User()->getUserWith('user_email', $_SESSION['email']);
		$graph = eden('facebook')->graph($_SESSION['fb_token']);
		$userinfo = $graph->getUser();
		if(empty($user)) {
			$name = $userinfo['first_name'] . ' ' . $userinfo['last_name'];
			$settings = array(
						'user_name' => $name,
						'user_facebook' => $userinfo['id'],
						'user_email' => $userinfo['email'],
						'user_facebook_token' => $_SESSION['fb_token'],
						'user_created' => date('Y-m-d H:i:s')
						);
			
			playon()->User()->InsertNewData('user', $settings);
		}
		else {
			$settings1 = array(
						'user_facebook' => $userinfo['id'],
						'user_facebook_token' => $_SESSION['fb_token']
						);
			playon()->User()->updateTable('user', 'user_email', $_SESSION['email'], $settings1);
		}

	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
