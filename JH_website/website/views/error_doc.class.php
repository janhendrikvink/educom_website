<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class Error_Doc extends Basic_Doc { // Begin class
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
public function mainContent() // Override function from Basic_Doc
{
    echo "<br>Page not found.";
}
//==============================================
} // End of class
//==============================================
?>