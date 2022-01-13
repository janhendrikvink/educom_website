<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class Music_Doc extends Basic_Doc { // Begin class
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
   echo '<h2 class="titels">MUSIC</h2>
         <p class="tekst">My music will be uploaded here soon!</p>';
}
//==============================================
} // End of class
//==============================================
?>