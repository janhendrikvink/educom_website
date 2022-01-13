<?php
//==============================================
class Tools { // Begin class
//==============================================
// To-do: make static class so it doesn't need instancing
//==============================================
// Properties
//==============================================
protected $value;
//==============================================
// Constructor
//==============================================
public function __construct()
{}
//==============================================
// Methods
//==============================================
public function getPostVar(string $key, string $default) // Returns POST page value
{
    $this->value = filter_input(INPUT_POST, $key); // filter_input doesn't need $this->, because it's a php inherent function

    return isset($this->value) ? $this->value : $default; // Return this page value if that page value is set, else show home page
}
//==============================================
public function getUrlVar(string $key, string $default) // Returns GET page value
{
    $this->value = filter_input(INPUT_GET, $key); // filter_input doesn't need $this->, because it's a php inherent function

    return isset($this->value) ? $this->value : $default; // Return a page value if that page value is set, else show home page
}
//==============================================
public function getValueFromArray(array $arr, string $key, string $default) // Returns values from an array that's imported
{
	return (isset($arr[$key]) ? $arr[$key] : $default); // Returns a value from an array if that value is set, otherwise shows the default value
}
//==============================================
} // End of class
//==============================================
?>