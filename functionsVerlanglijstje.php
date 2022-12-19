<?php

function databaseVerlanglijstje($connection, $stockItemID)
{
    if ($_SESSION["loggedin"] == TRUE) {
        $userid = $_SESSION["id"];
        //zoekt klant gegevens op basis van userid session
        $result = mysqli_query($connection, "SELECT CustomerID FROM customers WHERE CustomerID = (SELECT CustomerID FROM users WHERE userid = $userid);");
        while ($row = mysqli_fetch_array($result)) {
            $CustomerID = $row['CustomerID'];
            $statement = mysqli_prepare($connection, "INSERT INTO verlanglijstje (CustomerID, StockItemID) VALUES('$CustomerID', '$stockItemID')");
            mysqli_stmt_execute($statement);
            return mysqli_stmt_affected_rows($statement) == 1;
        }
    }
}


function deleteFromVerlanglijstje($connection, $stockItemID)
{
    if ($_SESSION["loggedin"] == TRUE) {
        $userid = $_SESSION["id"];
        //zoekt klant gegevens op basis van userid session
        $result = mysqli_query($connection, "SELECT CustomerID FROM customers WHERE CustomerID = (SELECT CustomerID FROM users WHERE userid = $userid);");
        while ($row = mysqli_fetch_array($result)) {
            $CustomerID = $row['CustomerID'];
            $statement = mysqli_prepare($connection, "DELETE FROM verlanglijstje WHERE CustomerID = '$CustomerID' AND StockItemID = '$stockItemID'");
            mysqli_stmt_execute($statement);
            return mysqli_stmt_affected_rows($statement) == 1;
        }
    }
}

//credits naar Tiemco die de array werkend heeft gemaakt
function selectVerlanglijst($connection) {
    if ($_SESSION["loggedin"] == TRUE) {
        $userid = $_SESSION["id"];

        $customerQuery = mysqli_query($connection, "SELECT CustomerID FROM customers WHERE CustomerID = (SELECT CustomerID FROM users WHERE userid = '$userid' AND CustomerID IS NOT NULL);");
        $customer = mysqli_fetch_array($customerQuery);
        $customerID = $customer["CustomerID"];

        $verlanglijstje = $connection->query("SELECT StockItemID FROM verlanglijstje WHERE CustomerID='$customerID'");
        $result = $verlanglijstje->fetch_all();

       return $result;
    }
}