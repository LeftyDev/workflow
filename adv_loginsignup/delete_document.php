<?php
include "php/db_connect.php";

if (isset($_REQUEST['docID'])) {
    $sql = "DELETE FROM documents WHERE id = " . $_REQUEST['docID'];
    $result = mysqli_query($link, $sql);
}

header("Location: application.php");