<!-- dit bestand bevat alle code voor het productoverzicht -->
<?php
include __DIR__ . "/header.php";
//include 'accountfuncties.php';
?>


<div style="color: #053d42; text-align: center; box-sizing: border-box;">
    <br>
    <br>
    <h1>Inloggen</h1><br>
    <form method="post">
        <h3><input style="Width: 500px;" type="text" placeholder="Email" name="email" required/><br><br>
            <input style="Width: 500px;" type="password" placeholder="Wachtwoord" name="password" required/><br>
            <br>
            <?php
            // INLOGGEN
            if (isset($_POST['but_login'])) {
                $password = hash('sha256', $_POST['password']);
                $email = $_POST['email'];
                loginUser($databaseConnection, $email, $password);
            }
            ?>
            <button style="width: 200px; font-size: 20px" class="buttonNerd" type="submit" name="but_login"
                    value="Inloggen" formmethod="post">Inloggen
            </button>
            <br>
            <h5>Heeft u nog geen account?<br>
                klik <a href="register.php">hier </a> om een account aan te maken.</h5>
        </h3>
    </form>
</div>
<p style="color: black">admin<br>admin<br><br></br>philipgorgievski@gmail.com<br>12345678</p>

<?php
include __DIR__ . "/footer.php";
?>
