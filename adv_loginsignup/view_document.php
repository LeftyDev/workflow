<?php
include "php/db_connect.php";
session_start();

$users = Array();

if (isset($_REQUEST["docID"])) {
    $sql = "SELECT * from documents WHERE id = " . $_REQUEST["docID"];
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
    }


    $sql2 = "SELECT * from users";
    $result2 = mysqli_query($link, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_array($result2)) {
            $users[] = Array(
                "username" => $row2['username']
            );
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App | Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->

    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="jquery-ui.css">
    <script>
        var users = [];
        <?php foreach ($users as $user) {
        ?>
        users.push('<?php echo $user['username']; ?>');
        <?php
        } ?>
        console.log(users);
        $(document).ready(function() {
            $("#invite_username").autocomplete({
                source: users
            });
        });

    </script>
</head>
<body>

<h1><?= $row["title"] ?></h1>
<?= $row["content"] ?><br>
<input id="invite_username" class="invite_username" placeholder="Username"><button id="invite-btn">Invite Collaborator</button>
<span class="invite-message"></span>

<script type="text/javascript">
    // Attach a submit handler to the form
    $("#invite-btn").click(function(event) {
        event.preventDefault();
        $.post("php/invite.php", {
                doc_id: <?php echo $_REQUEST["docID"] ?>,
                user_id: <?php echo $_SESSION["user_id"] ?>,
                inv_username: $(".invite_username").val()
            },
            function(data){
                //reset any previous error messages
                $(".invite-message").html("");

                if (data.status == "success") {
                        $(".invite-message").html(data.invite_message);
                } else {
                    if (data.status != "success"){
                        $(".invite-message").html(data.invite_error);
                    }
                }
            },
            "json"
        );
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
<?php session_write_close();
