<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";
$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
?>

<!--fixed reload van pagina met silent submission-->
<script>
    if (window.history.replaceState ) {
        window.history.replaceState(null,null,window.location.href);
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
            } elseif(isset($StockItem['BackupImagePath'])) {
                ?>
                <div id="ImageFrame"
                     style="background-image: url(' <?php print "Public/StockGroupIMG/" . $StockItem['BackupImagePath'] ?>'); background-size: cover;"></div>
                <?php
            }
            ?>

            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText"><?php print getVoorraadTekst($StockItem['QuantityOnHand']); ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b>
                        </p>
                        <h6> Inclusief BTW </h6>
                        <form method="post">
                            <input type="number" name="stockItemID" value="<?php print($StockItem["StockItemID"]) ?>" hidden>
                            <input class="buttonNerd" type="submit" name="submit" value="In winkelmandje" style="background-color: #1e7e34" >

                        </form>

                        <?php
                        if (isset($_POST["submit"])) {              // zelfafhandelend formulier
                            $stockItemID = $_POST["stockItemID"];
                            if ($StockItem['QuantityOnHand'] <= 0){
                             print "Er is niet genoeg voorraad";
                            }else {
                                addProductToCart($stockItemID); // maak gebruik van geïmporteerde functie uit cartfuncties.php
                                $cart = getCart();
                                print "<p>Toegevoegd aan winkelwagen! <br> <a href='winkelmand.php' style='color: #0b95a2'>Klik hier om door te gaan </a></p>";
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
        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p style="color: black"><?php print $StockItem['SearchDetails']; ?></p>
            <?php
            // De query haalt de waarden op van de kolommen IsChillerStock en StockItemID uit de tabel stockitems waarbij de waarde van StockItemID = opgehaalde ID
            // en waarbij de waarde van IsChillerStock gelijk is aan 1.
            // Het resultaat wordt opgeslagen in $isChillerStockCheckQueryResult.
            $isChillerStockCheckQuery = "SELECT IsChillerStock, StockItemID FROM stockitems WHERE StockItemID = ". $_GET['id']. " AND IsChillerStock = 1 ";
            $isChillerStockCheckQueryResult = mysqli_query($databaseConnection, $isChillerStockCheckQuery);

            // Haalt 1 temperatuur op uit coldroomtemperatures
            $temperatuurOphaalQuery = "SELECT RecordedWhen,Temperature FROM coldroomtemperatures ORDER BY RecordedWhen DESC LIMIT 1;";
            $temperatuurOphaalQueryResult =mysqli_query($databaseConnection, $temperatuurOphaalQuery);

           // Er wordt hier gebruik gemaakt van sensor 1 (sensor 1 van de 4)
            $sensor = ['ColdRoomSensorNumber'] == 1;

            //Haalt de kolommen RecordedWhen en Temperature op uit de tabel coldroomtemperatures_archive waarbij ColdRoomSensorNumber gelijk is aan 1
            //Result wordt nu nog van eerder opgenomen records gepakt, want live lukt mij niet
            $query = "SELECT RecordedWhen, Temperature FROM coldroomtemperatures_archive WHERE ColdRoomSensorNumber = 1 AND Temperature < 4 ORDER BY RAND()  LIMIT 1";


            // query runnen
            $result = $databaseConnection->query($query);

            // Checken of de query resultaten oplevert
            if ($result->num_rows > 0) {
                // Fetch the first row from the result set
                $row = $result->fetch_assoc();

                // Temperatuur printen
                print("Temperatuur koelruimte: " . $row["Temperature"]. "  °C  ");
                ?>
                <img src="Public/ProductIMGHighRes/koudeKamer.png">
            <?php
            } else {
                // No results were found
                print("Geen resultaten gevonden");
            }
            //            foreach ($isChillerStockCheckQueryResult as $chillerStock){
//                foreach ($temperatuurOphaalQueryResult as $tempInfo) {
//                    $temperatuur = $tempInfo['Temperature'];
//                }
//                print ("Temperatuur koelruimte: " . $temperatuur . "℃");
//            }
            ?>
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
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>
