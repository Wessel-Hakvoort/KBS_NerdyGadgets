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
            <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
            <div class="input-group inputGroup-sizing-sm mb-3" style="width: 150px">
                <button class="btn btn-outline-secondary" type="button" id="button-addon1"><i class="fa-solid fa-circle-minus" onclick="<?php $aantal = 1; $aantal--?>"></i></button>
                <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value=" 1<?php $aantal; //aantal wat in winkel wagen zit ?>">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa-solid fa-circle-plus" onclick="<?php $aantal++ ?>"></i></button>
            </div>


            <h6> Inclusief BTW </h6>
            <?php print $StockItem['QuantityOnHand']; ?>
        </div>
        <div id="WinkelmandOverzicht2">
            <div class="CenterPriceLeft border p-2">
                <h1 class="StockItemName">Overzicht</h1>
				<br>
                <h5 class="StockItemComments">Aantal artikelen: <br> "aantal"<?php //aantal artikelen berekenen?></h5>
                <h5 class="StockItemComments">Totaal prijs: <br> "prijs"<?php //totaal prijs berekenen?></h5>
                <h5 class="StockItemComments">Verzend kosten: <BR> Altijd gratis!</h5>
				<br>
				<br>
				<br>
                <button class="buttonNerd"> Verder naar bestellen </button>
            </div>
        </div>
    </div>
</div>





<?php
include __DIR__ . "/footer.php";
?>
