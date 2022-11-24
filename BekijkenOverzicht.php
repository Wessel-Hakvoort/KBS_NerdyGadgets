<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Klantenoverzicht</title></head>
<body>
<?php include 'klantfuncties.php';
include __DIR__ . "/header.php";
$klanten = alleKlantenOpvragen(); ?>
<h1 style='color: #1b1e21'>Klanten overzicht</h1>
<br>
<p><a href="toevoegenklant.php">Nieuwe klant toevoegen</a></p>
<table>
    <thead >
        <tr  style='color: #1b1e21'><th>Nr</th><th>Naam</th><th>Straat en huisnummer</th><th>Woonplaats</th><th></th><th></th></tr>
    </thead>
    <tbody>
    <?php toonKlantenOpHetScherm($klanten); ?>
    </tbody>
</table>
</body>
</html>