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

<?php
$i = 0;
foreach ($verlanglijstje
as $key => $value) {
if ($key == "") {
    continue;
} else {
    $naam = getStockItem($key, $databaseConnection);
    $i++;
}
?>

<h1>Verlanglijstje</h1>
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
