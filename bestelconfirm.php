<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";

$cart = getCart();

$StockItem = getStockItem($cart, $databaseConnection);
$StockItemImage = getStockItemImage($cart, $databaseConnection);

?>
<?php
if (array_sum($cart) > 0) {
    ?>

<?php
//VOEGT KLANT TOE AAN DATABASE
if (isset($_POST["toevoegen"])) {
    $CustomerName = $_POST["CustomerName"];
    $gegevens["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $gegevens["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $gegevens["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $gegevens["Mail"] = isset($_POST["Mail"]) ? $_POST["Mail"] : "";
    $gegevens["PhoneNumber"] = isset($_POST["PhoneNumber"]) ? $_POST["PhoneNumber"] : "";
    $gegevens = klantGegevensOrderToevoegen($gegevens);
    voegOrderToe($databaseConnection, totaal_prijs($cart, $databaseConnection));
    voegOrderLineToe($databaseConnection);
    //mail($_POST["Mail"], "Bestelling", "Uw bestelling bij nerdygadgets is geplaatst! Uw bestelnummer is:" . LaatsteOrderNummer($databaseConnection));
}

?>

<div class="StockItemName" style="text-align: center">
    <br>
    <br>
    <br>
    <h1>Dankjewel voor je bestelling</h1>
    <h2>Uw bestelnummer is: <?php LaatsteOrderNummer($databaseConnection)?></h2>
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
    <?php }?>
<?php
include __DIR__ . "/footer.php";
?>