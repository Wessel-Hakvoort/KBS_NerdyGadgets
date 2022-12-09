<?php


//verbinding maken met de database
function maakVerbinding() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $databasename = "nerdygadgets";
    $connection = mysqli_connect($host, $user, $pass, $databasename);
    return $connection;
}



//alle klanten selecteren uit database
function selecteerKlanten($databaseConnection) {
    $sql = "SELECT CustomerID, CustomerName, DeliveryAddressLine2, PostalAddressLine2 FROM customers ORDER BY CustomerName";
    $result = mysqli_fetch_all(mysqli_query($databaseConnection, $sql),MYSQLI_ASSOC);
    return $result;
}


function selecteer1Klant($id, $databaseConnection) {
    $Result = null;
    $Query = "SELECT CustomerID, CustomerName, DeliveryAddressLine2, PostalAddressLine2 FROM customers WHERE CustomerID=?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

//verbinding met database weer sluiten
function sluitVerbinding($connection) {
    mysqli_close($connection);
}

