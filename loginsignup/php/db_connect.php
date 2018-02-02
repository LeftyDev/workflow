<?php

////////////////////// web-4 method ///////////////////////
//
//	$dbhost = 'localhost';
//	$dbuser = '<your CAS user name>';
//	$dbpwd  = '<your CAS user name>';
//	$dbname = '<your CAS user name>_db';
//
//	$conn = mysql_connect($dbhost, $dbuser, $dbpwd);
//	$db   = mysql_select_db($dbname, $conn);
//
//////////////////////////////////////////////////////////
///
////////////////////// mysqli method /////////////////////
///
$dbhost = 'localhost';
$dbuser = 'root';
$dbpwd  = 'root';
$dbname = 'workflow';

$link = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);
if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}
?>