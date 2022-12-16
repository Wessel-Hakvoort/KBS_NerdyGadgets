<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";

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
            `
            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText">
                <?php
                    $aantal = (int) filter_var($StockItem["QuantityOnHand"],FILTER_SANITIZE_NUMBER_INT);
                    print getVoorraadTekst($aantal);
                ?></div>
            <div id="StockItemHeaderLeft">
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
                        <?php // zelfafhandelend formulier
                        if (isset($_POST["submit"])) {
                            $stockItemID = $_POST["stockItemID"];
                            if ($StockItem['QuantityOnHand'] <= 0) {
                                print "Er is niet genoeg voorraad";
                            } else {
                                addProductToCart($stockItemID); // maak gebruik van geïmporteerde functie uit cartfuncties.php
                                $naam = $StockItem["StockItemName"];
                                print "<script type='text/javascript'>alert('$naam is toegevoegd aan de winkelwagen')</script>";
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
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
        <hr>
        <div>
            <?php
            $i = 0;
            foreach ($StockGroupsItems as $key => $ItemID) {

                $i++;
                $StockItem = getStockItem($ItemID["StockItemID"], $databaseConnection);
                ?>
                <a  href='view.php?id=<?php print $StockItem['StockItemID']; ?>'>
                    <div style="width: 20rem; float: left;">
                        <h2 class="StockItemNameViewSize StockItemName">
                            <?php print $StockItem["StockItemName"]; ?>
                        </h2>
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
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print($StockItem["StockItemID"]) ?>"
                                   hidden>
                            <input class="button-37" style="width: 15rem;" type="submit" name="submit"
                                   value="In winkelmandje">
                        </form>
                        </p>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>



