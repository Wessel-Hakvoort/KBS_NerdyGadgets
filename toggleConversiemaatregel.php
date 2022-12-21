<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Conversiemaatregelen</title></head>

<?php
include __DIR__ . "/header.php";
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


<body>

<div  style="color: #053d42; margin-left: 19%; width: 81%;"><h1>Conversiemaatregelen</h1></div>


<!--Verlanglijstje-->
<div style="color: #053d42; margin-left: 19%; width: 81%;">
    <div>
        <?php
        if (isset($_POST["submitVerlanglijstje"])) {              // zelfafhandelend formulier
            $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'VERLANGLIJSTJE'");
            if (mysqli_num_rows($result) > 0) {
                mysqli_query($databaseConnection, "DELETE FROM conversiemaatregelen WHERE conversiemaatregel = 'VERLANGLIJSTJE'");
            } else {
                mysqli_query($databaseConnection, "INSERT INTO conversiemaatregelen VALUES ('VERLANGLIJSTJE', 1)");
            }
            print ' <meta http-equiv="refresh" content="0">';
        }
        ?>
        <form method='post'>
            <input name='Verlanglijstje' hidden>
            <button class="button-37" type="submit" name="submitVerlanglijstje" value="Verlanglijstje">
                Verlanglijstje
            </button>
        </form>

        <?php
        $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'VERLANGLIJSTJE'");
        if (mysqli_num_rows($result) <= 0) {
            $statusVerlanglijstje = FALSE;
        } else {
            $statusVerlanglijstje = TRUE;
        }

        if ($statusVerlanglijstje == TRUE) {
            print("<h5 style='color: black'>De conversiemaatregel voor kunnen maken van een VERLANGLIJSTJE staat AAN</h5>");
        } else {
            print("<h5 style='color: black'>De conversiemaatregel voor kunnen maken van een VERLANGLIJSTJE staat UIT</h5>");
        }
        ?>
        <br>
    </div>


    <!--    Temperatuur-->
    <div>
        <?php
        if (isset($_POST["submitTemperatuur"])) {              // zelfafhandelend formulier
            $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'TEMPERATUUR'");
            if (mysqli_num_rows($result) > 0) {
                mysqli_query($databaseConnection, "DELETE FROM conversiemaatregelen WHERE conversiemaatregel = 'TEMPERATUUR'");
            } else {
                mysqli_query($databaseConnection, "INSERT INTO conversiemaatregelen VALUES ('TEMPERATUUR', 1)");
            }
            print ' <meta http-equiv="refresh" content="0">';
        }
        ?>
        <form method='post'>
            <input name='Temperatuur' hidden>
            <button class="button-37" type="submit" name="submitTemperatuur" value="Temperatuur">
                Temperatuur aangeven bij gekoelde items
            </button>
        </form>

        <?php
        $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'TEMPERATUUR'");
        if (mysqli_num_rows($result) <= 0) {
            $statusTemperatuur = FALSE;
        } else {
            $statusTemperatuur = TRUE;
        }

        if ($statusTemperatuur == TRUE) {
            print("<h5 style='color: black'>De conversiemaatregel voor het aangeven van TEMPERATUUR bij gekoelde items staat AAN</h5>");
        } else {
            print("<h5 style='color: black'>De conversiemaatregel voor het aangeven van TEMPERATUUR bij gekoelde items staat UIT</h5>");
        }
        ?>

        <br>
    </div>


    <!--    Aanbevolen-->
    <div>
        <?php
        if (isset($_POST["submitAanbevolen"])) {              // zelfafhandelend formulier
            $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'AANBEVOLEN'");
            if (mysqli_num_rows($result) > 0) {
                mysqli_query($databaseConnection, "DELETE FROM conversiemaatregelen WHERE conversiemaatregel = 'AANBEVOLEN'");
            } else {
                mysqli_query($databaseConnection, "INSERT INTO conversiemaatregelen VALUES ('AANBEVOLEN', 1)");
            }
            print ' <meta http-equiv="refresh" content="0">';
        }
        ?>
        <form method='post'>
            <input name='Aanbevolen' hidden>
            <button class="button-37" type="submit" name="submitAanbevolen" value="Aanbevolen">
                Andere items aanbevelen op productpagina
            </button>
        </form>

        <?php
        $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'AANBEVOLEN'");
        if (mysqli_num_rows($result) <= 0) {
            $statusAanbevolen = FALSE;
        } else {
            $statusAanbevolen = TRUE;
        }

        if ($statusAanbevolen == TRUE) {
            print("<h5 style='color: black'>De conversiemaatregel voor het AANBEVELEN van andere producten op een productpagina staat AAN</h5>");
        } else {
            print("<h5 style='color: black'>De conversiemaatregel voor het AANBEVELEN van andere producten op een productpagina staat UIT</h5>");
        }
        ?>

        <br>
    </div>


    <!--Korting-->
    <div>
        <?php
        if (isset($_POST["submitKorting"])) {              // zelfafhandelend formulier
            $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'KORTING'");
            if (mysqli_num_rows($result) > 0) {
                mysqli_query($databaseConnection, "DELETE FROM conversiemaatregelen WHERE conversiemaatregel = 'KORTING'");
            } else {
                mysqli_query($databaseConnection, "INSERT INTO conversiemaatregelen VALUES ('KORTING', 1)");
            }
            print ' <meta http-equiv="refresh" content="0">';
        }
        ?>
        <form method='post'>
            <input name='Korting' hidden>
            <button class="button-37" type="submit" name="submitKorting" value="Korting">
                Kortingscodes
            </button>
        </form>

        <?php
        $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'KORTING'");
        if (mysqli_num_rows($result) <= 0) {
            $statusKorting = FALSE;
        } else {
            $statusKorting = TRUE;
        }

        if ($statusKorting == TRUE) {
            print("<h5 style='color: black'>De conversiemaatregel voor het kunnen toepassen van KORTINGSCODES staat AAN</h5>");
        } else {
            print("<h5 style='color: black'>De conversiemaatregel voor het kunnen toepassen van KORTINGSCODES staat UIT</h5>");
        }
        ?>

        <br>
    </div>


    <!--Voorraad-->
    <div>
        <?php
        if (isset($_POST["submitVoorraad"])) {              // zelfafhandelend formulier
            $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'VOORRAAD'");
            if (mysqli_num_rows($result) > 0) {
                mysqli_query($databaseConnection, "DELETE FROM conversiemaatregelen WHERE conversiemaatregel = 'VOORRAAD'");
            } else {
                mysqli_query($databaseConnection, "INSERT INTO conversiemaatregelen VALUES ('VOORRAAD', 1)");
            }
            print ' <meta http-equiv="refresh" content="0">';
        }
        ?>
        <form method='post'>
            <input name='Voorraad' hidden>
            <button class="button-37" type="submit" name="submitVoorraad" value="Voorraad">
                Rode tekst bij een lage voorraad
            </button>
        </form>

        <?php
        $result = mysqli_query($databaseConnection, "SELECT status FROM conversiemaatregelen WHERE conversiemaatregel = 'VOORRAAD'");
        if (mysqli_num_rows($result) <= 0) {
            $statusVoorraad = FALSE;
        } else {
            $statusVoorraad = TRUE;
        }

        if ($statusVoorraad == TRUE) {
            print("<h5 style='color: black'>De conversiemaatregel voor het anders weergeven bij lage VOORRAAD staat AAN</h5>");
        } else {
            print("<h5 style='color: black'>De conversiemaatregel voor het anders weergeven bij lage VOORRAAD staat UIT</h5>");
        }
        ?>

        <br>
    </div>

<?php
} else {
    print "JE BENT NIET INGELOGD!";
}
include __DIR__ . "/footer.php";
?>