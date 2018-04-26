<?php
include "db_connect.php";

if (isset($_REQUEST["edit_title"]) && isset($_REQUEST["edit_content"]) && isset($_REQUEST["edit_user"]) && isset($_REQUEST["edit_docID"])) {
    $title = strip_tags(stripslashes(trim(html_entity_decode($_REQUEST["edit_title"]))));
    $title = mysqli_real_escape_string($link, $title);
    $body = strip_tags(stripslashes(trim(html_entity_decode($_REQUEST["edit_content"]))));
    $body = mysqli_real_escape_string($link, $body);
    $user_id = strip_tags(stripslashes(trim(html_entity_decode($_REQUEST["edit_user"]))));
    $user_id = mysqli_real_escape_string($link, $user_id);

    $sql = "UPDATE documents SET title = '" . $title . "', last_update = NOW(), last_updater_id = " . $user_id . ", content = '" . $body . "', currently_edited = 0 
          WHERE id = " . $_REQUEST["edit_docID"];
    $result = mysqli_query($link, $sql);

    header("Location: ../application.php");
}