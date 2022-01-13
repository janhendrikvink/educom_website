<?php
//==============================================
// To-do: $post_result has to be passed to the constructor now,
// 		  how to handle this for a GET request?
// To-do: remove unnecessary methods that only link to Shop_Model methods
// To-do: check handleRequest() binary tree
// To-do: check methods
//==============================================
require_once (SITE_CLASS_PATH.'\models\shop_model.class.php');
require_once (SITE_CLASS_PATH.'\managers\session_manager.class.php');
//==============================================
class Shop_Controller extends Base_Controller { // Begin class
//==============================================
// Properties
//==============================================
protected $shop_model;
protected $session_manager;
private $post_result;
//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud, $post_result)
{
	parent::__construct($crud);
	$this->shop_model = new Shop_Model($this->crud);
	$this->session_manager = new Session_Manager();
	$this->post_result = $post_result;
}
//==============================================
// Methods
//==============================================
public function handleRequest()
{
	// To-do: check how the binary tree has to go based on the page and request

	if (isset($_SESSION['user_id']))
	{
		$user_id = $_SESSION['user_id'];
		if (isset($post_result))
		{
			$result = $this->addProductTocart($this->post_result);
		}
		elseif (isset($_GET['action']) == 'removeproduct')
		{
			$result = $this->removeFromCart($cart);
		}
		if (isset($_GET['action']) == 'placeorder')
		{
			$result = $this->shop_model->placeOrderSQL($cart);
			if ($result !== false)
			{
				unset($_SESSION['cart']);
			}
		}
	}
	return $result;
}
//==============================================
public function addProductToCart($post_result) // Adds products to the $_SESSION['carts'] array
{
	$cart = $this->session_manager->getCurrentCart(); // Gets cart from the session

	$product_id = $_SESSION['product_id']; //(int)$this->product_data[0]['product_id'];
	$product_amount = (int)$this->post_result['amount_value'];
	
	$cart[$product_id] = (int)$product_amount; // Adds the new product with amount
	$result[$product_id] = $product_amount;

	$this->session_manager->setCurrentCart($cart); // Saves the cart to the $_SESSION['carts'] array
	return $result;
}
//==============================================
public function removeFromCart() // Removes a product from the cart
{
	$cart = $this->session_manager->getCurrentCart();
	if (isset($_GET['id']))
	{
		$product_id = (int)$_GET['id'];
	}
	else
	{
		$product_id = null;
	}

	if (array_key_exists($product_id, $cart)) // The product exists in the cart
	{	
		unset($cart[$product_id]); // Removes the product from the cart
		$this->session_manager->setCurrentCart($cart); // Saves the cart to the $_SESSION['carts'] array
		return true;
	}
	else // The product doesn't exist
	{
		return false;
	}
}
//==============================================
public function calculateProductTotal($cart_data) // Calculates the total prices for the products
{
	$cart = $this->session_manager->getCurrentCart();

	foreach ($cart as $product => $amount)
	{
		$this->cart_data[$product]['product_amount'] = $amount;
		$this->cart_data[$product]['product_total_price'] = $this->cart_data[$product]['product_amount'] * $this->cart_data[$product]['product_price'];
	}
	$this->session_manager->setCurrentCart($cart);
	return $this->cart_data;
}
//==============================================
public function calculateCartTotal($cart_data) // Calculates the total cart price
{
	foreach ($this->cart_data as $product)
	{
		if (isset ($product['product_total_price']))
		{
			$this->cart_total_price += $product['product_total_price'];
			return $this->cart_total_price;
		}
		else
		{
			$this->cart_total_price = 0;
			return $this->cart_total_price;
		}
	}
}
//==============================================
public function getShop()
{
	$result = $this->shop_model->readShopSQL();
	return $result;   
}
//==============================================
public function getProduct()
{
	$_SESSION['product_id'] = $product_id = (int)$_GET['id'];
	$result = $this->shop_model->readProductSQL($product_id);
	return $result;   
}
//==============================================
public function saveCart()
{
	$result = $this->shop_model->saveCartSQL($user_id);
}
//==============================================
public function readUserCart()
{
	$result = $this->shop_model->readCartSQL();
}
//==============================================
public function getProductInfo()
{
	$result = $this->shop_model->loadProductInfoSQL();
	return $result;
}
//==============================================
public function placeOrder($user_id)
{
	$result = $this->shop_model->placeOrderSQL($user_id);
}
//==============================================
} // End of class
//==============================================
?>