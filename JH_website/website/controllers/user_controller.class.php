<?php
//==============================================
require_once (SITE_CLASS_PATH.'\models\user_model.class.php');
//==============================================
class User_Controller extends Base_Controller { // Begin class
//==============================================
// Properties
//==============================================
private $user_model;
protected $session_manager;
private $post_result;
private $name;
private $email;
private $password;
private $repeated_password;
//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud, $post_result)
{
	parent::__construct($crud);
	$this->user_model = new User_Model($this->crud);
	$this->session_manager = new Session_Manager();
	$this->post_result = $post_result;
}
//==============================================
// Methods
//==============================================
public function handleRequest()
{
	// To-do: implement the Session_Manager for the session variables
	
	// if (/* login */)
	// {
	// 	$this->getLoginData();
	// 	$result = $this->login($this->email, $this->password);
	// }
	// else // Registration
	// {
	// 	$this->getRegistrationData();
	// 	if ($this->password === $this->repeated_password)
	// 	{
	// 		$result = $this->register($this->name, $this->email, $this->password);
	// 		if ($result['valid'] === true)
	// 		{
	// 			$_SESSION['user_name'] = $result['user_name'];
	// 			(int)$_SESSION['user_id'] = $result['user_id'];
	// 		}
	// 		else // $result['valid'] === false
	// 		{
	// 			?
	// 		}
	// 	}
	// 	else
	// 	{
	// 		?
	// 	}
	// }
    // return $result;
}
//==============================================
public function getLoginData() // Fills properties with values from $this->post_result
{
	$this->email = $this->post_result['email_value'];
	$this->password = $this->post_result['password_value'];
}
//==============================================
public function getRegistrationData() // Fills properties with values from $this->post_result
{		
	$this->name = $this->post_result['name_value'];
	$this->email = $this->post_result['email_value'];
	$this->password = $this->post_result['password_value'];
	$this->repeated_password = $this->post_result['repeatpassword_value'];
}
//==============================================
public function login()
{
	$result = $this->user_model->readLoginSQL($this->crud, $this->email, $this->password);
	return $result;
}
//==============================================
public function register()
{
	$result = $this->user_model->writeRegisterSQL($this->crud, $this->name, $this->email, $this->password, $this->repeated_password);
	return $result;
}
//==============================================
} // End of class
//==============================================
?>