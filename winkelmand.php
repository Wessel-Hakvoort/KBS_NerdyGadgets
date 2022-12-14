<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";

//session_destroy();
$cart = getCart();

$StockItem = getStockItem($cart, $databaseConnection);
$StockItemImage = getStockItemImage($cart, $databaseConnection);
?>


<!-- code deel 3 van User story: Zoeken producten : de html -->
<!-- de zoekbalk links op de pagina  -->

<!--<script>-->
<!--    if (window.history.replaceState) {-->
<!--        window.history.replaceState(null, null, window.location.href);-->
<!--    }-->
<!--</script>-->

<?php
if (array_sum($cart) > 0) {
?>

<div id="FilterFrame"><h2 class="FilterText"><i class="fa-solid fa-cart-shopping"></i> Winkelmand </h2>
    <form action="bestellen.php">
        <div id="FilterOptions">
            <h4 class="FilterTopMargin"> Aantal artikelen: <?php print array_sum($cart) //totaal aantal items ?></h4>
            <br>
            <h4 class="FilterTopMargin"></i> Totaal
                prijs: <?php print "€" . totaal_prijs($cart, $databaseConnection);  //totaal prijs berekenen ** sprintf("€ %.2f", $StockItem['SellPrice']); ?>
            </h4>
            <br>
            <h4 class="FilterTopMargin"> Wij rekenen nooit verzendkosten bij een bestelling!</h4>
            <br>
            <button class="buttonNerd"> Verder naar bestellen</button>
    </form>
</div>
</div>

<!-- einde zoekresultaten die links van de zoekbalk staan -->
<!-- einde code deel 3 van User story: Zoeken producten  -->
<div style="margin-left: 21%; width: 78%;">
    <?php
    $i = 0;
    foreach ($cart

             as $key => $value) {
    if ($key == "") {
        continue;
    } else {
        $naam = getStockItem($key, $databaseConnection);
        $i++;
    }
    ?>
    <div id="ResultsAreaWinkelmandje" class="Browse">
        <br>
        <div id="ArticleHeader">
            <?php
            $foto = getStockItemImage($key, $databaseConnection);
            if (isset($foto)) {
                // één plaatje laten zien
                if (count($foto) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $foto[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else { ?>
                    <!-- zorgt voor de back-up  -->
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;">
                    </div>
                    <?php
                }
            }
            ?>
            <!--            $naam['StockItemName']-->
            <div>

                <!-- Print de naam van het item -->
                <h2 class="StockItemNameViewSize StockItemName" style="width: 1500px">
                    <?php
                    $itemID = $naam['StockItemID'];
                    $itemNaam = $naam['StockItemName'];
                    print "<a href='view.php?id=$itemID 'style='color: #0b95a2;'>$itemNaam</a>"; ?>
                </h2>
                <!-- Prijs, hoeveelheid en inclusief btw -->
                <div class="QuantityText">
                    <!-- Print de per stuk prijs -->
                    <p class="StockItemPriceText">
                        <b><?php print sprintf("€ %.2f", $naam['SellPrice']); ?></b>
                    <h6> Inclusief BTW </h6>
                    </p>
                    <!-- Verzorgd hoeveel items er in het winkelmandje zitten -->
                    <div class="input-group inputGroup-sizing-sm mb-3" style="width: 175px">
                        <!-- Form met post method om de hoeveelheid van een item te verlagen -->
                        <form method="post" onSubmit="window.location.reload()">
                            <input type="number" name="Decrease" value="<?php print($naam["StockItemID"]) ?>"
                                   hidden>
                            <button class="btn btn-outline-secondary" type="submit" name="submitDecrease"
                                    id="button-addon1">
                                <i class="fa-solid fa-circle-minus"></i>
                            </button>
                        </form>
                        <!-- Laten zien wat het huidige aantal is -->
                        <input type="text" class="form-control p-0" placeholder=""
                               aria-label="Example text with button addon"
                               aria-describedby="button-addon1"
                               value=" <?php print $cart[$key]; //aantal wat in winkel wagen zit?>">
                        <!-- Form met post method om de hoeveelheid van een item te verhogen -->
                        <form method="post">
                            <input type="number" name="Increase" value="<?php print($naam["StockItemID"]) ?>"
                                   hidden>
                            <button class="btn btn-outline-secondary" type="submit"
                                    name="submitIncrease" id="button-addon2">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                        </form>
                        <!-- Form met post method om de hoeveelheid van een item te verwijderen -->
                        <form method="post" class="pr-2">
                            <input type="number" name="Delete" value="<?php print($naam["StockItemID"]) ?>"
                                   hidden>
                            <button class="btn btn-outline-danger" type="submit"
                                    name="delete2" id="button-addon2">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?php } ?>
        <!-- Verlaagd het aantal in $cart -->
        <?php
        if (isset($_POST["Decrease"])) { // zelfafhandelend formulier
            $stockItemID = $_POST["Decrease"];
            removeProductFromCart($stockItemID); // maak gebruik van geïmporteerde functie uit header.php
            print ' <meta http-equiv="refresh" content="0">';
        }
        ?>
        <!-- Verhoogd het aantal in $cart -->
        <?php
        if (isset($_POST["Increase"])) { // zelfafhandelend formulier
            $stockItemID = $_POST["Increase"];
            addProductToCart($stockItemID); // maak gebruik van geïmporteerde functie uit Header.php
            print ' <meta http-equiv="refresh" content="0">';
        } ?>
        <!-- verwijderd het item uit $cart -->
        <?php
        if (isset($_POST["Delete"])) { // zelfafhandelend formulier
            $stockItemID = $_POST["Delete"]; //
            deleteProductFromCart($stockItemID); // maak gebruik van geïmporteerde functie uit Header.php
            print ' <meta http-equiv="refresh" content="0">';
        } ?>
        <br>
    </div>
    <?php
    } else {
        ?>
        <div class="StockItemName" style="text-align: center">
            <br>
            <br>
            <br>
            <h1>Uw winkelmand is leeg :(</h1>
            <h3>klik <a href="browse.php">hier </a>om producten te zoeken</h3>
            <br>
        </div>
        <?php
    }
?>
    <?php
    include __DIR__ . "/footer.php";
    ?>
