<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
include "klantfuncties.php";

$databaseConnection = connectToDatabase();

include __DIR__ . "/functionsWinkelmand.php";

include __DIR__ . "/FunctionsBrowse.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>
    <script src="https://kit.fontawesome.com/58692e44a1.js" crossorigin="anonymous"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">

    <!--    Zorgt voor refresh van pagina-->
    <!--    <meta http-equiv="refresh" content="0">-->
</head>
<body>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"><a href="./" id="LogoA">
                <div id="LogoImage"></div>
            </a></div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                <?php
                $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                foreach ($HeaderStockGroups as $HeaderStockGroup) {
                    ?>
                    <li>
                        <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                           class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>

        </div>
        <!-- code voor US3: zoeken -->
        <ul id="ul-class-navigation">
            <li>
                <?php
                if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == TRUE )) {
                    ?>
                    <b><a style="padding-left:25px;" href="clear.php" class="HrefDecoration">Uitloggen</a>
                    <a style="padding-left:20px;" href="account.php" class="HrefDecoration">Mijn account</a></b>
                <?php } else { ?>
                    <b><a style="padding-left:25px;" href="login.php" class="HrefDecoration">Inloggen</a></b>
                <?php } ?>
            </li>
            <li>
                <a style="padding-left:25px; font-size:25px;" href="winkelmand.php" class="HrefDecoration"><i
                            class="fa-solid fa-cart-shopping"></i></a>
            </li>
            <li>
                <a style="padding-left:25px; padding-right:25px; font-size:25px;" href="browse.php"
                   class="HrefDecoration"><i class="fas fa-search search"></i></a>
            </li>

        </ul>
        <!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


