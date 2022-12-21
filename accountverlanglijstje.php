<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";


if (empty($_SESSION["loggedin"])) {
    echo "<script>window.location = 'login.php';</script>";
}
if ($_SESSION["mail"] == "admin") {
    echo "<script>window.location = 'BekijkenOverzicht.php';</script>";
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
                <a style="padding-left:10px; font-size:25px;" href="accountbestellingen.php" class="HrefDecoration"><i
                    <i
                            class="fa-regular fa-clipboard"></i></i> Bestellingen</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="accountverlanglijstje.php" class="HrefDecoration"><i
                            class="fa-regular fa-heart"></i> Verlanglijstje</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration"><i
                            class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>

            <?php }
            if ($_SESSION["mail"] == "admin") {
                ?>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminoverzicht.php"
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
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminaccounts.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Accounts</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration"><i
                            class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>
            <?php }
//            $orders = alleOrdersOpvragen();
            ?>
        </div>
    </div>

    <?php
//session_destroy();
    $verlanglijstje = selectVerlanglijst($databaseConnection);

//print_r($verlanglijstje[0][0]);
    $StockItem = getStockItem($verlanglijstje, $databaseConnection);
    $StockItemImage = getStockItemImage($verlanglijstje, $databaseConnection);

    ?>

    <?php
    if ($verlanglijstje) {
        ?>
        <h1 style="color: #053d42; margin-left: 19%; width: 81%;">Verlanglijstje</h1><br><br>
        <div>
        <?php
        foreach ($verlanglijstje
                 as $key => $value) {
            $naam = getStockItem($value[0], $databaseConnection);
            $foto = getStockItemImage($value[0], $databaseConnection);
            ?>
            <div style="color: #053d42; margin-left: 19%; width: 81%;">
                <div id="ImageFrame"
                     style="margin-left: 5%; margin-bottom: 1%; background-image: url('Public/StockItemIMG/<?php print $foto[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                <h2 class="StockItemNameViewSize StockItemName" style="margin-top: 1%; width: 1500px">
                    <?php
                    $itemID = $value[0];
                    $itemNaam = $naam['StockItemName'];
                    print "<a href='view.php?id=$itemID 'style='color: #0b95a2;'>$itemNaam</a>"; ?>
                </h2>
                <p style="color: black"><?php print $naam['SearchDetails']; ?></p>
                <br><br>
                <p class="StockItemPriceText">
                    <b><?php print sprintf("€ %.2f", $naam['SellPrice']); ?></b>
                <h6 style="color: black"> Inclusief BTW </h6>
                </p>
                <div>
                    <form method="post" class="pr-2">
                        <input type="number" name="DeleteItem" value="<?php print($naam["StockItemID"]) ?>"
                               hidden>
                        <button class="btn btn-outline-danger" type="submit"
                                name="delete2" id="button-addon2">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    <div class="CenterPriceLeftChild" style="margin-left: 40%; margin-right: 45%;">
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print($naam["StockItemID"]) ?>"
                                   hidden>
                            <input class="button-37" type="submit" name="submit" value="In winkelmandje">
                        </form>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
            </div>
            <hr style="width: 60vw; border-bottom: solid #053d42;">
            <?php

            if (isset($_POST["DeleteItem"])) { // zelfafhandelend formulier
                $stockItemID = $_POST["DeleteItem"]; //
                deleteFromVerlanglijstje($databaseConnection, $stockItemID); // maak gebruik van geïmporteerde functie uit Header.php
                print ' <meta http-equiv="refresh" content="0">';
            }
        }

        if (isset($_POST["stockItemID"])) {              // zelfafhandelend formulier
            $stockItemID = $_POST["stockItemID"];
            if ($StockItem['QuantityOnHand'] <= 0) {
                print "Er is niet genoeg voorraad";
            } else {
                addProductToCart($stockItemID);  // maak gebruik van geïmporteerde functie uit cartfuncties.php
                $cart = getCart();
                deleteFromVerlanglijstje($databaseConnection, $stockItemID);
                print '<script onclick= type="text/javascript">
       window.onload = function () { alert("Product is toegevoegd aan winkelmand"); } 
</script>';
                print ' <meta http-equiv="refresh" content="0">';
            }
        }

    } else {
        ?>
        <div class="StockItemName" style="text-align: center">
            <br>
            <br>
            <br>
            <h1>Uw verlanglijstje is leeg :(</h1>
            <h3>klik <a href="browse.php">hier </a>om producten te zoeken</h3>
            <br>
        </div>
        <?php
    }


} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>