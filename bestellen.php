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

<div class="flex-container" style="flex-direction: row">
<div style="margin-left: 30px; width: 500px" id="FilterFrame">
    <h2 class="FilterText"><i class="fa-solid fa-cart-shopping">
        </i> Winkelmand </h2>
    <form>
        <div id="FilterOptions">
            <h4>
                <div id="ResultsAreaWinkelmandje" class="Browse">
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
                    print "- " . $naam['StockItemName'];
                    print " [" . $cart[$key];
                    print "x] " ?>
                <br><br>
                <?php } ?></h4>
            <h4>Totaalprijs: <?php print "€" . totaal_prijs($cart, $databaseConnection); ?></h4>
              </div>

    </form>
</div>
</div>
<!-- einde zoekresultaten die links van de zoekbalk staan -->
<!-- einde code deel 3 van User story: Zoeken producten  -->
<div style="margin-left: 21%; width: 78%;">
    <div style="margin-left: 200px; width: 500px">
        <br>
            <div class="StockItemName">
                <h1>Gegevens:</h1><br>
                <form method="post" action="bestelconfirm.php"><h3>
                Naam: <input type="text" name="CustomerName" required/><br>
                Adres: <input type="text" name="DeliveryAddressLine2" required/><br>
                Woonplaats: <input type="text" name="PostalAddressLine2" required/><br>
                        <br><button class="buttonNerd" type="submit" name="toevoegen" value="Toevoegen" formmethod="post">Doorgaan naar betalen</button>
                    </h3>
                </form>
            </div>
    </div>
</div>
    <?php
    include __DIR__ . "/footer.php";
    ?>
