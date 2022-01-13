<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class Thanks_Doc extends Basic_Doc { // Begin class
//==============================================
// Properties
//==============================================
private $message_info;
//==============================================
// Constructor
//==============================================
function __construct($message_info)
{
    $this->message_info = $message_info;
}
//==============================================
// Methods
//==============================================
public function mainContent() // Override function from Basic_Doc
{
    // To-do: make separate class for thanks
    
    echo '<h2 class="titels">THANKS</h2>';
    
    echo '<div class="tekst">
    <br><p>Thank you for your message!</p>
    <p>Name: '.$this->message_info["name"].' </p>
    <p>Email: '.$this->message_info["email"].' </p>
    <p>Message: '.$this->message_info["message"].' </p><br>
    </div>';
}
//==============================================
} // End of class
//==============================================
?>