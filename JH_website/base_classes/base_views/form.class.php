<?php
//==============================================
require_once (BASE_CLASS_PATH.'\tools\tools.class.php');
//==============================================
class Form { // Begin class
//==============================================
// Properties
//==============================================
protected $tools;
//==============================================
// Constructor
//==============================================
public function __construct()
{
	$this->tools = new Tools();
}
//==============================================
// Methods
//=============================================
public function showForm($requested_page, $field_info, $form_info, $form_error, $post_result) // Generalized form creation that gets a post result with values and errors per field
{
	// Show page title if needed
	$show_title = $this->tools->getValueFromArray($form_info, "show_title", true);

	if ($show_title)
	{
		echo '<h2 class="titels">'.$form_info["title"].'</h2>';
	}
	
	// Open form
	echo '<form method="POST">'
		 .'<input type="hidden" name="page" value="'.$requested_page.'">';
	if (isset($_SESSION['product_id']))
	{
		 echo '<input type="hidden" name="item_id" value="'.$_SESSION['product_id'].'">';
	}
		
	// Show error
	if (isset($form_error))
	{
		echo ''.$form_error.' <br><br>';
	}
	
	// Show fields
	foreach ($field_info as $field_name => $field_type) // For each array element (possible field types) it takes a field_error and field_value
	{
		$error = $this->tools->getValueFromArray($post_result, $field_name.'_error', '');
		$value = $this->tools->getValueFromArray($post_result, $field_name.'_value', '');
		$this->showField($field_name, $field_type, $form_error, $post_result, $value, $error);
	}
	
	// Close form
	echo '<br><button type="submit">'.$form_info["submit_text"].'</button>'
		.'</form>';
}
//==============================================
private function showField($field_name, $field_type, $form_error, $post_result, $value, $error) // Generalized field creation
{
	// Open field	
	echo '<div class="formgroup"><label for="'.$field_name.'">'.$field_type["label"].'</label>';
	$placeholder = $this->tools->getValueFromArray($field_type, 'placeholder', '');
	
	if ($error !== '')
	{
		echo '<p class="error">'.$post_result[$field_name.'_error'].'</p>';
	}
	
	switch ($field_type["type"])
	{
		case "textarea":
			echo '<textarea name="'.$field_name.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';
			break;
		case "text":
		case "email":
		case "password":
			echo '<input name="'.$field_name.'" type="'.$field_type["type"].'" value="'.$value.'" placeholder="'.$placeholder.'"/>';
			break;
		case "number":
			echo '<input name="'.$field_name.'" type="'.$field_type["type"].'" value="'.$value.'" placeholder="'.$placeholder.'" min="1"/>';
			break;
		default:
			throw new Exception('<p class="error">Unsupported fieldtype [<i>'
				.$field_type["type"]
				.'</i>] for field [<i>'
				.$field_name
				.'</i>]</p>');
	}
	
	// Close field
	echo '</div>';
}
//==============================================
} // End of class
//==============================================
?>