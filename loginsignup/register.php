<?php
include('php/db_connect.php');

session_start();
$_SESSION["user_id"] = 0;

$username = "";
if (isset($_POST["username"])) {
    $username = strip_tags(stripslashes(trim(html_entity_decode($_POST["username"]))));
    $username = mysqli_real_escape_string($link, $username);
}

$password = "";
if (isset($_POST["password"])) {
    $password = trim(html_entity_decode($_POST['password']));
    $password = password_hash($password, PASSWORD_DEFAULT);
}

$sql = "SELECT id FROM users WHERE username = '" . $username . "'";

$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO users (`id`, `username`, `password`) VALUES (NULL, '" . $username . "', '" . $password . "')";
    $result = mysqli_query($link, $sql);

    if (mysqli_affected_rows($link) === 1) {
        $user_id = mysqli_insert_id($link);
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_name"] = $username;
    }
}

if ($_SESSION["user_id"] > 0) {
    echo '<script type="text/javascript">window.location = "index.php"</script>';
} else {
    echo '<script type="text/javascript">window.location = "logout.php"</script>';
}

session_write_close();