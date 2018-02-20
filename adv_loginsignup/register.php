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

$email = "";
if (isset ($_POST["email"])) {
    $email = strip_tags(stripslashes(trim(html_entity_decode($_POST["email"]))));
    $email = mysqli_real_escape_string($link, $email);
}

$sql = "SELECT id FROM users WHERE username = '" . $username . "'";
$result = mysqli_query($link, $sql);

//if user doesn't already exist
if (mysqli_num_rows($result) === 0) {
    echo "user doesn't exist, continuing account creation process <br>";
    $sql = "INSERT INTO users (`id`, `username`, `password`, `email`) VALUES (NULL, '" . $username . "', '" . $password . "', '" . $email . "')";
    $result = mysqli_query($link, $sql);
    echo "insert id: " . mysqli_insert_id($link) . "<br>";
    echo "number of rows affected by query: " . mysqli_affected_rows($link) . "<br>";

    if (mysqli_affected_rows($link)) {
        $user_id = mysqli_insert_id($link);
        echo $user_id;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_name"] = $username;
        $_SESSION["user_email"] = $email;
    }
} else {
    echo "account already exists";
    session_unset();
    session_destroy();
}

if ($_SESSION["user_id"] > 0) {
    echo '<script type="text/javascript">window.location = "index.php"</script>';
} else {
//    echo '<script type="text/javascript">window.location = "logout.php"</script>';
    echo 'user id cannot be read';
    session_unset();
    session_destroy();
}

session_write_close();