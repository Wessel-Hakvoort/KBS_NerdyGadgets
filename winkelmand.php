<!-- dit bestand bevat alle code voor het productoverzicht -->
<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<!-- dit bestand bevat alle code die verbinding maakt met de database -->
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
</head>
<body>
<div class="Background">
    <div class="row" id="Header">
        <div class="col-2"><a href="./" id="LogoA">
                <div id="LogoImage"></div>
            </a></div>
        <div class="col-8" id="CategoriesBar">
            <ul id="ul-class">
                                    <li>
                        <a href="browse.php?category_id=1"
                           class="HrefDecoration">Novelty Items</a>
                    </li>
                                        <li>
                        <a href="browse.php?category_id=2"
                           class="HrefDecoration">Clothing</a>
                    </li>
                                        <li>
                        <a href="browse.php?category_id=4"
                           class="HrefDecoration">T-Shirts</a>
                    </li>
                                        <li>
                        <a href="browse.php?category_id=6"
                           class="HrefDecoration">Computing Novelties</a>
                    </li>
                                        <li>
                        <a href="browse.php?category_id=7"
                           class="HrefDecoration">USB Novelties</a>
                    </li>
                                        <li>
                        <a href="browse.php?category_id=9"
                           class="HrefDecoration">Toys</a>
                    </li>
                                    <li>
                    <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                </li>
            </ul>

        </div>
        <!-- code voor US3: zoeken -->
        <ul id="ul-class-navigation">
            <li>
                <a href="winkelmand.php" class="HrefDecoration"><i class="fa-solid fa-cart-shopping"></i> Winkelmand
                </a>
            </li>
            <li>
                <a href="browse.php" class="HrefDecoration"><i class="fas fa-search search"></i> Zoeken </a>
            </li>

        </ul>
        <!-- einde code voor US3 zoeken -->
    </div>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">




<!-- code deel 3 van User story: Zoeken producten : de html -->
<!-- de zoekbalk links op de pagina  -->

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<div id="FilterFrame"><h2 class="FilterText"><i class="fa-solid fa-cart-shopping"></i> Winkelmand </h2>
    <form>
        <div id="FilterOptions">
            <h4 class="FilterTopMargin"> Aantal artikelen: 45</h4>
            <br>
            <h4 class="FilterTopMargin"></i> Totaal
                prijs: €1934.42</h4>
            <br>
            <h4 class="FilterTopMargin"> Wij rekenen nooit verzendkosten bij een bestelling!</h4>
            <br>
            <button class="buttonNerd"> Artikelen afrekenen</button>
            Array
(
    [139] => 1
    [] => 43
    [76] => 1
)
    </form>
</div>
</div>

<!-- einde zoekresultaten die links van de zoekbalk staan -->
<!-- einde code deel 3 van User story: Zoeken producten  -->

<div id="ResultsArea" class="Browse">
    <br>
    <div id="ArticleHeader">
                    <div class="ListItem">
                                        <div id="ImageFrame"
                             style="background-image: url('Public/StockItemIMG/Dinosaur battery powered slippers.png'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                        
                <div>
                    <!-- Print het artikelnummer -->
                    <h1 class="StockItemID">Artikelnummer: 139</h1>
                    <!-- Print de naam van het item -->
                    <h2 class="StockItemNameViewSize StockItemName">
                        Furry animal socks (Pink) M                    </h2>
                    <!-- Prijs, hoeveelheid en inclusief btw -->
                    <div class="QuantityText">
                        <!-- Print de per stuk prijs -->
                        <p class="StockItemPriceText"><b>€ 8.60</b>
                        </p>
                        <!-- Verzorgd hoeveel items er in het winkelmandje zitten -->
                        <div class="input-group inputGroup-sizing-sm mb-3" style="width: 175px">
                            <!-- Form met post method om de hoeveelheid van een item te verlagen -->
                            <form method="post">
                                <input type="number" name="Decrease" value="139"
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
                                   value=" 45">
                            <!-- Form met post method om de hoeveelheid van een item te verhogen -->
                            <form method="post">
                                <input type="number" name="Increase" value="139"
                                       hidden>
                                <button class="btn btn-outline-secondary" type="submit"
                                        name="submitIncrease" id="button-addon2">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                                                            </form>
                            <!-- Form met post method om de hoeveelheid van een item te verwijderen -->
                            <form method="post" class="pr-2">
                                <input type="number" name="Increase" value="139"
                                       hidden>
                                <button class="btn btn-outline-danger" type="submit"
                                        name="delete" id="button-addon2">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                                            </form>
                        </div>
                        <h6> Inclusief BTW </h6>
                        Voorraad: 126418                    </div>
                </div>
            </div>
                    <div class="ListItem">
                                        <!-- zorgt voor de back-up  -->
                        <div id="ImageFrame"
                             style="background-image: url('Public/StockGroupIMG/Chocolate.jpg'); background-size: cover;">
                        </div>
                        
                <div>
                    <!-- Print het artikelnummer -->
                    <h1 class="StockItemID">Artikelnummer: </h1>
                    <!-- Print de naam van het item -->
                    <h2 class="StockItemNameViewSize StockItemName">
                        <br />
<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\xampp\htdocs\nerdygadgets\winkelmand.php</b> on line <b>86</b><br />
                    </h2>
                    <!-- Prijs, hoeveelheid en inclusief btw -->
                    <div class="QuantityText">
                        <!-- Print de per stuk prijs -->
                        <p class="StockItemPriceText"><b><br />
<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\xampp\htdocs\nerdygadgets\winkelmand.php</b> on line <b>91</b><br />
€ 0.00</b>
                        </p>
                        <!-- Verzorgd hoeveel items er in het winkelmandje zitten -->
                        <div class="input-group inputGroup-sizing-sm mb-3" style="width: 175px">
                            <!-- Form met post method om de hoeveelheid van een item te verlagen -->
                            <form method="post">
                                <input type="number" name="Decrease" value="<br />
<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\xampp\htdocs\nerdygadgets\winkelmand.php</b> on line <b>97</b><br />
"
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
                                   value=" 45">
                            <!-- Form met post method om de hoeveelheid van een item te verhogen -->
                            <form method="post">
                                <input type="number" name="Increase" value="<br />
<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\xampp\htdocs\nerdygadgets\winkelmand.php</b> on line <b>117</b><br />
"
                                       hidden>
                                <button class="btn btn-outline-secondary" type="submit"
                                        name="submitIncrease" id="button-addon2">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                                                            </form>
                            <!-- Form met post method om de hoeveelheid van een item te verwijderen -->
                            <form method="post" class="pr-2">
                                <input type="number" name="Increase" value="<br />
<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\xampp\htdocs\nerdygadgets\winkelmand.php</b> on line <b>131</b><br />
"
                                       hidden>
                                <button class="btn btn-outline-danger" type="submit"
                                        name="delete" id="button-addon2">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                                            </form>
                        </div>
                        <h6> Inclusief BTW </h6>
                        <br />
<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\xampp\htdocs\nerdygadgets\winkelmand.php</b> on line <b>145</b><br />
                    </div>
                </div>
            </div>
                    <div class="ListItem">
                                        <div id="ImageFrame"
                             style="background-image: url('Public/StockItemIMG/The gu (white).png'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                        
                <div>
                    <!-- Print het artikelnummer -->
                    <h1 class="StockItemID">Artikelnummer: 76</h1>
                    <!-- Print de naam van het item -->
                    <h2 class="StockItemNameViewSize StockItemName">
                        "The Gu" red shirt XML tag t-shirt (White) 3XS                    </h2>
                    <!-- Prijs, hoeveelheid en inclusief btw -->
                    <div class="QuantityText">
                        <!-- Print de per stuk prijs -->
                        <p class="StockItemPriceText"><b>€ 30.95</b>
                        </p>
                        <!-- Verzorgd hoeveel items er in het winkelmandje zitten -->
                        <div class="input-group inputGroup-sizing-sm mb-3" style="width: 175px">
                            <!-- Form met post method om de hoeveelheid van een item te verlagen -->
                            <form method="post">
                                <input type="number" name="Decrease" value="76"
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
                                   value=" 45">
                            <!-- Form met post method om de hoeveelheid van een item te verhogen -->
                            <form method="post">
                                <input type="number" name="Increase" value="76"
                                       hidden>
                                <button class="btn btn-outline-secondary" type="submit"
                                        name="submitIncrease" id="button-addon2">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                                                            </form>
                            <!-- Form met post method om de hoeveelheid van een item te verwijderen -->
                            <form method="post" class="pr-2">
                                <input type="number" name="Increase" value="76"
                                       hidden>
                                <button class="btn btn-outline-danger" type="submit"
                                        name="delete" id="button-addon2">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                                            </form>
                        </div>
                        <h6> Inclusief BTW </h6>
                        Voorraad: 129929                    </div>
                </div>
            </div>
            </div>

<!-- de inhoud van dit bestand wordt onderaan elke pagina geplaatst -->

</div>
</div>
</div>
</div>
</body>
</html>