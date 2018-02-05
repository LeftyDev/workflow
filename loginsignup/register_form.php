<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
session_start();

if (!(isset($_SESSION["user_id"]))) {
    ?>

    <div id="container">
        <div id="content">
            <div id="content-left">
                <img class="fold" src="img/fold.png">
                <img class="logo" src="img/icons/logo.png">
                <span><span class="logo-1">Work</span><span class="logo-2">flow</span></span>
            </div>
            <div id="content-right">
                <span><span class="header-1">Register an Account</span></span>
                <form id="login_form" name="login_form" action="register.php" method="post">
                    <div class="input-fields"><input type="text" id="username" name="username" class="login-username"
                                                     placeholder="Username or Email">&nbsp;<img
                            src="img/icons/user.png"></div>
                    <div class="input-fields"><input type="password" id="password" name="password"
                                                     class="login-password" placeholder="Password">&nbsp;<img
                            src="img/icons/lock.png"></div>
                    <button type="submit" class="login-submit">Sign Up</button>
                </form>
                <div id="corner-message" onclick="window.location = 'index.php'">
                    <span>Already have an account? </span><span>Click here to login.</span>
                </div>
            </div>

        </div>
    </div>

    <?php
} else if ($_SESSION["user_id"] !== null AND $_SESSION['user_name'] !== null) {
    ?>

    <div id="container">
        <div id="content">
            <div id="content-left">
                <img class="fold" src="img/fold.png">
                <img class="logo" src="img/icons/logo.png">
                <span><span class="logo-1">Work</span><span class="logo-2">flow</span></span>
            </div>
            <div id="content-right">
                <span><span class="header-1">How did you get here, <?= $_SESSION['user_name'] ?>?.</span>

                <div id="corner-message" onclick="window.location = 'logout.php'">
                    <span>Made a mistake? </span><span>Logout now.</span>
                </div>
            </div>

        </div>
    </div>

    <?php
}

session_write_close();
?>

</body>
</html>