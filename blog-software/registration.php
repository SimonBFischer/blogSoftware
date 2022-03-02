<?php
    include 'database/dbh.php';
    include 'header.php';
?>

<?php

if(isset($_POST['emailInput']) && isset($_POST['pwdInput'])) {
    
    //CHECK FOR INPUT ERRORS
    $inputError = false;
    $emailInputError = "";
    $pwdInputError = "";

    //error email already taken
    $sql = "SELECT * FROM users WHERE email='".$_POST['emailInput']."';";
    $result = mysqli_query($conn, $sql);
    $numberOfResults = mysqli_num_rows($result);

    if ($numberOfResults > 0) {
        $emailInputError = $emailInputError."Email is alreay taken. ";
        $inputError = true;
    }

    //error email is not a valid email
    if (filter_var($_POST['emailInput'], FILTER_VALIDATE_EMAIL) == false) {
        $emailInputError = $emailInputError."The e-mail adress must follow the format john@example.com. ";
        $inputError = true;
    }

    //error password is not a valid password (?=.*[A-Z])(?=.*\d)[~*#!?@&]{8,128} (?=.*[a-z])(?=.*[A-Z])(?=.*\d)[~*#!?@&]{8-128}$/', 
    if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z~*#!?@&]{8,128}$/', $_POST['pwdInput']) == false) {
        $pwdInputError = $pwdInputError."The password has to be 8-128 characters long and must contain at least one small and one capital letter, one number and one of the followeing signs: ~*#!?@& .";
        $inputError = true;
    }

    //DO REGISTRATION
    if ($inputError == false){
            $sql = "INSERT INTO users (email, pwd, admin) VALUES ('".$_POST['emailInput']."','".$_POST['pwdInput']."', '0');";
            mysqli_query($conn, $sql);

            header ('Location: login.php');

            //header('Location: login.php'); //to make sure everything gets refreshed correctly and noyone can create the same email adress again
    }
}

?>

<body>
<div class="registration-div">
    <form method="POST">
        <p>Enter your e-mail-adress and password.</p>
        <input type="text" name="emailInput" placeholder="E-Mail-Adress"><br>
        <?php
            if (isset($emailInputError)) {
                echo "<div class = input-error-div><p class='input-error'>".$emailInputError."</p></div>";
            }
        ?>
        <br>
        <input type="password" name="pwdInput" placeholder="Password"><br>
        <?php
            if (isset($pwdInputError)) {
                echo "<div class = input-error-div><p class='input-error'>".$pwdInputError."</p></div>";
            }
        ?><br>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>