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
    print($id);
    $_SESSION["CustomerID"] = $id;// werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}


function deleteCustomerID($id){
    $item = getCustomerID();
    print $id;
    if (array_key_exists($id, $item)) {
        unset($item[$id]);
    }
    saveCustomerID($item);
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


//functie om 1 of meerdere klanten op het scherm te laten zien
function toonKlantenOpHetScherm($klanten) {
    foreach ($klanten as $klant) {
        print("<tr>");
        print("<td style='color: #1b1e21'>".$klant["CustomerID"]."</td>");
        print("<td style='color: #1b1e21'>".$klant["CustomerName"]."</td>");
        print("<td style='color: #1b1e21'>".$klant["DeliveryAddressLine2"]."</td>");
        print("<td style='color: #1b1e21'>".$klant["PostalAddressLine2"]."</td>");
//        print("<td>
//                    <form method='post'>
//                    <input type='number' name='CustomerID' value='" ." ' hidden>
//                        <button class='btn btn-dark' type='submit' formaction='BeherenKlantgegevens.php'>Beheren klantgegevens</button>
//                    </form>
//              </td>");

        print("</tr>");
    }
    print $_POST["CustomerID"];
    if (isset($_POST["CustomerID"])) { // zelfafhandelend formulier
        $id = $_POST["CustomerID"];
        print $id;
        saveCustomerID($id); // maak gebruik van geïmporteerde functie uit header.php
    }
}

//print("<td><form action=BeherenKlantgegevens.php?id=".$klant["CustomerID"]."\">
//                        <button class='btn btn-dark' type=submit'>Beheren klantgegevens</button>
//                    </form>
//              </td>");

//print("<td><button class='btn btn-dark' type='submit'><a href=\"c"\">Beheren klantgegevens</a></button></td>");



function toon1KlantOpHetScherm($klant) {
        print("<tr>");
        print("$klant");
        print("<td>".$klant["CustomerID"]."</td>");
        print_r("<td>".$klant["CustomerName"]."</td>");
        print_r("<td>".$klant["DeliveryAddressLine2"]."</td>");
        print_r("<td>".$klant["PostalAddressLine2"]."</td>");
        print_r("<td><a href=\"klantfuncties.php".$klant["CustomerID"]."\">Klantgegevens aanpassen</a></td>");
        print_r("<td><a".$klant["CustomerID"]."\">Verwijder klant</a></td>");
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

function verwijderKlant($connection, $naam, $straatEnHuisnummer, $woonplaats) {
    $statement = mysqli_prepare($connection, "DELETE FROM KLANT WHERE CustomerID = 1069");
    mysqli_stmt_bind_param($statement, 'sss', $naam, $straatEnHuisnummer, $woonplaats);
    mysqli_stmt_execute($statement);
    return mysqli_stmt_affected_rows($statement) == 1;
}