<?php
include 'db_connect.php';


if (isset($_REQUEST["doc_id"]) && isset($_REQUEST["user_id"]) && isset($_REQUEST["inv_username"])) {

    $sql = "SELECT * FROM users WHERE username = '" . $_REQUEST["inv_username"] . "'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) == 1) {


        $row = mysqli_fetch_array($result);
        $invited_user_id = $row['id'];
        $token = sha1($_REQUEST["inv_username"] . time());

        $sql2 = "INSERT INTO `collaborator_token_log` (`id`, `document_id`, `document_owner_id`, `invited_user_id`, `token`, `timestamp`) 
        VALUES (NULL, " . $_REQUEST["doc_id"] . ", " . $_REQUEST["user_id"] . ", " . $invited_user_id . ", '" . $token . "', NOW())";
        $result2 = mysqli_query($link, $sql2);
        if (mysqli_affected_rows($link) == 1) {
            $accept_link = "https://in-info-web4.informatics.iupui.edu/~brjebrow/N413/adv_loginsignup/accept_invitation.php?token=" . $token;
            $to = $row['email'];
            $subject = 'An Invitation to Collaborate on Workflow';
            $message = 'You have been invited to collaborate on a document in Workflow. This link below expires one hour from its sent date.
            Please click the link to accept the invitation.' . $accept_link . '
            ';

            //be sure the /r/n (carriage return) characters are in DOUBLE QUOTES!
            //PHP treats single quoted escaped characters differently, and things will break
            $headers = 'From: brjebrow@iu.edu' . "\r\n" .
                'Reply-To:brjebrow@iu.edu' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            $data["status"] = 'success';
            $data["invite_message"] = 'A link has been sent to ' . $_REQUEST["inv_username"];
            echo json_encode($data);
        }
    }
}