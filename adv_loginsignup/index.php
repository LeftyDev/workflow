<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script>
        $(document).ready(function() {
            var modalMinHeight = $('#modal-box').css('min-height');
            $('#modal, #modal-box').hide();
            $('#modal').click(function(e){
                if (e.target.id === "modal-box") {
                    return false;
                } else {
                    $(this).fadeToggle(300);
                    $('#modal-box').css('min-height', 0).slideToggle(300, function() {
                        $(this).css('min-height', modalMinHeight)
                    });
            }
            });
            $('img.exit-out').click(function() {
                $('#modal').fadeToggle(300);
                $('#modal-box').css('min-height', 0).slideToggle(300, function() {
                    $(this).css('min-height', modalMinHeight)
                });
            })
        })
    </script>
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
                <span><span class="header-1">Welcome to Work</span><span class="header-2">flow.</span></span>
                <form id="login_form" name="login_form" action="login.php" method="post">
                    <div class="input-fields"><input type="text" id="username" name="username" class="login-username"
                                                     placeholder="Username">&nbsp;<img
                                src="img/icons/user.png"></div>
                    <div class="input-fields"><input type="password" id="password" name="password"
                                                     class="login-password" placeholder="Password">&nbsp;<img
                                src="img/icons/lock.png"></div>
                    <button type="submit" class="login-submit">Log In</button>
                </form>
                <div id="corner-message-left" onclick="window.location = 'register_form.php'">
                    <span>Register </span><span>an Account</span>
                </div>
                <div id="corner-message-right">
                    <span onclick="$('#modal').fadeToggle(300); $('#modal-box').css('min-height', 0).slideToggle(300, function() {$(this).css('min-height', 520)});">Forgot Password?</span>
                </div>
            </div>

        </div>
    </div>

    <div id="modal">
    </div>

    <div id="modal-box">
        <span class="header">Reset Password</span>
        <form id="reset_form" name="reset_form" action="" method="">
            <div class="input-fields"><input type="text" id="email" name="email" class="email"
                                             placeholder="Email Address">&nbsp;<img
                        src="img/icons/envelope.png"></div>
            <button type="submit" class="reset-submit">Reset</button>
        </form>
        <span id="email_error"></span>
        <span id="user_error_message"></span>
        <img src="img/icons/x-2.png" class="exit-out">
    </div>

    <script type="text/javascript">
        // Attach a submit handler to the form
        $( "#reset_form" ).submit(function(event) {
            event.preventDefault();
            $.post('reset.php', {email: $("#email").val()},
                function(data) {
                        console.log(data);
                        //reset the error messages
                        $("#user_error_message").html("");
                        $("#user_error_message").css("display","none");
                        $("#email_error").html("");
                        $("#email_error").css("display","none");

                        if (data.status == "success") {
                            if (data.user_message != null) {
                                $("#user_error_message").html(data.user_message);
                                $("#user_error_message").css("display","block");
                            }
                        } else {
                            if (data.email_error != null) {
                                $("#email_error").html(data.email_error);
                                $("#email_error").css("display","block");
                            }
                        }
                    }, "json"
            );
        });
    </script>

    <?php
    } else if ($_SESSION["user_id"] !== null AND $_SESSION['user_name'] !== null AND $_SESSION['user_email'] !== null) {
    ?>

    <div id="container">
        <div id="content">
            <div id="content-left">
                <img class="fold" src="img/fold.png">
                <img class="logo" src="img/icons/logo.png">
                <span><span class="logo-1">Work</span><span class="logo-2">flow</span></span>
            </div>
            <div id="content-right">
                <span><span class="header-1">You are successfully logged in, <?= $_SESSION['user_name'] . " (" . $_SESSION['user_email'] . ")" ?>.</span>

                <div id="corner-message-right" onclick="window.location = 'logout.php'">
                    <span></span><span>Logout</span>
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