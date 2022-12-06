<?php
include 'databasefuncties.php';

$order = array("OrderID" => 0, "CustomerID" => "");

function voegOrderToe($connection, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "INSERT INTO klant (CustomerName, DeliveryAddressLine2, PostalAddressLine2) VALUES(?,?,?)");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);

    $statement_CustomerID = mysqli_prepare($connection, "SELECT CustomerID FROM klant WHERE CustomerName=? AND DeliveryAddressLine2=? AND PostalAddressLine2=?");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement_CustomerID);
    $result = mysqli_stmt_get_result($statement_CustomerID);
    $row = mysqli_fetch_assoc($result);

    $statement_OrderID = mysqli_prepare($connection, "INSERT INTO orders (CustomerID, SalespersonPersonID, ContactPersonID, OrderDate, LastEditedBy)
                                                                VALUES(?, 1, 1, '2020-11-11', 1)");

    return mysqli_stmt_affected_rows($statement) == 1;
}