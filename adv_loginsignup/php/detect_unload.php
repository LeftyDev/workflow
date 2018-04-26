<?php
require 'db_connect.php';

if (isset($_REQUEST["docID"])) {
    $docID = $_REQUEST["docID"];

    $sql = "UPDATE documents SET currently_edited = 0 WHERE id = '" . $docID . "'";
    $result = mysqli_query($link, $sql);

    header("Location: ../application.php");
}