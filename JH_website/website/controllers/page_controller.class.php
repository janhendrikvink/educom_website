<?php
//==============================================
require_once (BASE_CLASS_PATH.'\tools\tools.class.php');
require_once (BASE_CLASS_PATH.'\base_controllers\base_controller.class.php');
require_once (SITE_CLASS_PATH.'\models\page_model.class.php');
require_once (SITE_CLASS_PATH.'\controllers\validation_controller.class.php');
require_once (SITE_CLASS_PATH.'\controllers\user_controller.class.php');
require_once (SITE_CLASS_PATH.'\controllers\contact_controller.class.php');
require_once (SITE_CLASS_PATH.'\controllers\shop_controller.class.php');
require_once (SITE_CLASS_PATH.'\views\home_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\about_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\music_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\error_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\form_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\thanks_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\shop_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\product_doc.class.php');
require_once (SITE_CLASS_PATH.'\views\cart_doc.class.php');
//==============================================
class Page_Controller extends Base_Controller { // Begin class
//==============================================
// Properties
//==============================================
protected $tools;
protected $requested_type;
protected $requested_page;
protected $page_model;
protected $field_info;
protected $form_info;
protected $validation_controller;
protected $user_controller;
protected $contact_controller;
protected $shop_controller;
protected $post_result;
protected $form_error;
protected $message_info;
protected $page_output;
//==============================================
// Constructor
//==============================================
public function __construct(Crud $crud)
{
    parent::__construct($crud);
    $this->tools = new Tools();
    $this->form_info = [];
    $this->post_result = [];
}
//==============================================
// Methods
//==============================================
public function handleRequest()
{
    $this->getRequestedPage();
    $this->processRequest();
    $this->showResponsePage();
}
//==============================================
protected function getRequestedPage()
{
    $this->requested_type = $_SERVER['REQUEST_METHOD'];
    
    if ($this->requested_type == 'POST')
    {
        $this->requested_page=$this->tools->getPostVar('page','home'); 
    } 
    else 
    { 
        $this->requested_page=$this->tools->getUrlVar('page','home');
    }
}
//==============================================
protected function processRequest()
{   
    // To-do: put readCart() method from the Shop_Controller in the User_Controller?
    // To-do: put saveCart() method from the Shop_Controller in the User_Controller?
    // To-do: add remaining POST request switch cases
    // To-do: instantiate User-Controller for every request to check whether the user is logged in
    // To-do: pass the $login variable to the other controllers so they can use it
    
    $this->page_model = new Page_Model($this->crud);
    $this->page_info = $this->page_model->getPageInfo($this->requested_page);
    
    if ($this->requested_type == 'POST')
    {
        if ($this->tools->getValueFromArray($this->page_info, 'needs_post_validation', true) === true)
        {     
            $this->field_info = $this->tools->getValueFromArray($this->page_info, 'fields', 'nothing');
            $validation_controller = new Validation_Controller($this->crud, $this->field_info);
            $this->post_result = $this->validation_controller->handleRequest($this->field_info);
            if ($this->post_result['valid'] === true)
            {
                $type = $this->tools->getValueFromArray($this->page_info, 'after_okay_validation', 'nothing'); // Takes the name of the controller
                if ($type !== 'nothing')
                {
                    $ucfirsttype = ucfirst($type); // Makes the first letter of the controller name capital
                    $ucfirsttype.="_Controller"; // Adds '[Name]_Controller'
                    $this->{$type.'_controller'} = new $ucfirsttype($this->crud, $this->post_result); // $this->[name]_controller = new [Name]_Controller
                    $this->message_info = $this->{$type.'_controller'}->handleRequest($this->crud, $this->post_result);
                    if ($this->message_info['crud'] !== false) // The CRUD query completed successfully
                    {
                        switch ($this->requested_page)
                        {
                            case 'contact':
                                $this->requested_page = 'thanks';
                                break;
                        }
                    }
                    else // The CRUD query failed
                    {
                        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
                        switch ($this->requested_page)
                        {
                            case 'contact':
                                $this->requested_page = 'contact';
                                $this->form_error = "Database connection failed, please try again.";
                                break;
                        }
                    }
                }
            }
            else
            {
                $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
            }
        }
    }
    else // GET requests
    {
        switch ($this->requested_page)
        {
            case 'login':
            case 'register':
            case 'contact':
                $this->field_info = $this->page_model->getFieldsByPage($this->requested_page);
                $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
                break;
            case 'shop':
                $this->shop_controller = new Shop_Controller();
                $this->shop_controller->handleRequest($crud);
                //$this->shop_data = $this->shop_controller->getShop();  
                break;
            case 'product':
                $this->field_info = $this->page_model->getFieldsByPage($this->requested_page);
                $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
                $this->shop_controller = new Shop_Controller();
                $this->shop_controller->handleRequest($crud);
                //$this->product_data = $this->shop_controller->getProduct();  
                break;
            case 'cart':
                $this->field_info = $this->page_model->getFieldsByPage($this->requested_page);
                $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
                $this->shop_controller = new Shop_Controller();
                $this->shop_controller->handleRequest($crud);
                //$this->cart_data = $this->shop_controller->getProductInfo();
                //$this->cart_data = $this->shop_controller->getProductTotalPrice($this->cart_data);
                //$this->cart_total_price = $this->shop_controller->getCartTotalPrice($this->cart_data);
                //$this->shop_controller->removeProduct();
                //$this->shop_controller->placeOrder($this->cart_data);
                break;
            case 'logout':
                $this->shop_controller = new Shop_Controller();
                $this->shop_controller->handleRequest($crud);
                $this->user_controller = new User_Controller();
                $this->user_controller->handleRequest($crud);
                $this->requested_page = 'home';
            default:
                $this->requested_page;
                break;
        }
    }
}
//==============================================
protected function showResponsePage()
{
    // Geert: not the place to implement a logout function, do this in the User_Controller
    // To-do: make generic Page_Doc instead of Home_Doc, About_Doc et cetera

    switch ($this->requested_page)
    {
        case 'home':
            $this->page_output = new Home_Doc();
            break;
        case 'about':
            $this->page_output = new About_Doc();
            break;
        case 'music':
            $this->page_output = new Music_Doc();
            break;
        case 'shop':
            $this->page_output = new Shop_Doc($this->shop_data);  
            break;
        case 'product':
            $this->page_output = new Product_Doc($this->requested_page, $this->field_info, $this->form_info, $this->form_error, $this->product_data, $this->post_result);
            break;
        case 'cart':
            $this->page_output = new Cart_Doc($this->requested_page, $this->field_info, $this->form_info, $this->form_error, $this->post_result, $this->cart_data, $this->cart_total_price);
            break;
        case 'login':
        case 'register':
        case 'contact':
            $this->page_output = new Form_Doc($this->requested_page, $this->field_info, $this->form_info, $this->form_error, $this->post_result);
            break;
        case 'thanks':
            $this->page_output = new Thanks_Doc($this->message_info);
            break;
        case 'logout':
            //$this->shop_controller = new Shop_Controller();
            //$this->shop_controller->saveCart();
            //unset($_SESSION['login']);
            //unset($_SESSION['name']);
            //unset($_SESSION['cart']);
            $this->page_output = new Home_Doc();
            break;
        default:
            $this->page_output = new Error_Doc();
            break;
    }
    $this->page_output->showPageContent();
}
//==============================================
protected function checkLogin()
{
    // To-do: implement this in the handleRequest() of the User_Controller
    
    $this->user_controller = new User_Controller($this->post_result);
    $this->sql_checked = $this->user_controller->login($this->post_result);
    if ($this->sql_checked['valid'] === true)
    {
        $this->shop_controller = new Shop_Controller();
        $this->shop_controller->readUserCart();
        $this->requested_page = "home";
    }
    else
    {
        $this->requested_page = "login";
        $this->form_error = "User not recognized, please try again.";
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
    }
}
//==============================================
protected function checkRegister()
{
    // To-do: implement this in the handleRequest() of the User_Controller
    
    $this->user_controller = new User_Controller($this->post_result);
    $this->sql_checked = $this->user_controller->register($this->post_result);
    if ($this->sql_checked['repeat_password_okay'] === true)
    {
        if ($this->sql_checked['valid'] === true)
        {
            $this->requested_page = "login";
            $this->field_info = $this->page_model->getFieldsByPage($this->requested_page);
            $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
        }
        else
        {
            $this->requested_page = "register";
            $this->form_error = "User already registered, please try to log in.";
            $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
        }
    }
    else
    {
        $this->requested_page = "register";
        $this->form_error = "Repeated password is incorrect, please try again.";
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
    }
}
//==============================================
protected function checkContact()
{
    // To-do: implement this in the handleRequest() of the Contact_Controller
    
    $this->contact_controller = new Contact_Controller($this->post_result, $this->crud);
    $this->sql_checked = $this->contact_controller->sendMessage($this->post_result);
    if ($this->sql_checked !== false)
    {
        $this->requested_page = 'thanks';
    }
    else
    {
        $this->requested_page = 'contact';
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
        $this->form_error = "Database connection failed, please try again.";
    }
}
//==============================================
protected function checkProduct()
{
    // To-do: implement this in the handleRequest() of the Shop_Controller
    
    $this->shop_controller = new Shop_Controller($this->post_result);
    $this->product_data = $this->shop_controller->getProduct();
    $this->product_added = $this->shop_controller->addToCart($this->post_result, $this->product_data);
    if ($this->product_added === true)
    {
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
    }
    else
    {
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
        $this->form_error = "Products can only be added when the user is logged in.";
    }
}
//==============================================
protected function checkCart()
{
    // Geert: sloppy if-else statement
    // To-do: implement this in the handleRequest() of the Shop_Controller
    
    $this->shop_controller = new Shop_Controller($this->post_result);
    $this->product_added = $this->shop_controller->addToCart($this->post_result, $this->product_data);
    if ($this->product_added === true)
    {
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
        $this->cart_data = $this->shop_controller->getProductInfo();
        $this->cart_data = $this->shop_controller->getProductTotalPrice($this->cart_data);
        $this->cart_total_price = $this->shop_controller->getCartTotalPrice($this->cart_data);
        var_dump($this->post_result);
    }
    else
    {
        $this->form_info = $this->page_model->getFormInfoByPage($this->requested_page);
        $this->cart_data = $this->shop_controller->getProductInfo();
        $this->cart_data = $this->shop_controller->getProductTotalPrice($this->cart_data);
        $this->cart_total_price = $this->shop_controller->getCartTotalPrice($this->cart_data);
        $this->form_error = "Unexpected error: couldn't change amount.";
    }
}
//==============================================
} // End of class
//==============================================
?>