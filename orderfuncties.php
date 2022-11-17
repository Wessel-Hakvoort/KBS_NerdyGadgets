<?php
include 'databasefuncties.php';

$order = array("OrderID" => 0, "CustomerID" => "");

function voegOrderToe($connection, $customerID) {
    $query = "SELECT CustomerID FROM klant WHERE CustomerName=$CustomerName";
    $statement = mysqli_prepare($connection, "INSERT INTO orders (CustomerID) VALUES($query)");
    mysqli_stmt_bind_param($statement, 'sss', $customerID);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}