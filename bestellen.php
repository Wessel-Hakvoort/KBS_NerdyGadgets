<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";

//session_destroy();
$cart = getCart();

$StockItem = getStockItem($cart, $databaseConnection);
$StockItemImage = getStockItemImage($cart, $databaseConnection);

?>

<?php
if (array_sum($cart) > 0) {
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
        </i> Jouw bestelling </h2>
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
            <div style="color: #053d42;">
                <form method="post" action="bestelconfirm.php"><h3>
                        Naam: <input type="text" name="CustomerName" required/><br>
                        Mail: <input type="email" name="Mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/><br>
                        Telefoonnummer: <input type="tel" name="PhoneNumber" pattern="[0-9]{10}" required/><br>
                        Adres + Huisnummer: <input type="text" name="DeliveryAddressLine2" required/><br>
                        Woonplaats: <input type="text" name="PostalAddressLine2" required/><br>
                        <label for="PaymentMethod">Selecteer een betaalmethode</label>
                        <select name="PaymentMethod" id="PaymentMethod" required>
                            <option value="iDeal">iDeal</option>
                            <option value="Afterpay">Afterpay</option>
                            <option value="Paypal">Paypal</option>
                        </select>
                        <br>
                        <br><button class="buttonNerd" type="submit" name="toevoegen" value="Toevoegen" formmethod="post">Doorgaan naar betalen</button>
                    </h3>
                </form>
            </div>
    </div>
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
<?php }?>
    <?php
    include __DIR__ . "/footer.php";
    ?>
