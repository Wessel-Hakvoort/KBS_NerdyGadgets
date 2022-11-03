<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";

$cart = getCart();

$StockItem = getStockItem($cart, $databaseConnection);
$StockItemImage = getStockItemImage($cart, $databaseConnection);

function sessiondestroy()
{
    session_destroy();
    print("<script type='text/javascript'>alert('function session destroy');</script>");
}
?>


<!-- code deel 3 van User story: Zoeken producten : de html -->
<!-- de zoekbalk links op de pagina  -->

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<div id="FilterFrame"><h2 class="FilterText"><i class="fa-solid fa-cart-shopping"></i> Winkelmand </h2>
    <form>
        <div id="FilterOptions">
            <h4 class="FilterTopMargin"> Aantal artikelen: <?php print count($cart) //totaal aantal items ?></h4>
            <br>
            <h4 class="FilterTopMargin"></i> Totaal prijs: <?php print isset($StockItem['SellPrice']);  //totaal prijs berekenen ** sprintf("€ %.2f", $StockItem['SellPrice']); ?></h4>
            <br>
            <h4 class="FilterTopMargin"> Wij rekenen nooit verzendkosten bij een bestelling!</h4>
            <br>
            <button class="buttonNerd"> Artikelen afrekenen </button>
            <input type="submit" name="sessiondestroy" value="sessiondestroy" onclick="<?php session_destroy();?>" />
    </form>
</div>
</div>

<!-- einde zoekresultaten die links van de zoekbalk staan -->
<!-- einde code deel 3 van User story: Zoeken producten  -->

<div id="ResultsArea" class="Browse">
    <br>
    <div id="ArticleHeader">
        <br>
        <?php
        print_r($cart);
        //        if (array_values($cart) == array_values($cart) ){
        //            $a = 0;
        //            $a++;
        //            print $a;
        //        }else{
        foreach ($cart as $key => $item) {
            if (key($cart) == $key){
                continue;
            }

            print_r($key);
            print_r($item);
            ?>
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

            <h1 class="StockItemID">Artikelnummer: <?php print key($cart); ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText">
                <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                <div class="input-group inputGroup-sizing-sm mb-3" style="width: 150px">
                    <!-- Form met post method om de hoeveelheid van een item te verlagen -->
                    <form method="post">
                        <input type="number" name="Decrease" value="<?php print($StockItem["StockItemID"]) ?>" hidden>
                        <button class="btn btn-outline-secondary" type="submit" name="submitDecrease"
                                id="button-addon1">
                            <i class="fa-solid fa-circle-minus"></i>
                        </button>
                        <?php
                        if (isset($_POST["submitDecrease"])) { // zelfafhandelend formulier
                            $stockItemID = $_POST["submitDecrease"];
                            removeProductFromCart($stockItemID); // maak gebruik van geïmporteerde functie uit header.php
                        }
                        ?>
                    </form>
                    <!-- Laten zien wat het huidige aantal is -->
                    <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon"
                           aria-describedby="button-addon1" value=" <?php print $item; //aantal wat in winkel wagen zit?>">

                    <!-- Form met post method om de hoeveelheid van een item te verhogen -->
                    <form method="post">
                        <input type="number" name="Increase" value="<?php print($StockItem["StockItemID"]) ?>" hidden>
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                    class="fa-solid fa-circle-plus"></i></button>
                    </form>
                    <?php
                    if (isset($_POST["submitIncrease"])) {              // zelfafhandelend formulier
                        $stockItemID = $_POST["submitIncrease"];
                        addProductToCart($stockItemID); // maak gebruik van geïmporteerde functie uit cartfuncties.php
                    } ?>
                </div>


                <h6> Inclusief BTW </h6>
                <?php print $StockItem['QuantityOnHand']; ?>
            </div>
        <?php } ?>
    </div>
    <div id="winkelmand">

    </div>

    <?php
    include __DIR__ . "/footer.php";
    ?>
