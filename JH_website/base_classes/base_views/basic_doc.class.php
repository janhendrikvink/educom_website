<?php
//==============================================
require_once (BASE_CLASS_PATH.'\base_views\base_html_doc.class.php');
//==============================================
abstract class Basic_Doc extends Base_Html_Doc { // Begin class
//==============================================
// Properties
//==============================================

//==============================================
// Constructor
//==============================================
function __construct()
{}
//==============================================
//
// Methods
//
//==============================================
protected function title() 
{
	// To-do: show page title, requires $page_info from the page_controller class

	echo "<title>JH's Website </title>";
}
//==============================================
private function metaAuthor()
{
    echo '<meta name = "author" content = "Jan Hendrik Vink">';
}
//==============================================
private function cssLinks()
{
    echo '<link rel = "stylesheet" href = "css/jhstyle.css">';
}
//==============================================
private function bodyHeader()
{
    echo '<h1 class="header">Website of Jan Hendrik Vink</h1>';
}
//==============================================
private function mainMenu()
{	
	// To-do: make separate menu class
	// To-do: instantiate menu class
	// To-do: show contact page only when logged in
	// Geert: use getValueFromArray() for the user's name
	// Geert: why array within array and keys where not needed and not where needed?

	if(!isset($_SESSION['user_name']))
	{
		$_SESSION['user_name'] = '';
	}

	$menu_items = ['index' => ['index', 'home', 'HOME', 'nologin', 'yeslogin'],
				   'about' => ['about', 'about', 'ABOUT', 'nologin', 'yeslogin'],
				   'music' => ['music', 'music', 'MUSIC', 'nologin', 'yeslogin'],
				   'shop' => ['shop', 'shop', 'SHOP', 'nologin', 'yeslogin'],
				   'cart' => ['cart', 'cart', 'CART', 'nologin', 'yeslogin'],
				   'login' => ['login', 'login', 'LOGIN', 'nologin'],
				   'logout' => ['logout', 'logout', 'LOGOUT '.$_SESSION['user_name'].'', 'yeslogin'],
				   'register' => ['register', 'register', 'REGISTER', 'nologin'],
				   'contact' => ['contact', 'contact', 'CONTACT', 'nologin', 'yeslogin'], 
				  ];

	echo '<nav>
		<ul class="menu">';
		foreach($menu_items as $item)
		{
			if (isset($_SESSION['login']) === false) // When not logged in, show these menu items
			{
				if(in_array('nologin', $item)) 
				{
					echo '<li class ="'.$item[0].'"><a href="index.php?page='.$item[1].'" method="get" target="_self">'.$item[2].'</a></li>';
				}
			}
			else // When logged in, show these menu items ($_SESSION['login'] === true)
			{
				if(in_array('yeslogin', $item))
				{
					echo '<li class ="'.$item[0].'"><a href="index.php?page='.$item[1].'" method="get" target="_self">'.$item[2].'</a></li>';
				}
			}
		}
	echo '</ul></nav>';
}
//==============================================
abstract function mainContent();
//==============================================
private function bodyFooter()
{
    echo '<footer>
    <p>&copy; Jan Hendrik Vink, 2020</p>
    </footer>';
}
//==============================================
public function headerContent()
{
    $this->title();
    $this->metaAuthor();
    $this->cssLinks();
} 
//==============================================
public function bodyContent()
{
    $this->bodyHeader();
    $this->mainMenu();
    $this->mainContent();
    $this->bodyFooter();
}
//==============================================
} // End of class
//==============================================
?>