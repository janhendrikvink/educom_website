<?php
//==============================================
require_once (BASE_CLASS_PATH.'\interfaces\i_html_doc.class.php');
//==============================================
abstract class Base_Html_Doc implements I_Html_Doc { // Begin class
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
public function showPageContent() 
{ 
    $this->beginDoc(); 
    $this->beginHeader(); 
    $this->headerContent(); 
    $this->endHeader(); 
    $this->beginBody(); 
    $this->bodyContent(); 
    $this->endBody(); 
    $this->endDoc(); 
} 
//==============================================
public function beginDoc()
{
    echo "<!DOCTYPE html>\n<html>\n";
}
//==============================================
public function beginHeader()
{
    echo "<head>\n";
}
//==============================================
abstract function headerContent();
//==============================================
public function endHeader()
{
    "</head>\n";
}
//==============================================
public function beginBody()
{
    echo "<body>\n";
}
//==============================================
abstract function bodyContent();
//==============================================
public function endBody()
{
    echo "</body>\n";
}
//==============================================
public function endDoc()
{
    echo "</html>\n";
}
//==============================================
} // End of class
//==============================================
?>