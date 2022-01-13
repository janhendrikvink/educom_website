<?php
//==============================================
require_once (BASE_CLASS_PATH.'\crud\crud.class.php');
require_once (BASE_CLASS_PATH.'\base_models\base_model.class.php');
//==============================================
class Contact_Model extends Base_Model { // Begin class
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
public function writeContactSQL($name, $email, $message) : array // Reads the database for login credentials
{
    // To-do: add user_id to the parameters

    $result["name"] = $this->parameters[':user_name'] = $name;
    $result["email"] = $this->parameters[':user_email'] = $email;
    $result["message"] = $this->parameters[':user_message'] = $message;

    $this->sql = "INSERT INTO contact_messages (user_name, user_email, user_message)
                  VALUES (:user_name, :user_email, :user_message)";
    $result['crud'] = $this->crud->create($this->sql, $this->parameters);

	return $result;
}
//==============================================
} // End of class
//==============================================
?>