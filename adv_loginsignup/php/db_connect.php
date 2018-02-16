<?php

////////////////////// MAMP version ///////////////////////

//	$dbhost = 'localhost';
//	$dbuser = 'root';
//	$dbpwd  = 'root';
//	$dbname = 'workflow';
//
//	$link = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);
//
//	if (!$link) {
//		die('Connect Error (' . mysqli_connect_errno() . ') '
//				. mysqli_connect_error());
//	}

//////////////////////////////////////////////////////////

////////////////////// web-4 method /////////////////////

$dbhost = 'localhost';
$dbuser = 'brjebrow';
$dbpwd  = 'brjebrow';
$dbname = 'brjebrow_db';

$link = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);

if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}

?>
