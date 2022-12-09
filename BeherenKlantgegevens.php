<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Beheren klantgegevens</title></head>
<body>

<?php
//include 'klantfuncties.php';
include __DIR__ . "/header.php";
if (($_SESSION["mail"] != "admin") || (empty($_SESSION["loggedin"])))  {
    echo "<script>window.location = 'login.php';</script>";
}
if (isset($_POST["CustomerID"])) { // zelfafhandelend formulier
    $id = $_POST["CustomerID"];
    saveCustomerID($id);
}


$id = getCustomerID();
$klant = enkeleKlantOpvragen($id, $databaseConnection);


if (array_key_exists('button1', $_POST)) {
    $url = '/nerdygadgets/BekijkenOverzicht.php';
    header("Location: $url");
    verwijderKlant($databaseConnection, $id);
}


if (isset($_POST["opslaan"])) {
    $gegevens["CustomerID"] = $id;
    $gegevens["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $gegevens["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $gegevens["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $gegevens = klantGegevensUpdaten($gegevens);
    print ' <meta http-equiv="refresh" content="0">';
}
?>
<div style=" margin-left: 20px;">
    <h1 style='color: #1b1e21'>Klantgegevens bewerken of verwijderen</h1>
    <label style="color: black; font-weight: bold">Klantnummer:</label>
    <p style="color: black"><?php print($klant["CustomerID"]); ?></p>
    <br>
    <label style="color: black; font-weight: bold">
        <td style='color: #1b1e21'></td>
        Naam:
    </label>
    <p style=" width: 150px; color: #1b1e21"><?php print($klant["CustomerName"]); ?></p>

    <div>
        <label style="color: black; font-weight: bold">
            <td style='color: #1b1e21'></td>
            Straat en huisnummer:
        </label> <br>
        <p style="width: 150px; color: black"><?php print($klant["DeliveryAddressLine2"]); ?></p>
    </div>
    <div>
        <label style="color: black; font-weight: bold">
            <td style='color: #1b1e21'></td>
            Woonplaats:</label>
        <p style=" width: 150px; color: #1b1e21"><?php print($klant["PostalAddressLine2"]); ?></p>
    </div>

    <div style="margin-top: 50px; margin-right: 1000px">
        <form method="post">
            <label style='color: #1b1e21'>Naam</label>
            <input type="text" name="CustomerName" value="<?php print($gegevens["CustomerName"]); ?>" required/>
            <br>
            <label style='color: #1b1e21'>Straat en huisnummer</label>
            <input type="text" name="DeliveryAddressLine2" value="<?php print($gegevens["DeliveryAddressLine2"]); ?>"
                   required/>
            <br>
            <label style='color: #1b1e21'>Woonplaats</label>
            <input type="text" name="PostalAddressLine2" value="<?php print($gegevens["PostalAddressLine2"]); ?>"
                   required/>
            <br><br>


            <button class='buttonNerd' type='submit' name="opslaan" formmethod="post" onclick="confirm('Deze gegevens wijzigen? De huidige gegevens gaan verloren')">
                Opslaan
            </button>
        </form>
    </div>
<br>
    <form method="post">
        <button class='buttonNerd' type='submit' name="button1" value="Button1" formmethod="post"
                onclick="confirm('Deze klant definitief verwijderen?')">
            Klant verwijderen
        </button>
    </form>


    <br>

    <form method='post' action="BekijkenOverzicht.php">
        <input type='number' name='DeleteCustomerID' value="<?php print ($klant["CustomerID"]) ?>" hidden>
        <button class='buttonNerd' type='submit'>
            Terug naar overzicht
        </button>

        <br><br>

        <!--knop voor terug naar overzicht-->


</body>
</html>