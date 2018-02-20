<?php
//include("php/db_connect.php");

$email_error = '';
$problems = false;
$user_id = 0;
$email = "";

if (isset($_REQUEST["email"])) {
    $email = html_entity_decode($_REQUEST["email"]);
    $email = trim($email);

    //check for an empty username
    if (strlen($email) < 1) { //5 because x@x.x is 5
        $problems = true;
        $email_error = 'You must enter your email address.';
    } else if ( ! preg_match('/@/', $email)) { //check for disallowed characters
        $problems = true;
        $email_error = 'You must enter a valid email address.';
    } else {
        $email = stripslashes($email);
        $email = strip_tags($email);
        $email = mysqli_real_escape_string( $link, $email );
    }
}  //  if(isset($_REQUEST["email"]))

$data = Array();

if ($user_id > 0) {
    $data["status"] = 'success';
    $data["user_message"] = "A link to reset your password has been mailed to your e-mail address.<br/>The link is valid for 1 hour.";
    echo json_encode($data);
} else {
    $data["status"] = 'failed';
    if ($email_error > "") {
        $data["email_error"] = $email_error;
        echo json_encode($data);
    }
}