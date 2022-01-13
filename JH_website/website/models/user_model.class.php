<?php
//==============================================
require_once (BASE_CLASS_PATH.'\crud\crud.class.php');
//==============================================
class User_Model extends Base_Model { // Begin class
//==============================================
// Properties
//==============================================

//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud)
{
	parent::__construct($crud);
}
//==============================================
// Methods
//==============================================
public function readLoginSQL($email, $password) : array // Reads the database for login credentials
{	
	$this->parameters = [':user_email' => $email];
    $this->sql = "SELECT * FROM users WHERE user_email = :user_email";
    $result = $this->crud->readOneRow($this->sql, $this->parameters);

	if ($password === $result['user_password']) // Password is correct
	{
		$result['valid'] = true;
	}
	else
	{
		$result['valid'] = false;
	}
	return $result;
}
//==============================================
public function writeRegisterSQL($name, $email, $password) : array // Writes a new user to the "users" table
{
	$this->parameters = [':user_email' => $email];
	$this->sql = "SELECT user_email FROM users WHERE user_email = :user_email";
	$result = $this->crud->readOneRow($this->sql, $this->parameters);

	if ($result !== false) // The user's email exists in the database
	{
		$result = false;
	}
	else // The user can be created
	{
		$this->parameters = [':user_name' => $name, ':user_email' => $email, ':user_password' => $password];
		$this->sql = "INSERT INTO users (user_name, user_email, user_password)
		VALUES (:user_name, :user_email, :user_password)";
		$result = $this->crud->create($this->sql, $this->parameters);
		$result['valid'] = true;
	}
	return $result;
}
//==============================================
} // End of class
//==============================================
?>