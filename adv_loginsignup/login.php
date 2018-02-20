<?php
include("php/db_connect.php");

//start session for storage of user info
session_start();
//initialize SESSION variable
$_SESSION["user_id"] = 0;

$username = "";
if (isset($_POST["username"])) {
    //sanitize POST data
    $username = strip_tags(stripslashes(trim(html_entity_decode($_POST["username"]))));
    $username = mysqli_real_escape_string($link, $username);
}

$pw_hash_check = "SELECT password FROM users WHERE username = '" . $username . "' ";
$result_hash = mysqli_query($link, $pw_hash_check);
$result_hash = mysqli_fetch_array($result_hash);
$hash = $result_hash["password"];

$password = "";
if (isset($_POST["password"])) {
    $password = trim(html_entity_decode($_POST["password"]));
    $pw_verified = password_verify($password, $hash);
}

if ($pw_verified == true) {
    $sql = "SELECT id, username, email FROM users WHERE username = '" . $username . "'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        $user_id = $row["id"];
        $user_name = $row["username"];
        $user_email = $row["email"];
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_name"] = $user_name;
        $_SESSION["user_email"] = $user_email;
    }
}

if ($_SESSION["user_id"] > 0) {
    echo '<script type="text/javascript">window.location = "index.php";</script>';
} else {
    echo 'Invalid Username or Password';
    session_unset();
    session_destroy();
}

session_write_close();