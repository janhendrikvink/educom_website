<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
require_once (BASE_CLASS_PATH.'\base_views\form.class.php');
//==============================================
class Form_Doc extends Basic_Doc { // Begin class
//==============================================
// Properties
//==============================================
private $requested_page;
private $field_info;
private $form_info;
private $form_error;
private $post_result;
private $form;
//==============================================
// Constructor
//==============================================
public function __construct($requested_page, $field_info, $form_info, $form_error, $post_result)
{
    $this->requested_page = $requested_page;
    $this->field_info = $field_info;
    $this->form_info = $form_info;
    $this->form_error = $form_error;
    $this->post_result = $post_result;
}
//==============================================
// Methods
//==============================================
public function mainContent() // Override function from Basic_Doc
{
    $this->form = new Form();
    $this->form->showForm($this->requested_page, $this->field_info, $this->form_info, $this->form_error, $this->post_result);
}
//==============================================
} // End of class
//==============================================
?>