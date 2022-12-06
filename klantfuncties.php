<?php
include 'databasefuncties.php';

$gegevens = array("CustomerID" => 0, "CustomerName" => "", "DeliveryAddressLine2" => "", "PostalAddressLine2" => "", "melding" => "");

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
function alleKlantenOpvragen() {
    $connection = maakVerbinding();
    $klanten = selecteerKlanten($connection);
    sluitVerbinding($connection);
    return $klanten;
}

//functie voor opvragen 1 klant
function enkeleKlantOpvragen($id, $databaseConnection) {
    $klant = selecteer1Klant($id, $databaseConnection);
    return $klant;
}


function klantGegevensToevoegen($gegevens) {
    $connection = maakVerbinding();
    if (voegKlantToe($connection, $gegevens["CustomerName"],$gegevens ["DeliveryAddressLine2"], $gegevens["PostalAddressLine2"]) == True) {
        $gegevens["melding"] = "<td style='color: #1b1e21'>" . "De klant is toegevoegd";
    } else {
        $gegevens["melding"] = "<td style='color: #1b1e21'>" . "Het toevoegen is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}

function voegKlantToe($connection, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "INSERT INTO customers 
    (CustomerName, BillToCustomerID, CustomerCategoryID, PrimaryContactPersonID, DeliveryMethodID, DeliveryCityID, PostalCityID, AccountOpenedDate, StandardDiscountPercentage, IsStatementSent, IsOnCreditHold, PaymentDays, PhoneNumber, FaxNumber, WebsiteURL, DeliveryAddressLine2, DeliveryPostalCode, PostalAddressLine1, PostalAddressLine2, PostalPostalCode,LastEditedBy,ValidFrom) 
VALUES(?, 1, 3, 1001, 3, 242, 10, '2022-01-01', 0.000, 0, 0, 7, '(088) 469-9911', '(088) 469-9911', 'https://www.windesheim.nl', ?, 00000, 'PO Box 6155', ?, 00000, 1, '2022-01-01 00:00:00')");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

function verwijderKlant($connection, $id) {
    $statement = mysqli_prepare($connection, "DELETE FROM customers WHERE CustomerID = $id");
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}


function klantGegevensUpdaten($gegevens) {
    $connection = maakVerbinding();
    if (gegevensOpslaan($connection, $gegevens["CustomerID"], $gegevens["CustomerName"],$gegevens ["DeliveryAddressLine2"], $gegevens["PostalAddressLine2"]) == True) {
        $gegevens["melding"] = "De gegevens zijn opgeslagen";
    } else {
        $gegevens["melding"] = "Het opslaan is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}



function gegevensOpslaan($connection, $id, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "UPDATE customers SET CustomerName = ?, DeliveryAddressLine2 = ?, PostalAddressLine2 = ? WHERE CustomerID=$id");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}