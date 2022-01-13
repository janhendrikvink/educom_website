<?php
//==============================================
require_once (BASE_CLASS_PATH.'\interfaces\i_crud.class.php');
require_once (BASE_CLASS_PATH.'\traits\crud_prop_user.class.php');
//==============================================
class Crud implements I_Crud { // Begin class
//==============================================
// Properties
//==============================================
use Crud_Prop_User;
private $last_error;
//==============================================
// Constructor
//==============================================
public function __construct()
{   
    $this->servername = "127.0.0.1";
    $this->username = "janhendrikvink";
    $this->password = "123";
    $this->dbname = "janhendriks_website";
    $this->connectToDatabase();
}
//==============================================
// Methods
//==============================================
public function connectToDatabase()
{
    try
    {
        // Connect to database
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        
        // set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
        
    catch(PDOException $e) // In case of exception
    {
        echo "Connection failed: " . $e->getMessage();
        $this->last_error = $e;
    }
}
//==============================================
public function runQuery($sql, $parameters)
{
    try
    {
        $this->stmt = $this->conn->prepare($sql);
        foreach ($parameters as $key => $value)
        {
            $this->stmt->bindParam($key, $value);
            unset($value);
        }
        $this->stmt->execute();
    }
    catch (PDOException $e)
    {
        return false;
    }
}
//==============================================
public function create($sql, $parameters) // Create
{
    $sql = $this->runQuery($sql, $parameters);
    if ($sql)
    {
        return $result = $this->conn->lastInsertId();
    }
    else
    {
        return $result = false;
    }
}
//==============================================
public function readOneRow($sql, $parameters) // Read a single row
{
    $sql = $this->runQuery($sql, $parameters);
    if ($sql)
    {
        return $result = $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    else
    {
        return $result = false;
    }
}
//==============================================
public function readMultipleRows($sql, $parameters) // Read
{
    $sql = $this->runQuery($sql, $parameters);
    if ($sql)
    {
        return $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        return $result = false;
    }
}
//==============================================
public function update($sql, $parameters) // Update
{
    $sql = $this->runQuery($sql, $parameters);
    if ($sql)
    {
        return $result = $this->stmt->affected_rows();
    }
    else
    {
        return $result = false;
    }
}
//==============================================
public function delete($sql, $parameters) // Delete
{
    $sql = $this->runQuery($sql, $parameters);
    if ($sql)
    {
        return $result = $this->stmt->affected_rows();
    }
    else
    {
        return $result = false;
    }
}
//==============================================
} // End of class
//==============================================
?>