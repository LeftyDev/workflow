<?php
include("php/db_connect.php");

session_start();
$token = "";
$collaborator_id = 0;
$document_id = 0;

if (isset($_REQUEST["token"])) {
    $token = html_entity_decode($_REQUEST["token"]);
    $token = trim($token);
    $token = stripslashes($token);
    $token = strip_tags($token);
    $token = mysqli_real_escape_string($link, $token);

    $sql = "SELECT * FROM collaborator_token_log
			WHERE token = '" . $token . "'";
    $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_BOTH);
        $document_id = $row["document_id"];
        $collaborator_id = $row["invited_user_id"];
        $link_time = $row["timestamp"];

        $sql2 = "SELECT TIMESTAMPDIFF(SECOND, '" . $link_time . "', NOW()) as time_elapsed";
        $result2 = mysqli_query($link, $sql2);

        $row2 = mysqli_fetch_array($result2, MYSQLI_BOTH);
        if ($row2["time_elapsed"] > 3600) {  //1 hour
            //link has expired
            $message = '
            <span><span class="header-1">The collaborator invite link has expired.</span>
			';

        } else {  //if ($row["time_elapsed"] > 3600)
            //link is good  -- reset the password
            $message = '
			<h1>Accept Invitation</h1>
                    <button type="submit" class="invite-submit">Accept</button>
			';
        }  //  -end else- if ($row["time_elapsed"] > 3600)
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?= $message ?>

<script type="text/javascript">
    // Attach a submit handler to the form
    $(".invite-submit").click(function(event) {
        event.preventDefault();
        $.post("invite_accepted.php", {
                collaborator: <?= $collaborator_id ?>,
                document: <?= $document_id ?>
            },
            function(data){
                //reset any previous error messages

                if (data.status == "success") {
                    window.location.href = "application.php";
                } else {
                    if(data.status != "success"){
                        alert("Something went wrong");
                    }
                }
            },
            "json"
        );
    });
</script>

</body>
</html>