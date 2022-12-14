<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";
$temperatuur = file_get_contents("http://127.0.0.1:5000");

$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
$StockGroups = getStockItemGroups($_GET['id'], $databaseConnection);
$StockGroupsItems = getStockItemStockGroups($StockGroups, $databaseConnection);
?>

<!--fixed reload van pagina met silent submission-->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
    ?>
    <?php
    if (isset($StockItem['Video'])) {
        ?>
        <div id="VideoFrame">
            <?php print $StockItem['Video']; ?>
        </div>
    <?php }
    ?>


    <div id="ArticleHeader">
        <?php
        if (isset($StockItemImage)) {
            // één plaatje laten zien
            if (count($StockItemImage) == 1) {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                <?php
            } else if (count($StockItemImage) >= 2) { ?>
                <!-- meerdere plaatjes laten zien -->
                <div id="ImageFrame">
                    <div id="ImageCarousel" class="carousel slide" data-interval="false">
                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                ?>
                                <li data-target="#ImageCarousel"
                                    data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                <?php
                            } ?>
                        </ul>

                        <!-- slideshow -->
                        <div class="carousel-inner">
                            <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                ?>
                                <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                    <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <!-- knoppen 'vorige' en 'volgende' -->
                        <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
                <?php
            }
        } elseif (isset($StockItem['BackupImagePath'])) {
            ?>

            <div id="ImageFrame"
                 style="background-image: url(' <?php print "Public/StockGroupIMG/" . $StockItem['BackupImagePath'] ?>'); background-size: cover;"></div>
            <?php
        }
        ?>

        <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
        <h2 class="StockItemNameViewSize StockItemName">
            <?php print $StockItem['StockItemName']; ?>


            <?php
            $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'TEMPERATUUR'");
            if (mysqli_num_rows($result) > 0) {
            if (getChillerStock($StockItem["StockItemID"], $databaseConnection)[0]) {
            foreach ((getChillerStock($StockItem["StockItemID"], $databaseConnection)[0]) as $value)
            if ($value == 1){
            ?>
            <br><br><br><br>
            <h5 style="color: #053d42">Gekoeld product!<br>De temperatuur is:
                <?php

                print $temperatuur . '°C';
                }
                }
                }?></h5>

            <div class="QuantityText">
                <?php
                $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'VOORRAAD'");
                if (mysqli_num_rows($result) > 0) {

                    $aantal = (int)filter_var($StockItem["QuantityOnHand"], FILTER_SANITIZE_NUMBER_INT);
                    print getVoorraadTekst($aantal);

                }
                ?></div>
        </h2>

        <div id="StockItemHeaderLeft">
            <div>
                <form method="post">
                    <button style=" background:transparent; border:none;outline:none;display:block;" type="submit"
                            name="submitVerlanglijstje">
                        <i class="fa-solid fa-border fa-heart"
                           style="color: red; font-size: 35px; --fa-border-padding: 4px; --fa-border-color:#d3d3d3;"></i>
                    </button>
                </form>
                <br>
                <?php
                if (isset($_SESSION["loggedin"])) {
                    if ($_SESSION["loggedin"] == TRUE) {
                        if (isset($_POST["submitVerlanglijstje"])) {              // zelfafhandelend formulier
                            $stockItemID = $StockItem["StockItemID"];

                            $customerid = ophalenCustomerID($databaseConnection);
                            $result = mysqli_query($databaseConnection, "SELECT StockItemID FROM verlanglijstje WHERE CustomerID = '$customerid' AND StockItemID = '$stockItemID'");

                            if (mysqli_num_rows($result) > 0) {
                                // Values already exist in the table, so don't insert them
                                echo "<h5>Item staat al in <a href='accountverlanglijstje.php' style='color: #0b95a2'><u>verlanglijstje</u></a>!</h5>";
                            } elseif (databaseVerlanglijstje($databaseConnection, $stockItemID) == TRUE) { // maak gebruik van geïmporteerde functie
                                print "<h5> Toegevoegd aan <a href='accountverlanglijstje.php' style='color: #0b95a2'><u>verlanglijstje</u></a>!</h5>";
                            } else {
                                print "<h5>Er is iets fout gegaan!</h5>";
                            }
                        }
                    } else {
                        print "<h5 style='position: absolute; top:5vh; width: 15vw; right: 0vh;'><a href='login.php' style='color: #0b95a2'><u>Log eerst in</u></a> om een item aan uw verlanglijstje toe te voegen!</h5>";
                    }
                } else {
                    if (isset($_POST["submitVerlanglijstje"])) {
                        print "<h5 style='position: absolute; top:5vh; width: 15vw; right: 0vh;'><a href='login.php' style='color: #0b95a2'><u>Log eerst in</u></a> om een item aan uw verlanglijstje toe te voegen!</h5>";
                    }
                }
                ?>
            </div>
            <!--                <input class="button-37"  type="submit" name="verlanglijtje_submit" value="Toevoegen aan verlanglijstje">-->
            <div class="CenterPriceLeft">
                <div class="CenterPriceLeftChild">
                    <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b>
                    </p>
                    <h6> Inclusief BTW </h6>
                    <form method="post">
                        <input type="number" name="stockItemID" value="<?php print($StockItem["StockItemID"]) ?>"
                               hidden>
                        <input class="button-37" type="submit" name="submit" value="In winkelmandje">
                    </form>
                    <?php
                    if (isset($_POST["submit"])) {              // zelfafhandelend formulier
                        $stockItemID = $StockItem["StockItemID"];
                        if ($StockItem['QuantityOnHand'] <= 0) {
                            print "Er is niet genoeg voorraad";
                        } else {
                            addProductToCart($stockItemID); // maak gebruik van geïmporteerde functie uit cartfuncties.php
                            $cart = getCart();
                            $naam = $StockItem["StockItemName"];
                            print "<p>Toegevoegd aan <a href='winkelmand.php' style='color: #0b95a2'>winkelmand</a>!</p>";
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="StockItemDescription">
        <h3>Artikel beschrijving</h3>
        <p><?php print $StockItem['SearchDetails']; ?></p>
        <h3>Artikel specificaties</h3>
        <?php
        $CustomFields = json_decode($StockItem['CustomFields'], true);
        if (is_array($CustomFields)) { ?>
            <table>
            <thead>
            <th>Naam</th>
            <th>Data</th>
            </thead>
            <?php
            foreach ($CustomFields as $SpecName => $SpecText) { ?>
                <tr>
                    <td>
                        <?php print $SpecName; ?>
                    </td>
                    <td>
                        <?php
                        if (is_array($SpecText)) {
                            foreach ($SpecText as $SubText) {
                                print $SubText . " ";
                            }
                        } else {
                            print $SpecText;
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </table><?php
        } else { ?>
            <p><?php print $StockItem['CustomFields']; ?>.</p>
            <?php
        }
        ?>
    </div>

    <!--    conversiemaatregel check aan/uit-->
<?php
$result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'AANBEVOLEN'");
if (mysqli_num_rows($result) > 0) {
    ?>
    <!--        conversiemaatregel aanbevolen producten-->
    <div style="margin-top: 380px">
        <h1 class="StockItemNameViewSize StockItemName">Aanbevolen producten:</h1>
        <hr>
        <br>
        <?php
        $i = 0;
        foreach ($StockGroupsItems as $key => $ItemID) {

            $i++;
            $StockItem = getStockItem($ItemID["StockItemID"], $databaseConnection);
            $StockItemImage = getStockItemImage($ItemID['StockItemID'], $databaseConnection);
            ?>
            <a href='view.php?id=<?php print $StockItem['StockItemID']; ?>'>
                <div style="width: 20rem; float: left;">
                    <p style="font-size: 30px; color: #053d42;">
                        <?php print $StockItem["StockItemName"]; ?>
                    </p>
                    <?php
                    if (isset($StockItemImage)) {
                        // één plaatje laten zien
                        if (count($StockItemImage) == 1) {
                            ?>
                            <div id="ImageFrame"
                                 style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                            <?php
                        } else if (count($StockItemImage) >= 2) { ?>
                            <!-- meerdere plaatjes laten zien -->
                            <div id="ImageFrame">
                                <div id="ImageCarousel" class="carousel slide" data-interval="false">
                                    <!-- Indicators -->
                                    <ul class="carousel-indicators">
                                        <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                            ?>
                                            <li data-target="#ImageCarousel"
                                                data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                            <?php
                                        } ?>
                                    </ul>

                                    <!-- slideshow -->
                                    <div class="carousel-inner">
                                        <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                            ?>
                                            <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                                <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- knoppen 'vorige' en 'volgende' -->
                                    <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    } elseif (isset($StockItem['BackupImagePath'])) {
                        ?>
                        <div id="ImageFrame"
                             style="background-image: url(' <?php print "Public/StockGroupIMG/" . $StockItem['BackupImagePath'] ?>'); background-size: cover;"></div>
                        <?php
                    }
                    ?>
                    <p class="StockItemPriceText">
                        <b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b>
                        <button class="button-37" href="view.php?id=<?php print $StockItem['StockItemID']; ?>">
                            Naar product gaan
                        </button>
                    </p>
                </div>
            </a>
        <?php } ?>
    </div>
    <?php
}

} else {
    ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
} ?>
</div>
<?php
include __DIR__ . "/footer.php";
?>