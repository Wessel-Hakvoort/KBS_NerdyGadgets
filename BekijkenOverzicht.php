<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Klantenoverzicht</title></head>
<body>
<?php //include 'klantfuncties.php';
include __DIR__ . "/header.php";



if (($_SESSION["mail"] != "admin") || (empty($_SESSION["loggedin"])))  {
    echo "<script>window.location = 'login.php';</script>";
}
if (isset($_POST["DeleteCustomerID"])) { // zelfafhandelend formulier
    unset($_SESSION['CustomerID']);
}


if (isset($_POST["CustomerID"])) { // zelfafhandelend formulier
    $id = $_POST["CustomerID"];
    saveCustomerID($id); //Zet de id van de customer in een sessie
}


$klanten = alleKlantenOpvragen(); ?>
<h1 style='color: #1b1e21'>Klanten overzicht</h1>
<br>
<p><a href="toevoegenklant.php">Nieuwe klant toevoegen</a></p>
<table>
    <thead>
    <tr style='color: #1b1e21'>
        <th>Nr</th>
        <th>Naam</th>
        <th>Straat en huisnummer</th>
        <th>Woonplaats</th>
        <th>E-mail</th>
        <th>Telefoonnummer</th>
    </tr>
    </thead>

    <?php
    foreach ($klanten as $klant) { ?>
        <tr>
            <?php
            print("<td style='color: #1b1e21'>" . $klant["CustomerID"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["CustomerName"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["DeliveryAddressLine2"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["PostalAddressLine2"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["mail"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["PhoneNumber"] . "</td>");
            ?>
            <td>
                <form method='post' action="BeherenKlantgegevens.php">
                    <input type='number' name='CustomerID' value="<?php print ($klant["CustomerID"]) ?>" hidden>
                    <button class='buttonNerd' type='submit' name="buttonCustomerID">
                        Beheren klantgegevens
                    </button>
                </form>
            </td>
        </tr>
    <?php } ?>

    </tbody>
</table>
</body>
</html>