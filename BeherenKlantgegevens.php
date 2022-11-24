<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Beheren klantgegevens</title></head>
<body>
<?php
include 'klantfuncties.php';
include __DIR__ . "/header.php";
//$id = 0;
if (isset($_POST["idClient"])){
    $id = $_POST["idClient"];
} else {
    $id = 1072;
}

$klant = enkeleKlantOpvragen($id, $databaseConnection);
?>
<h1 style='color: #1b1e21'>Klantgegevens bewerken of verwijderen</h1>
<table>
    <thead >
    <tr style='color: #1b1e21'><th>Nr</th><th>Naam</th><th>Straat en huisnummer</th><th>Woonplaats</th><th></th><th></th></tr>
    </thead>
    <tbody>
    <?php toon1KlantOpHetScherm($klant); ?>
    </tbody>
</table>
<br>
<a href="BekijkenOverzicht.php">Terug naar het overzicht</a> <!--knop voor terug naar overzicht-->
</body>
</html>