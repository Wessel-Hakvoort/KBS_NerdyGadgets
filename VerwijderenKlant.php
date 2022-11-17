<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Overzicht klant</title></head>
<body>
<?php
include 'klantfuncties.php';
include __DIR__ . "/header.php";


$klanten = enkeleKlantOpvragen($_GET['id'], $databaseConnection); ?>
<h1>Klantgegevens bewerken of verwijderen</h1>
<p><a href="">test</a></p>
<table>
    <thead >
    <tr><th>Nr</th><th>Naam</th><th>Straat en huisnummer</th><th>Woonplaats</th><th></th><th></th></tr>
    </thead>
    <tbody>
    <?php toonKlantenOpHetScherm($klanten); ?>
    </tbody>
</table>
<br>
<a href="BekijkenOverzicht.php">Terug naar het overzicht</a> <!--knop voor terug naar overzicht-->
</body>
</html>