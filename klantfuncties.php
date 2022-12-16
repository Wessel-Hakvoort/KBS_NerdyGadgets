<?php
include 'databasefuncties.php';

$gegevens = array("CustomerID" => 0, "CustomerName" => "", "DeliveryAddressLine2" => "", "PostalAddressLine2" => "", "mail" => "", "PhoneNumber" => "", "melding" => "");

function getCustomerID()
{
    if (isset($_SESSION['CustomerID'])) {               //controleren of winkelmandje (=cart) al bestaat
        $id = $_SESSION['CustomerID'];                  //zo ja:  ophalen
    } else {
        $id = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $id;                               // resulterend winkelmandje terug naar aanroeper functie

}


function saveCustomerID($id)
{
    $_SESSION["CustomerID"] = $id;// werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}


//functie voor opvragen alle klanten
function alleKlantenOpvragen($start)
{
    $connection = maakVerbinding();
    $klanten = selecteerKlanten($connection,$start);
    sluitVerbinding($connection);
    return $klanten;
}

//functie voor opvragen 1 klant
function enkeleKlantOpvragen($id, $databaseConnection)
{
    $klant = selecteer1Klant($id, $databaseConnection);
    return $klant;
}


function klantGegevensToevoegen($gegevens)
{
    $connection = maakVerbinding();
    if (voegKlantToe($connection, $gegevens["CustomerName"],$gegevens ["DeliveryAddressLine2"], $gegevens["PostalAddressLine2"], $gegevens["mail"], $gegevens["PhoneNumber"]) == True) {
        $gegevens["melding"] = "<td style='color: #1b1e21'>" . "De klant is toegevoegd";
    } else {
        $gegevens["melding"] = "<td style='color: #1b1e21'>" . "Het toevoegen is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}


function voegKlantToe($connection, $naam, $straatEnHuisnummer, $woonplaats, $mail, $PhoneNumber) {


    $statement = mysqli_prepare($connection, "INSERT INTO customers 
    (CustomerName, BillToCustomerID, CustomerCategoryID, PrimaryContactPersonID, DeliveryMethodID, DeliveryCityID, PostalCityID, AccountOpenedDate, StandardDiscountPercentage, IsStatementSent, IsOnCreditHold, PaymentDays, FaxNumber, WebsiteURL, DeliveryAddressLine2, DeliveryPostalCode, PostalAddressLine1, PostalAddressLine2, PostalPostalCode,LastEditedBy,ValidFrom, mail, PhoneNumber) 
VALUES(?, 1, 3, 1001, 3, 242, 10, '2022-01-01', 0.000, 0, 0, 7, '(088) 469-9911', 'https://www.windesheim.nl', ?, 00000, 'PO Box 6155', ?, 00000, 1, '2022-01-01 00:00:00', ?, ?)");
    mysqli_stmt_bind_param($statement, 'ssssi', $naam, $straatEnHuisnummer, $woonplaats, $mail, $PhoneNumber);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

function verwijderKlant($connection, $id)
{
    $statement = mysqli_prepare($connection, "DELETE FROM customers WHERE CustomerID = $id");
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}


function klantGegevensUpdaten($gegevens)
{
    $connection = maakVerbinding();
    if (gegevensOpslaan($connection, $gegevens["CustomerID"], $gegevens["CustomerName"],$gegevens ["DeliveryAddressLine2"], $gegevens["PostalAddressLine2"], $gegevens["mail"], $gegevens["PhoneNumber"]) == True) {
        $gegevens["melding"] = "De gegevens zijn opgeslagen";
    } else {
        $gegevens["melding"] = "Het opslaan is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}



function gegevensOpslaan($connection, $id, $naam, $straatEnHuisnummer, $woonplaats, $mail, $PhoneNumber) {
    $statement = mysqli_prepare($connection, "UPDATE customers SET CustomerName = ?, DeliveryAddressLine2 = ?, PostalAddressLine2 = ?, mail = ?, PhoneNumber = ? WHERE CustomerID=$id");
    mysqli_stmt_bind_param($statement, 'ssssi', $naam, $straatEnHuisnummer, $woonplaats, $mail, $PhoneNumber);
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

function voegKlantOrderToe($connection, $naam, $straatEnHuisnummer, $woonplaats, $mail, $phonenumber)
{
    $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, DeliveryAddressLine2, PostalAddressLine2, Mail, PhoneNumber) VALUES(?,?,?,?,?)");
    mysqli_stmt_bind_param($statement, 'ssssi', $naam, $straatEnHuisnummer, $woonplaats, $mail, $phonenumber);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

//functie haalt de sessie inhoud op

function voegOrderToe($connection, $totaalprijs)
{
    //order toevoegen
    if (empty($_SESSION["loggedin"])) {
        $statement = mysqli_prepare($connection, "INSERT INTO orders (CustomerID, OrderDate, TotalPrice) VALUES((SELECT CustomerID FROM customers WHERE CustomerID = (SELECT MAX(CustomerID) FROM customers)), CURDATE(), '$totaalprijs')");
        mysqli_stmt_execute($statement);
        return mysqli_stmt_affected_rows($statement) == 1;
    } elseif ($_SESSION["loggedin"] == TRUE) {
        $userid = $_SESSION["id"];
        //zoekt klant gegevens op basis van userid session
        $result = mysqli_query($connection, "SELECT CustomerID FROM customers WHERE CustomerID = (SELECT CustomerID FROM users WHERE userid = $userid);");
        while ($row = mysqli_fetch_array($result)) {
            $CustomerID = $row['CustomerID'];
            $statement = mysqli_prepare($connection, "INSERT INTO orders (CustomerID, OrderDate, TotalPrice) VALUES($CustomerID, CURDATE(), '$totaalprijs')");
            mysqli_stmt_execute($statement);
            return mysqli_stmt_affected_rows($statement) == 1;
        }
    }
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
            $TaxRate = 15;
            $statement = mysqli_prepare($connection, "UPDATE stockitemholdings SET QuantityOnHand = QuantityOnHand - $Quantity WHERE StockItemID = $StockItemID");
            mysqli_stmt_execute($statement);
            $statement = mysqli_prepare($connection, "INSERT INTO orderlines (OrderID, StockItemID, Description, Quantity, UnitPrice, TaxRate, LastEditedWhen) VALUES ((SELECT OrderID FROM orders WHERE OrderID = (SELECT MAX(OrderID) FROM orders)),$StockItemID,'$Description',$Quantity,$UnitPrice,$TaxRate,NOW())");
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


function registerUser($connection, $email, $password_1, $password_2)
{
    //controleren of email al in gebruik is
    $mailcheck = FALSE;
    if (isset($_POST['but-register'])) {
        $result = mysqli_query($connection, "SELECT mail FROM users WHERE mail = '$email'LIMIT 1");
        while ($row = mysqli_fetch_array($result)) {
            $mailcheck = $row['mail'];
        }

        if ($email == $mailcheck) {
            print "<h5 style='text-align:center;color:darkred'>Dit mail adres is al in gebruik!</h5>";
        } elseif ($password_1 == $password_2) {
            $statement = mysqli_prepare($connection, "INSERT INTO users (mail, password, createddate) VALUES('$email','$password_1',NOW());");
            mysqli_stmt_execute($statement);
            print "<h5 style='text-align:center;color:darkgreen'>Account aangemaakt!</h5>";
            mysqli_stmt_affected_rows($statement) == 1;
            echo "<script>window.location = 'register2.php';</script>";
        } else {
            print "<h5 style='text-align:center;color:darkred'>Uw wachtwoorden komen niet overeen!</h5>";
        }
    }
}

function gegevensUser($connection, $naam, $straatEnHuisnummer, $woonplaats, $phonenumber)
{
    //zoekt mailaddres op
    $result = mysqli_query($connection, "SELECT mail FROM users WHERE createddate = (SELECT MAX(createddate) FROM users)");
    while ($row = mysqli_fetch_array($result)) {
        $mail = $row['mail'];
    }
    //voegt rij toe in customers
    $statement = mysqli_prepare($connection, "INSERT INTO customers (CustomerName, DeliveryAddressLine2, PostalAddressLine2, Mail, PhoneNumber) VALUES('$naam','$straatEnHuisnummer','$woonplaats','$mail','$phonenumber');");
    mysqli_stmt_execute($statement);
    mysqli_stmt_affected_rows($statement) == 1;
    //zoekt customerid op
    $result = mysqli_query($connection, "SELECT CustomerID FROM customers WHERE CustomerID = (SELECT MAX(CustomerID) FROM customers)");
    while ($row = mysqli_fetch_array($result)) {
        $CustomerID = $row['CustomerID'];
    }
    //voegt customerid toe in users
    $statement = mysqli_prepare($connection, "UPDATE users SET CustomerID = $CustomerID WHERE mail = '$mail';");
    mysqli_stmt_execute($statement);
    mysqli_stmt_affected_rows($statement) == 1;

    echo "<script>window.location = 'login.php';</script>";
}

function gegevensOphalenUser($connection, $search)
{
    $userid = $_SESSION["id"];
    //zoekt klant gegevens op basis van userid session
    $result = mysqli_query($connection, "SELECT CustomerID, CustomerName, Mail, PhoneNumber, DeliveryAddressLine2, PostalAddressLine2 FROM customers WHERE CustomerID = (SELECT CustomerID FROM users WHERE userid = $userid);");
    while ($row = mysqli_fetch_array($result)) {
        $CustomerID = $row['CustomerID'];
        $CustomerName = $row['CustomerName'];
        $Mail = $row['Mail'];
        $PhoneNumber = $row['PhoneNumber'];
        $Straatnaam = $row['DeliveryAddressLine2'];
        $Woonplaats = $row['PostalAddressLine2'];
    }
    print $$search;
}

function loginUser($connection, $email, $password)
{
    $passwordcheck = FALSE;
    $result = mysqli_query($connection, "SELECT password FROM users WHERE mail = '$email'");
    while ($row = mysqli_fetch_array($result)) {
        $passwordcheck = $row['password'];
    }

    if ($passwordcheck == $password) {
        $result = mysqli_query($connection, "SELECT userid FROM users WHERE mail = '$email'");
        while ($row = mysqli_fetch_array($result)) {
            $userid = $row['userid'];
        }
        $_SESSION["loggedin"] = TRUE;
        $_SESSION["id"] = $userid;
        $_SESSION["mail"] = $email;
        print "<h5 style='text-align:center;color:darkgreen'>U bent succesvol ingelogd!</h5>";
        echo "<script>window.location = 'account.php';</script>";
    } else {
        print "<h5 style='text-align:center;color:darkred'>Uw wachtwoord of email is onjuist!</h5>";
    }
}

function selecteerOrders($databaseConnection)
{
    $userid = $_SESSION["id"];
    $sql = "SELECT OrderID, OrderDate, TotalPrice FROM orders WHERE CustomerID = (SELECT CustomerID FROM users WHERE userid = $userid) ORDER BY OrderDate DESC;";
    $result = mysqli_fetch_all(mysqli_query($databaseConnection, $sql), MYSQLI_ASSOC);
    return $result;
}

function selecteerAdminBeheer($databaseConnection, $customerid)
{
    $sql = "SELECT OrderID, OrderDate, TotalPrice FROM orders WHERE CustomerID = '$customerid' ORDER BY OrderDate DESC;";
    $result = mysqli_fetch_all(mysqli_query($databaseConnection, $sql), MYSQLI_ASSOC);
    return $result;
}

function alleOrdersOpvragen($customerid)
{
    if ($_SESSION["mail"] != "admin") {

        $connection = maakVerbinding();
        $orders = selecteerOrders($connection);
        sluitVerbinding($connection);
        return $orders;
    } elseif ($_SESSION["mail"] == "admin") {
        $connection = maakVerbinding();
        $orders = selecteerAdminBeheer($connection, $customerid);
        sluitVerbinding($connection);
        return $orders;
    }
}

function selecteerOrderslines($databaseConnection, $OrderID)
{
    $sql = "SELECT StockItemID, Description, Quantity, Unitprice, TaxRate FROM orderlines WHERE OrderID = $OrderID;";
    $result = mysqli_fetch_all(mysqli_query($databaseConnection, $sql), MYSQLI_ASSOC);
    return $result;
}

function alleOrderslinesOpvragen($OrderID)
{
    $connection = maakVerbinding();
    $orders = selecteerOrderslines($connection, $OrderID);
    sluitVerbinding($connection);
    return $orders;
}

function verwijderUser($connection, $userid) {
        $statement = mysqli_prepare($connection, "DELETE FROM users WHERE userid = $userid;");
        mysqli_stmt_execute($statement);
        return mysqli_stmt_affected_rows($statement) == 1;
}

function gegevensOphalenAdmin($connection, $search)
{
    //zoekt klant gegevens op basis van userid session
    $result = mysqli_query($connection, "SELECT count(CustomerID) FROM customers;");
    while ($row = mysqli_fetch_array($result)) {
        $CustomerID = $row['count(CustomerID)'];
    }
    $result = mysqli_query($connection, "SELECT count(OrderID) FROM orders;");
    while ($row = mysqli_fetch_array($result)) {
        $OrderID = $row['count(OrderID)'];
    }
    $result = mysqli_query($connection, "SELECT count(userid) FROM users;");
    while ($row = mysqli_fetch_array($result)) {
        $userid = $row['count(userid)'];
    }
    $result = mysqli_query($connection, "SELECT count(StockItemID) FROM stockitems;");
    while ($row = mysqli_fetch_array($result)) {
        $StockItemID = $row['count(StockItemID)'];
    }
    print $$search;
}

function selecteerOrdersAdmin($databaseConnection, $start)
{
    $userid = $_SESSION["id"];
    $sql = "SELECT OrderID, CustomerID, OrderDate, TotalPrice FROM orders ORDER BY OrderDate DESC LIMIT $start, 25;";
    $result = mysqli_fetch_all(mysqli_query($databaseConnection, $sql), MYSQLI_ASSOC);
    return $result;
}

function alleOrdersOpvragenAdmin($start)
{
    $connection = maakVerbinding();
    $orders = selecteerOrdersAdmin($connection, $start);
    sluitVerbinding($connection);
    return $orders;
}

function selecteerOrderslinesAdmin($databaseConnection, $OrderID)
{
    $sql = "SELECT StockItemID, Description, Quantity, Unitprice, TaxRate FROM orderlines WHERE OrderID = $OrderID;";
    $result = mysqli_fetch_all(mysqli_query($databaseConnection, $sql), MYSQLI_ASSOC);
    return $result;
}
function alleOrderslinesOpvragenAdmin($OrderID)
{
    $connection = maakVerbinding();
    $orders = selecteerOrderslinesAdmin($connection, $OrderID);
    sluitVerbinding($connection);
    return $orders;
}

function gegevensOphalenOrderID($connection, $OrderID, $search)
{
    //zoekt klant gegevens op basis van userid session
    $result = mysqli_query($connection, "SELECT CustomerID, OrderDate, TotalPrice FROM orders WHERE OrderID = $OrderID");
    while ($row = mysqli_fetch_array($result)) {
        $CustomerID = $row['CustomerID'];
        $OrderDate = $row['OrderDate'];
        $TotalPrice = $row['TotalPrice'];
    }
    print $$search;
}

function gegevensOphalenCustomerID($connection, $CustomerID, $search)
{
    //zoekt klant gegevens op basis van userid session
    $result = mysqli_query($connection, "SELECT CustomerID, CustomerName, DeliveryAddressLine2, PostalAddressLine2, Mail, PhoneNumber FROM customers WHERE CustomerID = $CustomerID");
    while ($row = mysqli_fetch_array($result)) {
        $CustomerID = $row['CustomerID'];
        $CustomerName= $row['CustomerName'];
        $DeliveryAddressLine2 = $row['DeliveryAddressLine2'];
        $PostalAddressLine2 = $row['PostalAddressLine2'];
        $Mail = $row['Mail'];
        $PhoneNumber = $row['PhoneNumber'];
    }
    print $$search;
}