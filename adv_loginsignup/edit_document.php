<?php
session_start();
require 'php/db_connect.php';

if (isset($_REQUEST["docID"])) {
    $docID = $_REQUEST["docID"];
    $sql = "SELECT * FROM documents WHERE id = '" . $docID . "'";
    $row = mysqli_query($link, $sql);

    if (mysqli_num_rows($row) == 1) {
        $row = mysqli_fetch_array($row, MYSQLI_BOTH);

        $sql = "SELECT TIMESTAMPDIFF(SECOND, '" . $row["last_update"] . "', NOW()) as time_elapsed";
        $result = mysqli_query($link, $sql);

        $row2 = mysqli_fetch_array($result, MYSQLI_BOTH);
        if ($row2["time_elapsed"] < 60) {  //1 minute
            echo "something crazy";
            header("Location: application.php");
            exit();
        }
    }

    $title = $row["title"];
    $body = $row["content"];

    $sql2 = "UPDATE documents SET last_update = NOW(), currently_edited = 1 WHERE id = '" . $docID . "'";
    $result = mysqli_query($link, $sql2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Document | Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800"
          rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Edit Document</h1>
<form id="edit_document_form" name="edit_document_form" action="php/edit.php" method="post">
    <div class="input-fields">
        <input type="text" id="edit_title" name="edit_title" class="edit_title"
               placeholder="Document Title" value="<?= $title ?>">
        <span class="edit_error"></span>
    </div>
    <div class="input-fields input-add-content">
            <textarea id="edit_content" name="edit_content" class="edit_content"
                      placeholder="Document Body"><?= $body ?></textarea>
        <span class="edit_error"></span>
    </div>
    <input type="hidden" id='edit_user' name="edit_user" value="<?= $_SESSION["user_id"] ?>">
    <input type="hidden" id='edit_docID' name="edit_docID" value="<?= $docID ?>">
    <button type="submit" class="edit-submit">Submit</button>
</form>

<!--    <script type="text/javascript">-->
<!--        $("#add_document_form").submit(function(event) {-->
<!--            $(".add_error").html = "";-->
<!--            event.preventDefault();-->
<!--            $.post('php/add.php', {-->
<!--                    title: $("#add_title").val(),-->
<!--                    body: $("#add_content").val(),-->
<!--                    user: $("#add_user").val()-->
<!--                },-->
<!--                function(data) {-->
<!--                    $(".add_error").html = "";-->
<!---->
<!--                    if (data.status == "success") {-->
<!--                        window.location.href = "application.php";-->
<!--                    } else if (data.status == "failed") {-->
<!--                        $(".input-fields:first-child .add_error").html(data.title_error);-->
<!--                        $(".input-add-content .add_error").html(data.body_error);-->
<!--                    }-->
<!--                }, "json");-->
<!--        });-->
<!--//</script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
<script src="js/app.js"></script>
<script>
    $(window).on("beforeunload", function () {
        $.ajax({
            url: 'php/detect_unload.php',
            type: "POST",
            dataType: "json",
            data: {
                docID: <?= $docID ?>
            }
        });
    });
</script>
</body>
</html>
<?php session_write_close(); ?>