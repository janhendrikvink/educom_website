<?php
//==============================================
require_once (BASE_CLASS_PATH.'\traits\crud_user.class.php');
require_once (BASE_CLASS_PATH.'\interfaces\i_controller.class.php');
//==============================================
abstract class Base_Controller implements I_Controller { // Begin class
//==============================================
// Properties
//==============================================
use Crud_User;
//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud)
{
	$this->crud = $crud;
}
//==============================================
// Methods
//==============================================
abstract function handleRequest();
//==============================================
} // End of class
//==============================================
?>