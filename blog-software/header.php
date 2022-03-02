<?php
    session_start();
    // echo $_SESSION['user']['loggedIn'];
    
    // echo "executed standard".date("h:i:sa");
    // echo $_SESSION['user']['loggedIn'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <title>Document</title>
</head>

<header class="global-header">
    <nav>
        <ul class="header-ul">
            <?php

    
                    if (isset($_SESSION['user'])) {
                        if ($_SESSION['user']['admin'] == 1) {
                            echo "<li class='header-li'><a href='dashboard.php'>Dashboard</a></li>";
                        }
                        echo "<li class='header-li'><a href='logout.php'>Logout</a></li>";
                    } else {
                        echo "<li class='header-li'><a href='registration.php'>Register</a></li>";
                        echo "<li class='header-li'><a href='login.php'>Login</a></li>";

                    }
            ?>
        <ul>
    </nav>
</header>
