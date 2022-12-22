<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
//include 'accountfuncties.php';
if (empty($_SESSION["loggedin"])) {
    echo "<script>window.location = 'login.php';</script>";
}
if ($_SESSION["mail"] != "admin") {
    echo "<script>window.location = 'account.php';</script>";
}

if (isset($_POST["DeleteCustomerID"])) { // zelfafhandelend formulier
    unset($_SESSION['CustomerID']);
}

if (isset($_POST["CustomerID"])) { // zelfafhandelend formulier
    $id = $_POST["CustomerID"];
    saveCustomerID($id);
}


$id = getCustomerID();
$klant = enkeleKlantOpvragen($id, $databaseConnection);


if (array_key_exists('button1', $_POST)) {
    $url = '/nerdygadgets/adminklanten.php';
    header("Location: $url");
    verwijderKlant($databaseConnection, $id);
}


if (isset($_POST["opslaan"])) {
    $gegevens["CustomerID"] = $id;
    $gegevens["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $gegevens["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $gegevens["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $gegevens["mail"] = isset($_POST["mail"]) ? $_POST["mail"] : "";
    $gegevens["PhoneNumber"] = isset($_POST["PhoneNumber"]) ? $_POST["PhoneNumber"] : "";
    $gegevens = klantGegevensUpdaten($gegevens);
    print ' <meta http-equiv="refresh" content="0">';
}

if ($_SESSION["loggedin"] == TRUE) {
    ?>
    <div id="FilterFrame" style="width: 350px">
        <div id="ResultsAreaWinkelmandje" class="Browse">
            <br>
            <?php
            if ($_SESSION["mail"] == "admin") {
                ?>
                <a style="color: white; padding-left:10px; font-size:25px;" href="admin.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Home</a>
                <hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminorders.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Orders</a>
                <hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminklanten.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Klanten</a>
                <hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="toggleConversiemaatregel.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Conversiemaatregelen</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>
            <?php }
            ?>
        </div>
    </div>
    <div style="color: #053d42; margin-left: 19%; width: 81%;">
        <h3 style="font-size:40px"><br>Klantgegevens</h3>
        <hr>
        <br>
        <h4><b>Klantnummer:</b> <?php print($klant["CustomerID"]); ?><br>
            <b>Naam:</b> <?php print($klant["CustomerName"]); ?><br>
            <b>Straat en huisnummer: </b><?php print($klant["DeliveryAddressLine2"]); ?><br>
            <b>Woonplaats: </b><?php print($klant["PostalAddressLine2"]); ?><br>
            <b>Mail: </b><?php print($klant["mail"]); ?><br>
            <b>Telefoonnummer: </b><?php print($klant["PhoneNumber"]); ?><br>
            <hr>
            <form method="post">
                <h3>Naam:</h3>
                <input style="width: 500px" type="text" name="CustomerName"
                       value="<?php print($gegevens["CustomerName"]); ?>"/>
                <h3>Straat en huisnummer:</h3>
                <input type="text" style="width: 500px" name="DeliveryAddressLine2"
                       value="<?php print($gegevens["DeliveryAddressLine2"]); ?>"/>
                <h3>Woonplaats:</h3>
                <input type="text" style="width: 500px" name="PostalAddressLine2"
                       value="<?php print($gegevens["PostalAddressLine2"]); ?>"/>
                <h3>Mail:</h3>
                <input type="text" style="width: 500px" name="mail" value="<?php print($gegevens["mail"]); ?>"/>
                <h3>Telefoonnummer:</h3>
                <input type="text" style="width: 500px" name="PhoneNumber"
                       value="<?php print($gegevens["PhoneNumber"]); ?>"/>
                <br><br>
                <button class='button-6' style="background-color: green" type='submit' name="opslaan" formmethod="post"
                        onclick="confirm('Deze gegevens wijzigen? De huidige gegevens gaan verloren')">
                    Opslaan
                </button>
            </form>
            <form method="post">
                <button class='button-6' type='submit' name="button1" value="Button1" formmethod="post"
                        onclick="confirm('Deze klant definitief verwijderen?')">
                    Klant verwijderen
                </button>
            </form>
            <hr>
            <b>Geplaatste orders: </b><br><br>
            <table style="font-size: 20px">
                <thead>
                <tr style='color: #1b1e21'>
                    <th style="border-bottom:1pt solid black;">Ordernummer:</th>
                    <th style="border-bottom:1pt solid black;">Orderdatum:</th>
                    <th style="border-bottom:1pt solid black;">Totaalprijs:</th>
                    <th style="border-bottom:1pt solid black;">Producten:</th>
                </tr>
                </thead>
                <?php
                $orders = alleOrdersOpvragen($klant["CustomerID"]);
                foreach ($orders as $order) { ?>
                    <tr style="border-bottom:1pt solid black;">
                        <?php
                        print("<td style='color: #1b1e21'>" . $order["OrderID"] . "</td>");
                        print("<td style='color: #1b1e21'>" . $order["OrderDate"] . "</td>");
                        print("<td style='color: #1b1e21'>€ " . $order["TotalPrice"] . "</td>"); ?>
                        <td style='color: #1b1e21'>
                            <?php
                            $orderlines = alleOrderslinesOpvragen($order["OrderID"]);
                            foreach ($orderlines as $orderline) {
                                print "- Artikelnummer: " . $orderline["StockItemID"] . " -  ";
                                print "" . $orderline["Description"] . "  ";
                                print "[" . $orderline["Quantity"] . "x]   " ;
                                print "[€" . $orderline["Unitprice"] . "] prijs per stuk incl.";
                                print " " . floor($orderline["TaxRate"]) . "% btw";
                                print "<br>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                } ?>
            </table>
            <!--knop voor terug naar overzicht-->
    </div>
    <?php
} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>