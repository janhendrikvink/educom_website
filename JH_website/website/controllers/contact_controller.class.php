<?php
//==============================================
require_once (SITE_CLASS_PATH.'\models\contact_model.class.php');
//==============================================
class Contact_Controller extends Base_Controller { // Begin class
//==============================================
// Properties
//==============================================
private $contact_model;
private $post_result;
private $name;
private $email;
private $message;
//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud, $post_result)
{
	parent::__construct($crud);
	$this->contact_model = new Contact_Model($this->crud);
	$this->post_result = $post_result;
}
//==============================================
// Methods
//==============================================
public function handleRequest()
{
	$this->getContactData($this->post_result);
	$result = $this->sendMessage();
    return $result;
}
//==============================================
protected function getContactData() // Take the name, email and message out of post_result
{
	$this->name = $this->post_result['name_value'];
	$this->email = $this->post_result['email_value'];
	$this->message = $this->post_result['message_value'];
}
//==============================================
protected function sendMessage()
{
	$result = $this->contact_model->writeContactSQL($this->crud, $this->name, $this->email, $this->message);
	return $result;
}
//==============================================
} // End of class
//==============================================
?>