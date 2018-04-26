<?php
include ("db_connect.php");

$data = Array();

$title_error = '';
$body_error = '';
$problems = false;

if (isset($_REQUEST["title"]) && isset($_REQUEST["body"]) && isset($_REQUEST["user"])) {
    $title = html_entity_decode($_REQUEST["title"]);
    $title = trim($title);
    $body = html_entity_decode($_REQUEST["body"]);
    $body = trim($body);
    $user_id = html_entity_decode($_REQUEST["user"]);
    $user_id = trim($user_id);

    if (strlen($title) < 1) {
        $problems = true;
        $title_error = 'You must enter a title.';
    } else if (strlen($title) > 30) {
        $problems = true;
        $title_error = "Title can't be more than 30 characters.";
    } else {
        $problems = false;
        $title_error = '';
        $title = stripslashes($title);
        $title = strip_tags($title);
        $title = mysqli_real_escape_string($link, $title);

        if (strlen($body) < 1) {
            $problems = true;
            $title_error = '';
            $body_error = "You must enter a body.";
        } else {
            $problems = false;
            $body_error = '';
            $body = stripslashes($body);
            $body = strip_tags($body);
            $body = mysqli_real_escape_string($link, $body);

            if ($user_id == null) {
                $problems = true;
                $body_error = "There was an unexpected error.";
            } else {
                $problems = false;
                $body_error = "";
                $user_id = stripslashes($user_id);
                $user_id = strip_tags($user_id);
                $user_id = mysqli_real_escape_string($link, $user_id);

                $sql = "INSERT INTO `documents` (`id`, `title`, `date_created`, `creator_id`, `last_update`, `last_updater_id`, `content`, `currently_edited`) 
                        VALUES (NULL, '" . $title . "', NOW(), '" . $user_id . "', NOW(), '" . $user_id . "', '" . $body . "', '0')";
                $result = mysqli_query($link, $sql);
                if (mysqli_affected_rows($link) == 1) {
                    $problems = false;
                }
            }
        }
    }
}

if ($problems == false) {
    $data["status"] = 'success';
    echo json_encode($data);
} else if ($problems == true) {
    $data["status"] = 'failed';
    $data["title_error"]  = $title_error;
    $data["body_error"] = $body_error;
    echo json_encode($data);
}