<?php
    include 'database/dbh.php';
    include 'header.php';
?>

<?php
if(isset($_POST['emailInput']) && isset($_POST['pwdInput'])) {

    $loginInputError = "";
    //get row(s) where email is in
    $sql = "SELECT * FROM users WHERE email='".$_POST['emailInput']."';";
    $result=mysqli_query($conn, $sql);

    //check for data
    $numberOfResults = mysqli_num_rows($result);
    if ($numberOfResults > 0){
        $userRow = mysqli_fetch_assoc($result);

        //get id, email and pwd
        $userId = $userRow['id'];
        $userEmail = $userRow['email'];
        $userPwd = $userRow['pwd'];
        $userAdmin = $userRow['admin'];

        //compare passwords
        if ($userPwd == $_POST['pwdInput']) {
            //update user session
            $_SESSION['user'] = array('id' => $userId, 'email' => $userEmail, 'pwd' => $userPwd, 'admin' => $userAdmin);
            header('Location: index.php');
        } else {
            $loginInputError = 'Incorrect e-mail adress or password.';
        }

    } else {
        $loginInputError = 'Incorrect e-mail adress or password.';
    }
}

?>

<body>
<div class="login-div">
    <form method="POST">
        <p>Enter your e-mail-adress and password.</p>
        <input type="text" name="emailInput" placeholder="E-Mail-Adress"><br>        <br>
        <input type="password" name="pwdInput" placeholder="Password"><br>
        <?php
            if (isset($loginInputError)) {
                    echo "<div class = input-error-div><p class='input-error'>".$loginInputError."</p></div>";
                }
        ?>
        <br>
        <button type="submit">Login</button>
    </form>
</div>


</body>
</html>