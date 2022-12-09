<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
if (isset($_SESSION["loggedin"])) {
    echo "<script>window.location = 'account.php';</script>";
}
//include 'accountfuncties.php';
?>
<div style="color: #053d42; text-align: center; box-sizing: border-box;">
    <br>
    <br>
    <h1>Gegevens invullen</h1><br>
    <form method="post"
    ">
    <h3><input style="Width: 500px;" type="text" placeholder="Naam" name="CustomerName" required/><br><br>
        <input style="Width: 500px;" type="tel" placeholder="Telefoonnummer" name="PhoneNumber" pattern="[0-9]{10}" required/><br><br>
        <input style="Width: 500px;" type="text" placeholder="Straatnaam + Huisnummer" name="DeliveryAddressLine2" required/><br><br>
        <input style="Width: 500px;" type="text" placeholder="Woonplaats" name="PostalAddressLine2" required/><br><br>
        <?php
        //gegevens ophalen uit form en functie aanroepen
        if (isset($_POST["but-register2"])) {
            $CustomerName = isset($_POST["CustomerName"]) ? $_POST["CustomerName"] : "";
            $DeliveryAddressLine2 = isset($_POST["DeliveryAddressLine2"]) ? $_POST["DeliveryAddressLine2"] : "";
            $PostalAddressLine2 = isset($_POST["PostalAddressLine2"]) ? $_POST["PostalAddressLine2"] : "";
            $PhoneNumber = isset($_POST["PhoneNumber"]) ? $_POST["PhoneNumber"] : "";
            gegevensUser($databaseConnection, $CustomerName, $DeliveryAddressLine2, $PostalAddressLine2, $PhoneNumber);
        }
        ?>
        <br>
        <button style="width: 300px; font-size: 20px" class="buttonNerd" type="submit" name="but-register2"
                value="AccountAanmaken2" formmethod="post">Gegevens opslaan
        </button>
        <br>
    </h3>
    </form>
</div>


<?php
include __DIR__ . "/footer.php";
?>