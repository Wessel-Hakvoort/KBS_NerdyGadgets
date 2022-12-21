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
        <h3 style="font-size:40px">Orders</h3>
        <hr>
        <form method="post">
            <input style="Width: 500px;" type="text" placeholder="Zoek een ordernummer" name="orderid" required/>
            <button type="submit" value="Submit" name="orderzoeken" class="button-37">Zoeken</button>
            <br>

            <?php
            if (isset($_POST["orderzoeken"])) {
                print "<br><hr><h3>Ordernummer: " . $_POST["orderid"] . "</h3>";
                print "<br><h5>Klantnummer: ";  gegevensOphalenOrderID($databaseConnection, $_POST["orderid"], "CustomerID");
                print "<br>Orderdatum: ";  gegevensOphalenOrderID($databaseConnection, $_POST["orderid"], "OrderDate");
                print "<br>Totaalprijs: €";  gegevensOphalenOrderID($databaseConnection, $_POST["orderid"], "TotalPrice");
                print "<br>Producten: ";
                $orderlines = alleOrderslinesOpvragenAdmin($_POST["orderid"]);
                foreach ($orderlines as $orderline) {
                    print "<br>Artikelnummer: " . $orderline["StockItemID"] . " -  ";
                    print "" . $orderline["Description"] . "  ";
                    print "[" . $orderline["Quantity"] . "x]   " ;
                    print "[€" . $orderline["Unitprice"] . "] prijs per stuk incl.";
                    print " " . floor($orderline["TaxRate"]) . "% btw";
                }
                print "</h5><br><hr>";
            }
            ?>
            <br>
        </form>
        <br>
        <form method="POST">
            <button type="submit" id="btnDelete" name="btnZero" class="button-37">0</button>
            <button type="submit" id="btnDelete" name="btnDelete" class="button-37"><</button>
            <button type="submit" id="btnSubmit" name="btnSubmit" class="button-37">></button>
        </form>
        <?php
        if (isset($_POST["btnSubmit"])) {
            if (isset($_SESSION["start"])) {
                $start = $_SESSION["start"] + 25;
                $_SESSION["start"] = $start;
            } else {
                $_SESSION["start"] = 25;
            }
        } elseif (isset($_POST["btnDelete"])) {
            if (isset($_SESSION["start"])) {
                $start = $_SESSION["start"] - 25;
                $_SESSION["start"] = $start;
            } else {
                $_SESSION["start"] = 0;
            }
        } else {
            $_SESSION["start"] = 0;
        }
        if ((isset($_POST["btnZero"])) || (empty($_SESSION["start"])) || ($_SESSION["start"] < 0)) {
            $_SESSION["start"] = 0;
        }
        ?>
        <?php
        ?>
        <br>
        <table>
            <thead>
            <tr style='color: #1b1e21; margin-top: -50px'>
                <th style="border-bottom:1pt solid black;">Ordernummer:</th>
                <th style="border-bottom:1pt solid black;">Klantnummer:</th>
                <th style="border-bottom:1pt solid black;">Orderdatum:</th>
                <th style="border-bottom:1pt solid black;">Totaalprijs:</th>
                <th style="border-bottom:1pt solid black;">Producten:</th>
                <th style="border-bottom:1pt solid black;"><?php print $_SESSION["start"] . " - " . $_SESSION["start"] + 25; ?></th>
            </tr>
            </thead>
    </div>
    <?php
    $orders = alleOrdersOpvragenAdmin($_SESSION["start"]);
    foreach ($orders as $order) { ?>
        <tr style="border-bottom:1pt solid black;">
            <?php
            print("<td style='color: #1b1e21'>" . $order["OrderID"] . "</td>");
            print("<td style='color: #1b1e21'>" . $order["CustomerID"] . "</td>");
            print("<td style='color: #1b1e21'>" . $order["OrderDate"] . "</td>");
            print("<td style='color: #1b1e21'>€ " . $order["TotalPrice"] . "</td>"); ?>
            <td style='color: #1b1e21'>
                <?php
                $orderlines = alleOrderslinesOpvragenAdmin($order["OrderID"]);
                foreach ($orderlines as $orderline) {
                    print "- Artikelnummer: " . $orderline["StockItemID"] . " -  ";
                    print "" . $orderline["Description"] . "  ";
                    print "[" . $orderline["Quantity"] . "x]   ";
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
    </div>
    <?php
} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>