<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
//include 'accountfuncties.php';
if (empty($_SESSION["loggedin"])) {
    echo "<script>window.location = 'login.php';</script>";
}
if ($_SESSION["mail"] == "admin") {
    echo "<script>window.location = 'admin.php';</script>";
}
if ($_SESSION["loggedin"] == TRUE) {
    ?>
    <div id="FilterFrame" style="width: 350px">
        <div id="ResultsAreaWinkelmandje" class="Browse">
            <br>
            <?php
            if ($_SESSION["mail"] != "admin") {
                ?>
                <a style="padding-left:10px; font-size:25px;" href="account.php" class="HrefDecoration"><i
                            class="fa-regular fa-user"></i> Mijn account</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="accountbestellingen.php" class="HrefDecoration"><i <i
                            class="fa-regular fa-clipboard"></i></i> Bestellingen</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="accountverlanglijstje.php" class="HrefDecoration"><i
                            class="fa-regular fa-heart"></i> Verlanglijstje</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="accountaanbevolen.php" class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Aanbevolen</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration"><i class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>

            <?php }
            if ($_SESSION["mail"] == "admin") {
                ?>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminoverzicht.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Home</a><hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminorders.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Orders</a><hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminklanten.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Klanten</a><hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminaccounts.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Accounts</a><hr>
                <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration"><i class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>
            <?php }
            $orders = alleOrdersOpvragen();
            ?>
        </div>
    </div>
    <div style="color: #053d42; margin-left: 19%; width: 81%;">
        <h3 style="font-size:40px">Mijn bestellingen</h3>
        <hr>
        <table>
            <thead>
            <tr style='color: #1b1e21'>
                <th style="border-bottom:1pt solid black;">Ordernummer:</th>
                <th style="border-bottom:1pt solid black;">Orderdatum:</th>
                <th style="border-bottom:1pt solid black;">Totaalprijs:</th>
                <th style="border-bottom:1pt solid black;">Producten:</th>
            </tr>
            </thead>
            <?php
            $orders = alleOrdersOpvragen("niks");
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
    </div>

    <?php
} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>