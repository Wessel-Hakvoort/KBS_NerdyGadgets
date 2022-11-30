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

//$id = 0;
$id = getCustomerID();
print_r($id); //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$klant = enkeleKlantOpvragen($id, $databaseConnection);
?>
<h1 style='color: #1b1e21'>Klantgegevens bewerken of verwijderen</h1>
<table>
    <thead>
    <tr style='color: #1b1e21'>
        <th>Nr</th>
        <th>Naam</th>
        <th>Straat en huisnummer</th>
        <th>Woonplaats</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
//    print_r($id); //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    print("<tr>");
    print("<td style='color: #1b1e21'>".$klant["CustomerID"]."</td>");
    print("<td style='color: #1b1e21'>".$klant["CustomerName"]."</td>");
    print("<td style='color: #1b1e21'>".$klant["DeliveryAddressLine2"]."</td>");
    print("<td style='color: #1b1e21'>".$klant["PostalAddressLine2"]."</td>");
    print("</tr>");
    ?>

    </tbody>
</table>
<br>

<form method='post' action="BekijkenOverzicht.php">
    <input type='number' name='DeleteCustomerID' value="<?php print ($klant["CustomerID"]) ?>" hidden>
    <button class='btn btn-dark' type='submit'>
       Terug naar overzicht
    </button>
</form>

   <!--knop voor terug naar overzicht-->


</body>
</html>