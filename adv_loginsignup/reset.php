<?php
include("php/db_connect.php");

$data = Array();

$email_error = '';
$problems = false;
$user_id = 0;
$email = "";
$data["email_error"] = $email_error;
$data["user_message"] = '';

if (isset($_REQUEST["email"])) {
    $email = html_entity_decode($_REQUEST["email"]);
    $email = trim($email);

    //check for an empty username
    if (strlen($email) < 1) { //5 because x@x.x is 5
        $problems = true;
        $email_error = 'You must enter your email address.';
    } else if (!preg_match('/@/', $email)) { //check for disallowed characters
        $problems = true;
        $email_error = 'You must enter a valid email address.';
    } else {
        $email_error = '';
        $email = stripslashes($email);
        $email = strip_tags($email);
        $email = mysqli_real_escape_string($link, $email);

        $sql = "SELECT id FROM users 
        WHERE email = '" . $email . "' ";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) == 1) {
            $email_error = '';
            $row = mysqli_fetch_array($result, MYSQLI_BOTH);
            $user_id = $row["id"];
            $token = sha1($email . time());

            $sql = "INSERT INTO `password_reset_log` (`id`, `user_id`, `reset_token`, `timestamp`) 
	 		VALUES (NULL, '" . $user_id . "', '" . $token . "', NOW())";
            $result = mysqli_query($link, $sql);
            if (mysqli_affected_rows($link) == 1) {
                $email_error = '';
                $reset_link = "http://localhost/N413/adv_loginsignup/reset_password.php?token=" . $token;
                $to = $_REQUEST["email"];
                $subject = 'Password Reset Request';
                $message = '
A password reset request has been made for your N413 AdvLogin 4 account that uses this e-mail address.  If you did not initiate this request, please notify the security team at once.
			
If you made the request, please click on the link below to reset your password.  This link will expire one hour from the time this e-mail was sent.
			
' . $reset_link . '
			';
                //be sure the /r/n (carriage return) characters are in DOUBLE QUOTES!
                //PHP treats single quoted escaped characters differently, and things will break
                $headers = 'From: brjebrow@iupui.edu' . "\r\n" .
                    'Reply-To:brjebrow@iupui.edu' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);

            } else {
                $email_error = "There was a problem with the database. Your password cannot be reset.";
            }

        } else {
            $email_error = "The e-mail address you entered was not found in the database.";
        }
    }
}  //  if(isset($_REQUEST["email"]))

if ($user_id > 0) {
    $data["status"] = 'success';
    $data["user_message"] = "A reset link was sent to your e-mail address (valid for 1 hour).";
    echo json_encode($data);
} else {
    $data["status"] = 'failed';
    if ($email_error > "") {
        $data["email_error"] = $email_error;
        echo json_encode($data);
    }
}