<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
if (isset($_SESSION["loggedin"])) {
    echo "<script>window.location = 'account.php';</script>";
}
?>
<div style="color: #053d42; text-align: center; box-sizing: border-box;">
    <br>
    <br>
    <h1>Registreren</h1><br>
    <form method="post"
    ">
    <h3><input style="Width: 500px;" type="email" placeholder="Email" name="email"
               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/><br><br>
        <input style="Width: 500px;" type="password" placeholder="Wachtwoord" name="password_1" pattern=".{8,}"
               title="Uw wachtwoord moet minstents 8 tekens hebben" required/><br><br>
        <input style="Width: 500px;" type="password" placeholder="Herhaal wachtwoord" name="password_2" pattern=".{8,}"
               title="Uw wachtwoord moet minstents 8 tekens hebben" required/><br>
        <?php
        //gegevens ophalen uit form en functie aanroepen
        if (isset($_POST['but-register'])) {
            $email = $_POST['email'];
            $password_1 = hash('sha256', $_POST['password_1']);
            $password_2 = hash('sha256', $_POST['password_2']);
            registerUser($databaseConnection, $email, $password_1, $password_2);
        }
        ?>
        <br>
        <button style="width: 300px; font-size: 20px" class="buttonNerd" type="submit" name="but-register"
                value="AccountAanmaken" formmethod="post">Doorgaan
        </button>
        <br>
    </h3>
    </form>
</div>


<?php
include __DIR__ . "/footer.php";
?>