<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verlanglijstje</title></head>

<?php
include __DIR__ . '/header.php';

$verlanglijstje = getVerlanglijstje();

$StockItem = getStockItem($verlanglijstje, $databaseConnection);
$StockItemImage = getStockItemImage($verlanglijstje, $databaseConnection);

?>

<body>
<?php
//if-statement om te bepalen of de verlanglijst leeg of vol is
if (array_sum($verlanglijstje) > 0) {
    ?>

<h1>Verlanglijstje</h1>












    <?php
} else {
    ?>
    <div class="StockItemName" style="text-align: center">
        <br>
        <br>
        <br>
        <h1>Uw verlanglijstje is leeg :(</h1>
        <h3>klik <a href="browse.php">hier </a>om producten te zoeken</h3>
        <br>
    </div>
    <?php
}

include __DIR__ . "/footer.php";
?>
</body>
</html>
