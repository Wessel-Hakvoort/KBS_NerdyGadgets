<?php

function getVerlanglijstje()
{
    if (isset($_SESSION['verlanglijstje'])) {               //controleren of verlanglijstje al bestaat
        $verlanglijstje = $_SESSION['cart'];                  //zo ja:  ophalen
    } else {
        $verlanglijstje = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $verlanglijstje;                               // resulterend verlanglijstje terug naar aanroeper functie
}