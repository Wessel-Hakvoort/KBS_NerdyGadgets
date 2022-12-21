<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
//include 'accountfuncties.php';
if (empty($_SESSION["loggedin"])) {
    echo "<script>window.location = 'login.php';</script>";
}
if ($_SESSION["mail"] == "admin") {
    echo "<script>window.location = 'admin.php';</script>";
}
if ($_SESSION["loggedin"] == TRUE) {
    ?>
    <div id="FilterFrame" style="width: 350px">
    <div id="ResultsAreaWinkelmandje" class="Browse">
    <br>
    <?php
    if ($_SESSION["mail"] != "admin") {
        ?>
        <a style="padding-left:10px; font-size:25px;" href="account.php" class="HrefDecoration"><i
                    class="fa-regular fa-user"></i> Mijn account</a>
        <hr>
        <a style="padding-left:10px; font-size:25px;" href="accountbestellingen.php" class="HrefDecoration"><i <i
                    class="fa-regular fa-clipboard"></i></i> Bestellingen</a>
        <hr>
        <a style="padding-left:10px; font-size:25px;" href="accountverlanglijstje.php" class="HrefDecoration"><i
                    class="fa-regular fa-heart"></i> Verlanglijstje</a>
        <hr>
        <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration"><i class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>
        <?php }
        if ($_SESSION["mail"] == "admin") {
            ?>
            <a style="color: white; padding-left:10px; font-size:25px;" href="adminoverzicht.php"
               class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Home</a><hr>
            <a style="color: white; padding-left:10px; font-size:25px;" href="adminorders.php"
               class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Orders</a><hr>
            <a style="color: white; padding-left:10px; font-size:25px;" href="adminklanten.php"
               class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Klanten</a><hr>
            <a style="color: white; padding-left:10px; font-size:25px;" href="adminaccounts.php"
               class="HrefDecoration"><i
                        class="fa-regular fa-star"></i> Accounts</a><hr>
            <a style="padding-left:10px; font-size:25px;" href="clear.php" class="HrefDecoration"><i class="fa-solid fa-arrow-right-from-bracket"></i> Uitloggen</a>
        <?php }
        ?>
        </div>
        </div>
        <div style="color: #053d42; margin-left: 19%; width: 81%;">
            <h3 style="font-size:40px">Mijn account</h3>
            <hr>
            <?php
            ?>
            <h4>Klantnummer:
                <?php gegevensOphalenUser($databaseConnection, "CustomerID");
                print "-" . $_SESSION["id"]
                ?>
            </h4>
            <hr>
            <h4>Naam: <?php gegevensOphalenUser($databaseConnection, "CustomerName"); ?></h4>
            <hr>
            <h4>Mail: <?php gegevensOphalenUser($databaseConnection, "Mail"); ?></h4>
            <hr>
            <h4>Telefoonnummer: <?php gegevensOphalenUser($databaseConnection, "PhoneNumber"); ?></h4>
            <hr>
            <h4>Straatnaam + Huisnummer: <?php gegevensOphalenUser($databaseConnection, "Straatnaam"); ?></h4>
            <hr>
            <h4>Woonplaats: <?php gegevensOphalenUser($databaseConnection, "Woonplaats"); ?></h4>
            <hr>
            <button class="button-6" role="button" type='submit' name="submit" value="submit" formmethod="post"
            >Account verwijderen
            </button>
        </div>
        <?php
    } else {
        print "JE BENT NIET INGELOGD!";
    }
    include __DIR__ . "/footer.php";
    ?>