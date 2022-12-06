<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
include 'klantfuncties.php';
?>


<div style="color: #053d42; text-align: center; box-sizing: border-box;">
    <br>
    <br>
    <h1>Registreren</h1><br>
    <form method="post" action="account.php">
        <h3><input style = "Width: 500px;" type="email" placeholder="Email" name="email" required/><br><br>
            <input style = "Width: 500px;" type="password" placeholder="Wachtwoord" name="password" required/><br><br>
            <input style = "Width: 500px;" type="password" placeholder="Herhaal wachtwoord" name="password" required/><br>
            <br><button style="width: 300px; font-size: 20px" class="buttonNerd" type="submit" name="toevoegen" value="AccountAanmaken" formmethod="post">Account aanmaken</button><br>
        </h3>
    </form>
</div>


<?php
include __DIR__ . "/footer.php";
?>
