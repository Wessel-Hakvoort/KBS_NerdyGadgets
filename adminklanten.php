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

if (isset($_POST["DeleteCustomerID"])) { // zelfafhandelend formulier
    unset($_SESSION['CustomerID']);
}


if (isset($_POST["CustomerID"])) { // zelfafhandelend formulier
    $id = $_POST["CustomerID"];
    saveCustomerID($id); //Zet de id van de customer in een sessie
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
        <h3 style="font-size:40px">Klanten</h3>
        <hr>
        <h4><a href="toevoegenklant.php">Nieuwe klant toevoegen</a></h4>
        <hr>
        <form method="post">
            <input style="Width: 500px;" type="text" placeholder="Zoek een klantnummer" name="customerid" required/>
            <button type="submit" value="Submit" name="klantzoeken" class="button-37">Zoeken</button>
            <br>
        </form>
            <?php
            if (isset($_POST["klantzoeken"])) {
                print "<br><hr><h3>Klantnummer: " . $_POST["customerid"] . "</h3>";
                print "<br><h5>Naam: ";
                gegevensOphalenCustomerID($databaseConnection, $_POST["customerid"], "CustomerName");
                print "<br>Mail: ";
                gegevensOphalenCustomerID($databaseConnection, $_POST["customerid"], "Mail");
                print "<br>Telefoonnummer: ";
                gegevensOphalenCustomerID($databaseConnection, $_POST["customerid"], "PhoneNumber");
                print "<br>Straat + Huisnummer: ";
                gegevensOphalenCustomerID($databaseConnection, $_POST["customerid"], "DeliveryAddressLine2");
                print "<br>Woonplaats: ";
                gegevensOphalenCustomerID($databaseConnection, $_POST["customerid"], "PostalAddressLine2");
                ?><br><br><form method='post' action="adminklantenbeheren.php">
                    <input type='number' name='CustomerID' value="<?php print ($_POST["customerid"]) ?>" hidden>
                    <button class='button-37' type='submit' name="buttonCustomerID">
                    Selecteer
                    </button>
                </form><?php
                print "</h5><br><hr>";
            }
            ?>
            <br>
        <br>
        <form method="POST">
            <button type="submit" id="btnDelete" name="btnZero" class="button-37">0</button>
            <button type="submit" id="btnDelete" name="btnDelete" class="button-37"><</button>
            <button type="submit" id="btnSubmit" name="btnSubmit" class="button-37">></button>
        </form>
        <?php
        if (isset($_POST["btnSubmit"])) {
            if (isset($_SESSION["start"])) {
                $start = $_SESSION["start"] + 25;
                $_SESSION["start"] = $start;
            } else {
                $_SESSION["start"] = 25;
            }
        } elseif (isset($_POST["btnDelete"])) {
            if (isset($_SESSION["start"])) {
                $start = $_SESSION["start"] - 25;
                $_SESSION["start"] = $start;
            } else {
                $_SESSION["start"] = 0;
            }
        } else {
            $_SESSION["start"] = 0;
        }
        if ((isset($_POST["btnZero"])) || (empty($_SESSION["start"])) || ($_SESSION["start"] < 0)) {
            $_SESSION["start"] = 0;
        }
        ?>
        <?php
        ?>
        <br>
        <table>
            <thead>
            <tr style='color: #1b1e21; margin-top: -50px'>
                <th style="border-bottom:1pt solid black;">Klantnummer:</th>
                <th style="border-bottom:1pt solid black;">Naam:</th>
                <th style="border-bottom:1pt solid black;">Straat en huisnummer:</th>
                <th style="border-bottom:1pt solid black;">Woonplaats:</th>
                <th style="border-bottom:1pt solid black;">E-mail</th>
                <th style="border-bottom:1pt solid black;">Telefoonnummer</th>
                <th style="border-bottom:1pt solid black;"></th>
                <th style="border-bottom:1pt solid black;"><?php print $_SESSION["start"] . " - " . $_SESSION["start"] + 25; ?></th>
            </tr>
            </thead>
    </div>
    <?php
    $klanten = alleKlantenOpvragen($_SESSION["start"]);
    foreach ($klanten as $klant) { ?>
        <tr>
            <?php
            print("<td style='color: #1b1e21'>" . $klant["CustomerID"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["CustomerName"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["DeliveryAddressLine2"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["PostalAddressLine2"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["mail"] . "</td>");
            print("<td style='color: #1b1e21'>" . $klant["PhoneNumber"] . "</td>");
            ?>
            <td>
                <form method='post' action="adminklantenbeheren.php">
                    <input type='number' name='CustomerID' value="<?php print ($klant["CustomerID"]) ?>" hidden>
                    <button class='button-37' type='submit' name="buttonCustomerID">
                        Selecteer
                    </button>
                </form>
            </td>
        </tr>
        <?php
    } ?>
    </table>
    </div>
    <?php
} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>