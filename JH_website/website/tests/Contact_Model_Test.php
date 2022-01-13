<?php
//==============================================
require_once realpath('C:\Bitnami\wampstack-7.4.9-0\apache2\htdocs\opdracht_4\contact_model.class.php');
use PHPUnit\Framework\TestCase;
//==============================================
class Contact_Model_Test extends TestCase { // Begin class
//==============================================
public function testConstructEmpty()
{
    // Prepare

    // Test
    $result = new Contact_Model(null);

    // Validate
    $this->assertNotEmpty($result);
}
//==============================================
public function testConstructNotEmpty()
{
    // Prepare
    $copy = new Contact_Model(null);
    $copy->sql_checked = array(); 
    $copy->contactdata = array();
    $copy->parameters = array();

    // Test
    $result = new Contact_Model($copy);

    // Validate
    $this->assertNotEmpty($result);
    $this->assertEquals(array(), $result->sql_checked);
    $this->assertEquals(array(), $result->contactdata);
    $this->assertEquals(array(), $result->parameters);
}
//==============================================
} // End of class
//==============================================
?>