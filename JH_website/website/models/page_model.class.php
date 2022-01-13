<?php
//==============================================
require_once (BASE_CLASS_PATH.'\crud\crud.class.php');
require_once (BASE_CLASS_PATH.'\base_models\base_model.class.php');
//==============================================
class Page_Model extends Base_Model { // Begin class
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
public function getPageInfo($page)
{
	switch ($page)
	{
		case 'contact':
			return [
				'needs_post_validation' => true,
				'after_okay_validation' => 'contact',
				'fields' => $this->getFieldsByPage($page),
			];
			break;
		case 'login':
			return [
				'needs_post_validation' => true,
				'after_okay_validation' => 'user',
				'fields' => $this->getFieldsByPage($page),
			];
			break;
		case 'register':
			return [
				'needs_post_validation' => true,
				'after_okay_validation' => 'user',
				'fields' => $this->getFieldsByPage($page),
			];
			break;
		case 'product':
			return [
				'needs_post_validation' => true,
				'after_okay_validation' => 'shop',
				'fields' => $this->getFieldsByPage($page),
			];
			break;
		case 'cart':
			return [
				'needs_post_validation' => true,
				'after_okay_validation' => 'shop',
				'fields' => $this->getFieldsByPage($page),
			];
			break;
		default:
			return [
				'needs_post_validation' => false
			];
			break;
	}
}
//==============================================
public function getFormInfoByPage($page) : array // Assembles information per page that's necessary for form creation
{
    switch ($page)
	{
		case "contact":
			return [
				"title"			=> "CONTACT",
				"submit_text"	=> "Send message"
				];
				break;
		case "login":
			return [
				"title"			=> "LOGIN",
				"submit_text"	=> "Log in"
				];
				break;
		case "register":
			return [
				"title"			=> "REGISTER",
				"submit_text"	=> "Register user"
				];
				break;
		case "product":
			return [
				"submit_text"	=> "Add to cart",
				"show_title"	=> false
				];
				break;
		case "cart":
			return [
				"submit_text"	=> "Change amount",
				"show_title"	=> false
				];
				break;
		default :
			throw new Exception("No form info for page ".$page."");
    }
}
//==============================================
public function getFieldsByPage($page) : array // Assembles information per page that's necessary to create the form fields
{
	switch ($page)
	{
		case "contact":
			return [
				"name" => [
					"label" 		=> "Your name:<br>",
					"type"  		=> "text",	
					"placeholder" 	=> "Enter your full name here", 
					"length" 		=> 80
						],	
				"email" => [
					"label" 		=> "<br>Your email adress:<br>",
					"type"  		=> "email",
					"placeholder"	=> "Enter your email address here"
						],	
				"message" => [
					"label" 		=> "<br>Your message:<br>",
					"type"  		=> "textarea",
					"placeholder"	=> "Your message here",
					"maxchar" 		=> 300
						]
                    ];
		case "login":
			return [
				"email" => [
					"label"			=> "Your email address:<br>",
					"type"			=> "email",
					"placeholder"	=> "Enter your email address here"
						],	
				"password" => [
					"label"			=> "<br>Your password:<br>",
					"type"			=> "password",
					"placeholder"	=> "Enter your password here"
						]
					];	
		case "register":
			return [
				"name" => [
					"label"			=> "Your name:<br>",
					"type"			=> "text",
					"placeholder"	=> "Enter your full name here", 
					"length"		=> 80
						],	
				"email" => [
					"label"			=> "<br>Your email address:<br>",
					"type"			=> "email",
					"placeholder"	=> "Enter your email address here"
						],	
				"password" => [
					"label"			=> "<br>Your password:<br>",
					"type"			=> "password",
					"placeholder"	=> "Enter your password here"
						],
				"repeatpassword" => [
					"label"			=> "<br>Repeat password:<br>",
					"type"			=> "password",
					"placeholder"	=> "Repeat your password here"
						]
					];
		case "product":
			return [
				"amount" => [
					"label"			=> "Enter the amount of the product:<br>",
					"type"			=> "number",
					"placeholder"	=> "Amount"
						],
					];
		case "cart":
			return [
				"amount" => [
					"label"			=> "Enter the amount of the product:<br>",
					"type"			=> "number",
					"placeholder"	=> "Amount"
						],
					];	
		default:
			throw new Exception("No fields for page [".$page."]");
    }
}
//==============================================
public function readShopSQL() // Reads the "products" table for all products and returns an associative array
{	
	$this->sql = "SELECT * FROM products";
	$result = $this->crud->readMultipleRows($this->sql, $this->parameters);
	return $result;
}
//==============================================
} // End of class
//==============================================
?>