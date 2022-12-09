<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Klant toevoegen</title></head>
<body>
<?php

include __DIR__ . "/header.php";
if (($_SESSION["mail"] != "admin") || (empty($_SESSION["loggedin"])))  {
    echo "<script>window.location = 'login.php';</script>";
}
//gegevens ophalen van de klant door middel van POST
if (isset($_POST["toevoegen"])) {
    $gegevens["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $gegevens["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $gegevens["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
}
?>


<div style="margin-top: 50px; margin-right: 1000px; margin-left: 50px">
    <h1 style='color: #1b1e21'>Klant toevoegen</h1><br><br>
    <form method="post">
        <!--    klantgegevens worden opgesomd en laten zien. Hier kan het ingevuld worden in de tekstschermpjes-->
        <label style='color: #1b1e21'>Naam</label>
        <input type="text" name="CustomerName" value="<?php print($gegevens["CustomerName"]); ?>" required/>
        <br>
        <label style='color: #1b1e21'>Straat en huisnummer</label>
        <input type="text" name="DeliveryAddressLine2" value="<?php print($gegevens["DeliveryAddressLine2"]); ?>"
               required/>
        <br>
        <label style='color: #1b1e21'>Woonplaats</label>
        <input type="text" name="PostalAddressLine2" value="<?php print($gegevens["PostalAddressLine2"]); ?>" required/>
        <br><br>
        <button class='btn btn-dark' type="submit" name="toevoegen">
            Toevoegen klant
        </button>
    </form>


    <p style="color: black"><?php print($gegevens["melding"]); ?></p>
    <form method='post' action="BekijkenOverzicht.php">
        <button class='btn btn-dark' type="submit">
            Terug naar overzicht
        </button>
    </form> <!--knop voor terug naar overzicht-->

</div>
</body>
</html>