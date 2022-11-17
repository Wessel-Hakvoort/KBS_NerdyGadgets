<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Beheren klantgegevens</title></head>
<body>
<?php
include 'klantfuncties.php';
include __DIR__ . "/header.php";


$klanten = enkeleKlantOpvragen($_GET['id'], $databaseConnection); ?>
<h1>Klantgegevens bewerken of verwijderen</h1>
<table>
    <thead >
    <tr><th>Nr</th><th>Naam</th><th>Straat en huisnummer</th><th>Woonplaats</th><th></th><th></th></tr>
    </thead>
    <tbody>
    <?php toon1KlantOpHetScherm($klanten); ?>
    </tbody>
</table>
<br>
<a href="BekijkenOverzicht.php">Terug naar het overzicht</a> <!--knop voor terug naar overzicht-->
</body>
</html>