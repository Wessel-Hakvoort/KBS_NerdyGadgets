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
    $statement = mysqli_prepare($connection, "INSERT INTO klant (CustomerName, DeliveryAddressLine2, PostalAddressLine2) VALUES(?,?,?)");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}