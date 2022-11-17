<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
include 'klantfuncties.php';
//include 'orderfuncties.php';

//session_destroy();
$cart = getCart();

$StockItem = getStockItem($cart, $databaseConnection);
$StockItemImage = getStockItemImage($cart, $databaseConnection);

?>
<?php
//VOEGT KLANT TOE AAN DATABASE
if (isset($_POST["toevoegen"])) {
    $CustomerName = $_POST["CustomerName"];
    $gegevens["CustomerName"] = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
    $gegevens["DeliveryAddressLine2"] = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
    $gegevens["PostalAddressLine2"] = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
    $gegevens = klantGegevensToevoegen($gegevens);
}
?>

<div class="StockItemName" style="text-align: center">
    <br>
    <br>
    <br>
    <h1>Dankjewel voor je bestelling: <?php print $_POST["CustomerName"]; ?>
    </h1>
    <br>
</div>
<?php
include __DIR__ . "/footer.php";
?>