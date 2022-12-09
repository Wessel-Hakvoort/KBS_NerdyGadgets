<?php
//functie haalt de sessie inhoud op
function getCart()
{
    if (isset($_SESSION['cart'])) {               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else {
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

// functie slaat de winkelmand inhoud op in de sessie
function saveCart($cart)
{
    $_SESSION["cart"] = $cart;// werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

// functie voegt 1 per keer van het aantal toe voor het product
function addProductToCart($stockItemID)
{
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += 1;                   //zo ja:  aantal met 1 verhogen
    } else {
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

// functie haalt 1 per keer van het aantal af voor het product
function removeProductFromCart($stockItemID)
{
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        if ($cart[$stockItemID] < 1){
            // zorgt er voor dat aantallen niet in de min kunnen
        }else{
            $cart[$stockItemID] -= 1;                   //zo ja: aantal met 1 verlagen
        }
    } else {
        $cart[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

// functie zorgt er voor dat een item verwijderd wordt uit de sessie
function deleteProductFromCart($stockItemID){
    $cart = getCart();
    print $stockItemID;
    if (array_key_exists($stockItemID, $cart)) {
        unset($cart[$stockItemID]);
    }
    saveCart($cart);
}

// berekend de totaal prijs van het winkelmandje
function totaal_prijs($cart, $databaseConnection)
{
    //init variable $totaal_prijs
    $totaal_prijs = 0;
    foreach ($cart as $key => $value) {
        // Haalt Informatie van item op
        $StockItem = getStockItem($key, $databaseConnection);
        // Veranderd tekst naar float
        $StockItem_int = floatval($StockItem['SellPrice']);
        $totaal_prijs += $cart[$key] * $StockItem_int;
    }

    return sprintf("%.2f", round($totaal_prijs, 2));
}