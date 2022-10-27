<!-- dit bestand bevat alle code voor de pagina waar het winkelmandje te zien is -->
<?php
include __DIR__ . "/header.php";

$cart = isset($_COOKIE["cart"]) ?$_COOKIE["cart"] :"[]";
$cart = json_decode($cart);

$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);

?>

<?php

?>
<div id="CenteredContent">
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
        } else {
            ?>
            <div id="ImageFrame"
                 style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
            <?php
        }
        ?>


        <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
        <h2 class="StockItemNameViewSize StockItemName">
            <?php print $StockItem['StockItemName']; ?>
        </h2>
        <div class="QuantityText">
            <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b>
            </p>
            <h6> Inclusief BTW </h6>
            <?php print $StockItem['QuantityOnHand']; ?>

        </div>
        <div>
            <i class="fa-solid fa-circle-minus"></i>
            <input type="number" class="">
            <i class="fa-solid fa-circle-plus"></i>
        </div>
        <div id="StockItemHeader">
            <div class="CenterPriceLeft border p-2">
                <h1>Overzicht</h1>
                <h5 class="m-3">Aantal artikelen: <br> <?php //aantal artikelen berekenen?></h5>
                <h5 class="m-3">Totaal prijs: <br> <?php //totaal prijs berekenen?></h5>
                <h5 class="m-3">Verzend kosten: <BR> Altijd gratis!</h5>
                <button class="btn btn-success"> Verder naar bestellen </button>
            </div>
        </div>
    </div>
</div>





<?php
include __DIR__ . "/footer.php";
?>
