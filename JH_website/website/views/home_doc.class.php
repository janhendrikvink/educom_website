<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class Home_Doc extends Basic_Doc { // Begin class
//==============================================
// Properties
//==============================================

//==============================================
// Constructor
//==============================================
function __construct()
{}
//==============================================
// Methods
//==============================================
public function mainContent() // Override function from Basic_Doc
{
   echo '<h2 class="titels">HOME</h2>
          <p class="tekst">Welcome to my first website!</p>';
}
//==============================================
} // End of class
//==============================================
?>