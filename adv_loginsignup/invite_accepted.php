<?php
include "php/db_connect.php";

if (isset($_REQUEST["collaborator"]) && isset($_REQUEST["document"])) {
    $sql = "INSERT INTO `document_collaborators` (`id`, `document_id`, `collaborator_id`)
            VALUES (NULL, " . $_REQUEST["document"] . ", " . $_REQUEST["collaborator"] . ")";
    $result = mysqli_query($link, $sql);

    $data["status"] = 'success';
    echo json_encode($data);
}