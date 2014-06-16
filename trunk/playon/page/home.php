<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Playon_Page_Home extends Playon_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'Playon';
	protected $_class = 'home';
	protected $_template = '/home.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$user = playon()->User()->getUserWith('user_email', $_SESSION['email']);

		$name = $user[0]['user_name'];
		$email = $user[0]['user_email'];
		$id = $user[0]['user_facebook'];

		$this->_body['name'] = $name;
		$this->_body['email'] = $email;
		$this->_body['id'] = $id;

		if(isset($_POST['post'])) {
			$settings = array(
						'post_author' => $user[0]['user_name'],
						'post_content' => $_POST['content'],
						'post_created' => date('Y-m-d H:i:s')
						);

			playon()->User()->insertNewData('post', $settings);

			$graph = eden('facebook')->graph($_SESSION['fb_token']);
			$post = $graph->post($_POST['content']);
			$post->create();
			header('Location: http://playon.com/home');
		}

		$graph = eden('facebook')->graph($_SESSION['fb_token']);
		$userinfo = $graph->getUser();

		return $this->_page();
	}

}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
