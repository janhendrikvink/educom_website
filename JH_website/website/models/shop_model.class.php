<?php
//==============================================
require_once (BASE_CLASS_PATH.'\crud\crud.class.php');
//==============================================
class Shop_Model extends Base_Model { // Begin class
//==============================================
// Properties
//==============================================
protected $product_details;
protected $sql_checked;
protected $key;
protected $product_id;
protected $product_amount;
protected $product_total_price;
protected $product_added;
protected $cart_total_price;
//==============================================
// Constructor
//==============================================
public function __construct()
{
	$this->sql_checked = [];
	$this->parameters = [];
	$this->shop_data = [];
	$this->crud = new Crud();
}
//==============================================
// Methods
//==============================================
public function readProductSQL($product_id) // Reads the "products" table for the requested product
{
	$this->parameters[':id'] = $product_id;
	$this->sql = "SELECT * FROM products WHERE product_id = :id";
	$result = $this->crud->readOneRow($this->sql, $this->parameters);
	return $result;
}
//==============================================
public function saveCartSQL($user_id) // Writes the cart for the current user to the "carts" table
{
	$this->parameters = [':user_id' => $user_id];
	$this->sql = "DELETE FROM carts WHERE user_id = :user_id";
	$result['cart_delete'] = $this->crud->delete($this->sql, $this->parameters);

	$cart = $this->getCurrentCart();

	foreach ($cart as $product => $value)
	{
		$this->parameters = [':user_id' => $user_id, ':product_id' => $product, ':product_amount' => $value];
		$this->sql = "INSERT INTO carts (user_id, product_id, product_amount)
		VALUES (:user_id, :product_id, :product_amount)";
		$result[$product] = $this->crud->manipulate($this->sql, $this->parameters);
	}
	return $result;
}
//==============================================
public function readCartSQL($user_id) // Reads the "carts" table
{
	$cart = $this->getCurrentCart();

	$this->parameters = [':user_id' => $user_id];
	$this->sql = "SELECT product_id, product_amount FROM carts WHERE user_id = :user_id";
	$data = $this->crud->readMultipleRows($this->sql, $this->parameters);

	foreach ($data as $product)
	{
		$cart[(int)$product['product_id']] = (int)$product['product_amount'];
	}

	$this->setCurrentCart($cart);
}
//==============================================
public function loadProductInfoSQL() // Loads the product info for the products in the cart
{
	$cart = $this->getCurrentCart();

	foreach ($cart as $product => $amount)
	{
		$this->parameters = '';
		$this->sql = "SELECT * FROM products WHERE product_id = $product";
		$row = $this->crud->readOneRow($this->sql, $this->parameters);
		$row[$product] = $row[0];
		unset($row[0]);
		$result[$product] = $row[$product];
	}

	$this->setCurrentCart($cart);
	return $result;
}
//==============================================
public function placeOrderSQL($user_id) // Writes the cart of the current user to the "orders" table and unsets the cart
{	
	// To-do: change this, new database has to create 1 row in the "orders" table that links to the user and products

	$cart = $this->getCurrentCart();

	foreach ($cart as $product)
	{
		$this->parameters = [':user_id' => $_SESSION['user_id'], ':product_id' => $product['product_id'], ':product_amount' => $product['product_amount']];
		$this->sql = "INSERT INTO orders (user_id, product_id, product_amount)
		VALUES (:user_id, :product_id, :product_amount)";
		$this->crud->create($this->sql, $this->parameters);
	}
	unset($cart);
}
//==============================================
} // End of class
//==============================================
?>