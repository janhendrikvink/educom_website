<?php
//==============================================
session_start();

define ("BASE_CLASS_PATH", "C:\Bitnami\wampstack-7.4.10-0\apache2\htdocs\JH_website\base_classes"); // Desktop path
define ("SITE_CLASS_PATH", "C:\Bitnami\wampstack-7.4.10-0\apache2\htdocs\JH_website\website"); // Desktop path

//define ("BASE_CLASS_PATH", "C:\Bitnami\wampstack-7.4.9-0\apache2\htdocs\JH_website\base_classes"); // Laptop path
//define ("SITE_CLASS_PATH", "C:\Bitnami\wampstack-7.4.9-0\apache2\htdocs\JH_website\website"); // Laptop path

require_once (BASE_CLASS_PATH.'\crud\crud.class.php');
require_once (SITE_CLASS_PATH.'\controllers\page_controller.class.php');

$crud = new Crud();
$controller = new Page_Controller($crud);
$controller->handleRequest();
//==============================================
?>