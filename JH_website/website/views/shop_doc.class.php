<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class Shop_Doc extends Basic_Doc { // Begin class
//==============================================
// Properties
//==============================================
protected $shop_data;
protected $product;
protected $image;
//==============================================
// Constructor
//==============================================
public function __construct($shop_data)
{
    $this->shop_data = $shop_data;
}
//==============================================
// Methods
//==============================================
public function mainContent() // Override function from Form_Doc
{
    // To-do: <a href> can be styled as a button in CSS, unnecessary to make a button here
    
    echo '<h2 class="titels">SHOP</h2>';

    foreach ($this->shop_data as $this->product)
    {
        echo '<br><div class="product">
              <img src="./database/product_images/'.$this->product['product_img'].'">
              <p class="tekst">'.$this->product['product_name'].'</p>
              <p class="tekst">&euro; '.$this->product['product_price'].'</p>
              <p class="tekst">'.$this->product['product_description'].'</p>
              </div>';
      
        echo '<a href="index.php?page=product&id='.$this->product['product_id'].'">
        <button type="button" method="get" target="_self">Product Details</button>
        </a><br><br>';
    
        echo '<br><br><br><br>';
    }
}
//==============================================
} // End of class
//==============================================
?>