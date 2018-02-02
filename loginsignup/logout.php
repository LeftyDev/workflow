<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:400,600,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
session_start();
session_unset();
session_destroy();
    ?>

<div id="container">
    <div id="content">
        <div id="content-left">
            <img class="fold" src="img/fold.png">
            <img class="logo" src="img/icons/logo.png">
            <span><span class="logo-1">Work</span><span class="logo-2">flow</span></span>
        </div>
        <div id="content-right">
            <span><span class="header-1">You have been logged out.</span>
            <div id="corner-message" onclick="window.location = 'index.php'">
                <span>Go back to </span><span>Home.</span>
            </div>
        </div>

    </div>
</div>

</body>
</html>

<?php
session_write_close();