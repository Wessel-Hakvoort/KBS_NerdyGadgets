<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
//include 'accountfuncties.php';
if (empty($_SESSION["loggedin"])) {
    echo "<script>window.location = 'login.php';</script>";
}
if ($_SESSION["mail"] != "admin") {
    echo "<script>window.location = 'account.php';</script>";
}
if ($_SESSION["loggedin"] == TRUE) {
    ?>
    <div id="FilterFrame" style="width: 350px">
        <div id="ResultsAreaWinkelmandje" class="Browse">
            <br>
            <?php
            if ($_SESSION["mail"] == "admin") {
                ?>
                <a style="color: white; padding-left:10px; font-size:25px;" href="admin.php"
                   class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Home</a>
                <hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminorders.php"
                   class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Orders</a>
                <hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="adminklanten.php"
                   class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Klanten</a>
                <hr>
                <a style="color: white; padding-left:10px; font-size:25px;" href="toggleConversiemaatregel.php"
                   class="HrefDecoration"><i
                            class="fa-regular fa-star"></i> Conversiemaatregelen</a>
                <hr>
                <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>
            <?php }
            ?>
        </div>
    </div>
    <div style="color: #053d42; margin-left: 19%; width: 81%;">
        <h3 style="font-size:40px">Administrator paneel</h3>
        <br>
        <?php
        ?>
        <h4>Wij hebben nu al
            <b><?php gegevensOphalenAdmin($databaseConnection, "CustomerID"); ?></b> klanten, waarvan er<b> <?php gegevensOphalenAdmin($databaseConnection, "userid"); ?></b>
            geregistreerd zijn!<br>In totaal hebben zij al <b><?php gegevensOphalenAdmin($databaseConnection, "OrderID"); ?></b> bestellingen geplaatst uit een assortiment van
            maar liefst <b><?php gegevensOphalenAdmin($databaseConnection, "StockItemID"); ?></b> producten!
        </h4>
        <hr>
    </div>
    <?php
} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>