<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Beheren klantgegevens</title></head>
<body>

<?php
include 'klantfuncties.php';
include __DIR__ . "/header.php";

if (isset($_POST["CustomerID"])) { // zelfafhandelend formulier
    $id = $_POST["CustomerID"];
    saveCustomerID($id);
}



$id = getCustomerID();
$klant = enkeleKlantOpvragen($id, $databaseConnection);

if (isset($_POST["opslaan"])) {
    $klant["CustomerID"] = $id;
    $klant["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $klant["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $klant["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $klant = klantGegevensUpdaten($klant);
}
?>

<h1 style='color: #1b1e21'>Klantgegevens bewerken of verwijderen</h1>
<label style='color: #1b1e21'>Klantnummer:</label>
<?php print("<td style='color: #1b1e21'>" . $klant["CustomerID"] . "</td>"); ?>
<br>
<label style='color: #1b1e21'>Naam</label>
<input type="text" name="CustomerName" value="<?php print($klant["CustomerName"]); ?>" required />
<br>
<label style='color: #1b1e21'><td style='color: #1b1e21'></td>Straat en huisnummer</label>
<input type="text" name="DeliveryAddressLine2" value="<?php print($klant["DeliveryAddressLine2"]); ?>" required />
<br>
<label style='color: #1b1e21'><td style='color: #1b1e21'></td>Woonplaats</label>
<input type="text" name="PostalAddressLine2" value="<?php print($klant["PostalAddressLine2"]); ?>" required />
<br>
<input type="submit" name="opslaan" value="Opslaan" />
<br>

<?php
    if(array_key_exists('button1', $_POST)) {
        verwijderKlant($databaseConnection, $id);
        $url = '/nerdygadgets/BekijkenOverzicht.php';
        header("Location: $url");
    }
?>



<form method="post" >
    <button class='buttonNerd' type='submit' name="button1" value="Button1" formmethod="post" onclick="return confirm('Klant definitief verwijderen?');">
            Klant definitief verwijderen
    </button>
</form>


<br>

<form method='post' action="BekijkenOverzicht.php">
    <input type='number' name='DeleteCustomerID' value="<?php print ($klant["CustomerID"]) ?>" hidden>
    <button class='buttonNerd' type='submit'>
       Terug naar overzicht
    </button>

   <!--knop voor terug naar overzicht-->


</body>
</html>