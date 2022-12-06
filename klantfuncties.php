<?php
include 'databasefuncties.php';

$gegevens = array("CustomerID" => 0, "CustomerName" => "", "DeliveryAddressLine2" => "", "PostalAddressLine2" => "", "melding" => "");


//functie voor opvragen alle klanten
function alleKlantenOpvragen() {
    $connection = maakVerbinding();
    $klanten = selecteerKlanten($connection);
    sluitVerbinding($connection);
    return $klanten;
}

//functie voor opvragen 1 klant
function enkeleKlantOpvragen($id, $databaseConnection) {
    $databaseConnection = maakVerbinding();
    $klanten = selecteer1Klant($id, $databaseConnection);
    sluitVerbinding($databaseConnection);
    return $klanten;
}


//functie om 1 of meerdere klanten op het scherm te laten zien
function toonKlantenOpHetScherm($klanten) {
    foreach ($klanten as $klant) {
        print("<tr>");
        print("<td>".$klant["CustomerID"]."</td>");
        print("<td>".$klant["CustomerName"]."</td>");
        print("<td>".$klant["DeliveryAddressLine2"]."</td>");
        print("<td>".$klant["PostalAddressLine2"]."</td>");
        print("<td><a href=\"BeherenKlantgegevens.php?id=".$klant["CustomerID"]."\">Beheren klantgegevens</a></td>");
        print("</tr>");
    }
}




function toon1KlantOpHetScherm($klanten) {
        print("<tr>");
        print_r("<td>".$klanten["CustomerID"]."</td>");
        print_r("<td>".$klanten["CustomerName"]."</td>");
        print_r("<td>".$klanten["DeliveryAddressLine2"]."</td>");
        print_r("<td>".$klanten["PostalAddressLine2"]."</td>");
        print("<td><a href=\"klantfuncties.php".$klanten["CustomerID"]."\">Klantgegevens aanpassen</a></td>");
        print("<td><a href=\"asd".$klanten["CustomerID"]."\">Verwijder klant</a></td>");
        print("</tr>");
}


function klantGegevensToevoegen($gegevens) {
    $connection = maakVerbinding();
    if (voegKlantToe($connection, $gegevens["CustomerName"],$gegevens ["DeliveryAddressLine2"], $gegevens["PostalAddressLine2"]) == True) {
        $gegevens["melding"] = "De klant is toegevoegd";
    } else {
        $gegevens["melding"] = "Het toevoegen is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}

function voegKlantToe($connection, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, DeliveryAddressLine2, PostalAddressLine2) VALUES(?,?,?)");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

//voegt klant toe tijdens het plaatsen van een order wanneer er niet is ingelogd
function klantGegevensOrderToevoegen($gegevens)
{
    $connection = maakVerbinding();
    if (voegKlantOrderToe($connection, $gegevens["CustomerName"], $gegevens ["DeliveryAddressLine2"], $gegevens["PostalAddressLine2"], $gegevens["Mail"], $gegevens["PhoneNumber"]) == True) {
        $gegevens["melding"] = "De klant is toegevoegd";
    } else {
        $gegevens["melding"] = "Het toevoegen is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}
function voegKlantOrderToe($connection, $naam, $straatEnHuisnummer, $woonplaats, $mail, $phonenumber) {
    $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, DeliveryAddressLine2, PostalAddressLine2, Mail, PhoneNumber) VALUES(?,?,?,?,?)");
    mysqli_stmt_bind_param($statement, 'ssssi', $naam, $straatEnHuisnummer, $woonplaats, $mail, $phonenumber);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

//functie haalt de sessie inhoud op

function voegOrderToe($connection)
{
    //order toevoegen
    $statement = mysqli_prepare($connection, "INSERT INTO orders (CustomerID, OrderDate) VALUES((SELECT CustomerID FROM customers WHERE CustomerID = (SELECT MAX(CustomerID) FROM customers)), CURDATE())");
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

function voegOrderLineToe($connection)
{
    //orderlines toevoegen
    $cart = getCart();
    $i = 0;
    foreach ($cart
             as $key => $value) {
        if ($key == "") {
            continue;
        } else {
            $naam = getStockItem($key, $connection);
            $StockItemID = $naam['StockItemID'];
            $Description = $naam['StockItemName'];;
            $Quantity = $cart[$key];
            $UnitPrice = $naam['SellPrice'];
            $statement = mysqli_prepare($connection, "INSERT INTO orderlines (OrderID, StockItemID, Description, Quantity, UnitPrice, LastEditedWhen) VALUES ((SELECT OrderID FROM orders WHERE OrderID = (SELECT MAX(OrderID) FROM orders)),$StockItemID,'$Description',$Quantity,$UnitPrice,NOW())");
            mysqli_stmt_execute($statement);
            deleteProductFromCart($StockItemID);
            mysqli_stmt_affected_rows($statement) == 1;
            $i++;
        }
    }
}
// haalt ordernummer op voor bestelconfirm.php
function LaatsteOrderNummer($connection)
{
    $result = mysqli_query($connection, "SELECT OrderID FROM orders WHERE OrderID = (SELECT MAX(OrderID) FROM orders)");
    while ($row = mysqli_fetch_array($result)) {
        echo $row['OrderID'];
    }
}
