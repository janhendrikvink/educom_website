<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class Product_Doc extends Form_Doc { // Begin class
//==============================================
// Properties
//==============================================
public $product_data;
protected $form;
//==============================================
// Constructor
//==============================================
public function __construct($requested_page, $field_info, $form_info, $form_error, $product_data, $post_result)
{
    parent::__construct($requested_page, $field_info, $form_info, $form_error, $post_result);
    $this->product_data = $product_data;
}
//==============================================
// Methods
//==============================================
public function mainContent() // Override function from Form_Doc
{   
    echo '<h2 class="titels">PRODUCT</h2>';

    $this->form = new Form();

    echo '<br><div class="product">
          <img src="./database/product_images/'.$this->product_data[0]['product_img'].'">
          <p class="tekst">'.$this->product_data[0]['product_name'].'</p>
          <p class="tekst">&euro; '.$this->product_data[0]['product_price'].'</p>
          <p class="tekst">'.$this->product_data[0]['product_description'].'</p>
          </div>';

    $this->form->showForm($this->requested_page, $this->field_info, $this->form_info, $this->form_error, $this->post_result);
}
//==============================================
} // End of class
//==============================================
?>