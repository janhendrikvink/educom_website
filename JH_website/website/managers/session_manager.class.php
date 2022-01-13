<?php
//==============================================
// To-do: add all methods and functionality related to the $_SESSION
//==============================================
class Session_Manager { // Begin class
//==============================================
// Properties
//==============================================

//==============================================
// Constructor
//==============================================
public function __construct()
{}
//==============================================
// Methods
//==============================================
public function checkLogin() : bool // Checks whether the user is logged in
{
	isset($_SESSION['login']);
}
//==============================================
public function getCurrentCart() // Returns $_SESSION['cart'] if set, otherwise returns an empty array
{
	if (isset($_SESSION['cart'])) // If the cart exists
	{	
		return $_SESSION['cart']; // Return the cart
	}
	else // If the cart doesn't exist
	{		
		return array(); // Return an empty array
	}
}
//==============================================
public function setCurrentCart($cart) // Adds $cart to $_SESSION['cart']
{
	$_SESSION['cart'] = $cart;
}
//==============================================
} // End of class
//==============================================
?>