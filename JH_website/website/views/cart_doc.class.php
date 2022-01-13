<?php
//==============================================
require_once (SITE_CLASS_PATH.'\views\form_doc.class.php');
//==============================================
class Cart_Doc extends Form_Doc { // Begin class
//==============================================
// Properties
//==============================================
protected $shop_data;
protected $product;
protected $form;
public $cart_data;
public $cart_total_price;
//==============================================
// Constructor
//==============================================
public function __construct($requested_page, $field_info, $form_info, $form_error, $post_result, $cart_data, $cart_total_price)
{
    parent::__construct($requested_page, $field_info, $form_info, $form_error, $post_result);
    $this->cart_data = $cart_data;
    $this->cart_total_price = $cart_total_price;
}
//==============================================
// Methods
//==============================================
public function mainContent() // Override function from Form_Doc
{   
    // To-do: $_SESSION['product_id'] always resorts to the last product id entered, because it's a foreach loop
    // This makes it so the amount changed in the cart is always done for the last item
    // Needs a new showForm() that overrides the function from Form_Doc to work
    // Can also be done easily with JavaScript
    
    echo '<h2 class="titels">CART</h2>';
    if (!isset($this->cart_total_price))
    {
        $this->cart_total_price = 0;
        echo '<div class="emptycart"><p class="tekst">Your cart is empty!</p></div>';
    }
    $this->form = new Form();

    foreach ($this->cart_data as $product)
    {
        echo '<br><div class="product">
              <p class="tekst">'.$product['product_name'].'</p>
              <p class="tekst">Amount: '.$product['product_amount'].'</p>
              <p class="tekst">Total price: &euro; '.$product['product_total_price'].'</p>
              </div>';

        $_SESSION['product_id'] = (int)$product['product_id'];
        $this->form->showForm($this->requested_page, $this->field_info, $this->form_info, $this->form_error, $this->post_result);

        echo '<a href="index.php?page=cart&id='.$product['product_id'].'&action=removeproduct">
        <button type="button" method="get" target="_self">Remove product</button>
        </a><br><br><br>';
    }

    echo '<br><div class="total">
          <p class="tekst">Total price: &euro; '.$this->cart_total_price.'</p>
          </div>';

    echo '<a href="index.php?page=cart&action=placeorder">
    <button type="button" method="get" target="_self">Place order</button>
    </a><br><br>';
}
//==============================================
} // End of class
//==============================================
?>