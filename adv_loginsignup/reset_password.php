<?php
/**
 * Created by PhpStorm.
 * User: Brian
 * Date: 2/17/2018
 * Time: 5:08 AM
 */

include("php/db_connect.php");

session_start();
$_SESSION["user_id"] = 0;
$user_id = 0;
$user_message = "";

$token = "";
if (isset($_REQUEST["token"])) {
    $token = html_entity_decode($_REQUEST["token"]);
    $token = trim($token);
    $token = stripslashes($token);
    $token = strip_tags($token);
    $token = mysqli_real_escape_string($link, $token);

    $sql = "SELECT user_id, timestamp FROM password_reset_log 
			WHERE reset_token = '" . $token . "' ";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        $user_id = $row["user_id"];
        $link_time = $row["timestamp"];

        $sql = "SELECT TIMESTAMPDIFF(SECOND, '" . $link_time . "', NOW()) as time_elapsed";
        $result = mysqli_query($link, $sql);

        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        if ($row["time_elapsed"] > 3600) {  //1 hour
            //link has expired
            $user_message .='
            <span><span class="header-1">The password reset link has expired.</span>
			';

        } else {  //if ($row["time_elapsed"] > 3600)
            //link is good  -- reset the password
            $user_message .='
			<span><span class="header-1">Reset Your Password</span>
			<form id="password_form" name="password_form" action="" method="">
                <div class="input-fields"><input type="password" id="password" name="password"
                                                     class="reset-password" placeholder="New Password">&nbsp;<img
                                src="img/icons/lock.png"></div>
                    <button type="submit" class="login-submit">Submit</button>
            </form>
			';
        }  //  -end else- if ($row["time_elapsed"] > 3600)
    } else { // if (mysqli_num_rows() == 1)
        $user_message .='
			<span><span class="header-1">The password reset link is not valid.  Your password cannot be reset using this link.</span>';
    } // -end else- if (mysqli_num_rows() == 1)
} else { // if(isset($_REQUEST["token"]))
    $user_message .='
			<span><span class="header-1">The password reset token is not valid.  Your password cannot be reset using this link.</span>';
}// -end else- if(isset($_REQUEST["token"]))

?>

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
</head>
<body>

<div id="container">
    <div id="content">
        <div id="content-left">
            <img class="fold" src="img/fold.png">
            <img class="logo" src="img/icons/logo.png">
            <span><span class="logo-1">Work</span><span class="logo-2">flow</span></span>
        </div>
        <div id="content-right">
                <?= $user_message ?>
            <div id="corner-message-right">
                <span id="user_error_message"></span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Attach a submit handler to the form
    $("#password_form").submit(function(event) {
        event.preventDefault();
        $.post("new_password.php",
            {id:<?php echo $user_id; ?>, password:$("#password").val()},
            function(data){
                //reset any previous error messages
                $("#user_error_message").html("");
                $("#user_error_message").css("display","none");

                if(data.status == "success"){
                    if(data.user_message != null){
                        $("#user_error_message").html(data.user_message);
                        $("#user_error_message").css("display","block");
                    }
                }else{
                    if(data.password_error != null){
                        $("#user_error_message").html(data.password_error);
                        $("#user_error_message").css("display","block");
                    }
                }
            },
            "json"
        );
    });
</script>

</body>
</html>