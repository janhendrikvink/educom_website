<?php
//==============================================
interface I_Crud { // Begin interface
//==============================================
// Methods
//==============================================
public function connectToDatabase();
//==============================================
public function create($sql, $parameters);
//==============================================
public function readOneRow($sql, $parameters);
//==============================================
public function readMultipleRows($sql, $parameters);
//==============================================
public function update($sql, $parameters);
//==============================================
public function delete($sql, $parameters);
//==============================================
} // End of interface
//==============================================
?>