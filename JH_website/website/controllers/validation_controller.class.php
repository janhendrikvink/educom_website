<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_controllers\base_controller.class.php');
require_once (BASE_CLASS_PATH.'\interfaces\i_controller.class.php');
//==============================================
class Validation_Controller extends Base_Controller implements I_Controller { // Begin class
//==============================================
// Properties
//==============================================
private $email;
private $password;
//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud, $field_info)
{
	parent::__construct($crud);
	$this->field_info = $field_info;
}
//==============================================
// Methods
//==============================================
public function handleRequest()
{
	$result = $this->validateForm($this->field_info);
	return $result;
}
//==============================================
public function validateForm() : array // Makes an array with all the validated form info
{	
	$result['valid'] = true;
	
	foreach ($this->field_info as $field_name => $field_type)
	{
		$field_result = $this->validateField($field_name, $field_type);

		if ($field_result['valid']) // If the field is valid, then add the field value (field_value) to the total result
		{
			$result[$field_name.'_value'] = $field_result['value'];
		}
		else // Otherwise it adds an error for the particular field to the total result
		{
			$result[$field_name.'_error'] = $field_result['error'];
			$result['valid'] = false; // If 1 field isn't valid, then the total result isn't valid
		}
	}

	return $result;
}
//==============================================
private function filterValue($posted_value) : string // Trims, strips and removes special characters of the posted value
{
	$trimmed_value = trim($posted_value);
	$filtered_value = stripslashes($trimmed_value);
	$filtered_value = htmlspecialchars($filtered_value);
	
	return $filtered_value;
}
//==============================================
private function checkEmail($filtered_value) : bool // Checks whether it's a valid email
{
	return filter_var($filtered_value, FILTER_VALIDATE_EMAIL) !== false;
}
//==============================================
private function validateField($field_name, $field_type) : array // Validates the fields individually
{
	if (isset($_POST[$field_name]))
	{
		$posted_value = $_POST[$field_name];
		$filtered_value = $this->filterValue($posted_value);
		$field_result['valid'] = false;

		if ($filtered_value !== "") // When present and not empty after filtering: optional extra checks for this type	
		{	
			switch ($field_type["type"])
			{
				case "email":
					if ($this->checkEmail($filtered_value))
					{
						$field_result['valid'] = true;	
					}
					else	
					{
						$field_result['error'] = '<p class="error">Value [<i>'.$filtered_value.'</i>] for [<i>'.$field_name.'</i>] is not a valid email address</p>';
					}						
					break;
				default: // No errors and no extra test needed, then result is valid
					$field_result['valid'] = true;	
			}
			if ($field_result['valid']) // When field is valid then the value is saved in $result
			{
				$field_result['value'] = $filtered_value;
			}
		}	
		else
		{
			$field_result['error'] = '<p class="error">Field [<i>'.$field_name.'</i>] is empty</p>';
		}			
	}
	else
	{
		$field_result['error'] = '<p class="error">Field [<i>'.$field_name.'</i>] not posted</p>';
	}
	return $field_result;
}
//==============================================
private $password;
private $email;
//==============================================
private function functionOne($data)
{
	$this->password = $data['password'];
	$this->email = $data['email'];
}
//==============================================
private function functionTwo()
{

}
//==============================================
} // End of class
//==============================================
?>