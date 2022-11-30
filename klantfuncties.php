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
//    print $id;
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
        $gegevens["melding"] = "De klant is toegevoegd";
    } else {
        $gegevens["melding"] = "Het toevoegen is mislukt";
    }
    sluitVerbinding($connection);
    return $gegevens;
}

function voegKlantToe($connection, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "INSERT INTO klant (CustomerName, DeliveryAddressLine2, PostalAddressLine2) VALUES(?,?,?)");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}

function verwijderKlant($connection, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "DELETE FROM KLANT WHERE CustomerID = 1069");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}