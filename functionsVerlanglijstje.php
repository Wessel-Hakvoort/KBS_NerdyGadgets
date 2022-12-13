<?php

function getVerlanglijstje()
{
    if (isset($_SESSION['verlanglijstje'])) {               //controleren of verlanglijstje al bestaat
        $verlanglijstje = $_SESSION['verlanglijstje'];                  //zo ja:  ophalen
    } else {
        $verlanglijstje = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $verlanglijstje;                               // resulterend verlanglijstje terug naar aanroeper functie
}


function saveVerlanglijstje($verlanglijstje)
{
    $_SESSION["verlanglijstje"] = $verlanglijstje;// werk de "gedeelde" $_SESSION["verlanglijstje"] bij met de meegestuurde gegevens
}


function addProductToVerlanglijstje($stockItemID)
{
    $verlanglijstje = getVerlanglijstje();                          // eerst de huidige verlanglijst ophalen

    if (array_key_exists($stockItemID, $verlanglijstje)) {  //controleren of $stockItemID(=key!) al in array staat
        $verlanglijstje[$stockItemID] += 1;                   //zo ja: aantal met 1 verhogen
    } else {
        $verlanglijstje[$stockItemID] = 1;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveVerlanglijstje($verlanglijstje);                            // werk de "gedeelde" $_SESSION["verlanglijstje"] bij met de bijgewerkte verlanglijst
}

function deleteProductFromVerlanglijstje($stockItemID){
    $verlanglijstje = getVerlanglijstje();
    print $stockItemID;
    if (array_key_exists($stockItemID, $verlanglijstje)) {
        unset($verlanglijstje[$stockItemID]);
    }
    saveCart($verlanglijstje);
}