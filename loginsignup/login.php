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

$password = "";
if (isset($_POST["password"])) {
    $password = trim(html_entity_decode($_POST["password"]));
}

$sql = "SELECT id, username FROM users WHERE username = '" . $username . "' AND password = '" . $password . "' ";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
    $user_id = $row["id"];
    $user_name = $row["username"];
    $_SESSION["user_id"] = $user_id;
    $_SESSION["user_name"] = $user_name;
}

if ($_SESSION["user_id"] > 0) {
    echo '<script type="text/javascript">window.location = "index.php";</script>';
}

session_write_close();