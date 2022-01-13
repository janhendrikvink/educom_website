<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\basic_doc.class.php');
//==============================================
class About_Doc extends Basic_Doc { // Begin class
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
    echo '<h2 class="titels">ABOUT</h2>
          <p class="tekst">My name is Jan Hendrik Vink, I\'m 24 years of age and I live in Nijmegen.</p>
          <p class="tekst">I started my position as Application/Software Developer trainee at Educom on the 8th of September, 2020.</p>
          <p class="tekst">In my spare time I practice a few hobbies:</p>
          <li class="hobbies">Producing music, in particular techno, hip-hop and house.</li>
          <li class="hobbies">Attending concerts (when it\'s safe to do so again!).</li>
          <li class="hobbies">Gaming, I\'ve been a gamer since I was 6 years old.</li>
          <li class="hobbies">Board games, I regularly drink beer and play board games with my roommates and partner.</li>
          <br>';
}
//==============================================
} // End of class
//==============================================
?>