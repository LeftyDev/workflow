<?php
include("n413connect.php");

session_start();
//if (! isset($_SESSION["user_id"])) { $_SESSION["user_id"] = 0; }
$_SESSION["user_id"] = 0;
$password_error = '';
$user_message = '';
$problems = false;

$user_id = 0;
if (isset($_REQUEST["id"])) {
	$user_id = intval($_REQUEST["id"]); 
} else {
	$problems = true;
	$password_error = 'Password cannot be reset';
}

$password = "";
if (isset($_REQUEST["password"])) {
	$password = html_entity_decode($_REQUEST["password"]);
	$password = trim($password);
	//check for password length
	if(strlen($password) < 8) {
		$problems = true;
		$password_error = 'Passwords must contain at least 8 characters';
	} else {  //  if(strlen($password) < 8)
		$password = password_hash($password, PASSWORD_DEFAULT);
	}  // -end else- if(strlen($password) < 8)
	
} else {  //  if(isset($_REQUEST["password"]))
	$problems = true;
	$password_error = 'Please provide a password.';
}// -end else- if(isset($_REQUEST["password"]))

if (!$problems) {
	
	$sql = "UPDATE users SET password = '$password' WHERE id = '$user_id'";
	$result = mysqli_query($link, $sql); 
	if (mysqli_affected_rows($link) === 1) {
		$_SESSION["user_id"] = $user_id;
        $password_error = "Your password is being reset...";
        echo "<script>setTimeout(function() {return false;}, 1500)</script>";
	} else (m) {
		$password_error = 'There was a problem with the database. Your password cannot be reset. ID=' . $user_id . " Password=" . $password;
	}  // if( ! mysqli_affected_rows($link) == 1

} // if ( ! $problems )

$data = Array();

if ($_SESSION["user_id"] > 0){
	$data["status"] = 'success';
	$data["user_message"] = 'Your password has been successfully reset.';
	echo json_encode($data);
}else{ // if ($_SESSION["user_id"] > 0)
	$data["status"] = 'failed';
	if ($password_error > ''){ $data["password_error"] = $password_error; }
	echo json_encode($data);
} // -end else- if ($_SESSION["user_id"] > 0)

session_write_close();

?>