<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Klant toevoegen</title></head>
<body>
<?php
include 'klantfuncties.php';

//gegevens ophalen van de klant door middel van POST
if (isset($_POST["toevoegen"])) {
    $gegevens["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $gegevens["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $gegevens["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
}
?>



<h1>Klant toevoegen</h1><br><br>
<form method="post">
<!--    klantgegevens worden opgesomd en laten zien. Hier kan het ingevuld worden in de tekstschermpjes-->
    <label>Naam</label>
    <input type="text" name="CustomerName" value="<?php print($gegevens["CustomerName"]); ?>" />
    <br>
    <label>Straat en huisnummer</label>
    <input type="text" name="DeliveryAddressLine2" value="<?php print($gegevens["DeliveryAddressLine2"]); ?>" />
    <br>
    <label>Woonplaats</label>
    <input type="text" name="PostalAddressLine2" value="<?php print($gegevens["PostalAddressLine2"]); ?>" />
    <br>
    <input type="submit" name="toevoegen" value="Toevoegen" />
</form>
<br><?php print($gegevens["melding"]); ?><br>
<a href="BekijkenOverzicht.php">Terug naar het overzicht</a> <!--knop voor terug naar overzicht-->
</body>
</html>