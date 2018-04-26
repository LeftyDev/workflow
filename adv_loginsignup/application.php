<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App | Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script>
        $(document).ready(function() {
            var modalMinHeight = $('#modal-box').css('min-height');
            $('#modal, #modal-box').hide();
            $('#modal').click(function(e){
                if (e.target.id === "modal-box") {
                    return false;
                } else {
                    $(this).fadeToggle(300);
                    $('#modal-box').css('min-height', 0).slideToggle(300, function() {
                        $(this).css('min-height', modalMinHeight)
                    });
                }
            });
            $('img.exit-out').click(function() {
                $('#modal').fadeToggle(300);
                $('#modal-box').css('min-height', 0).slideToggle(300, function() {
                    $(this).css('min-height', modalMinHeight)
                });
            })
        })
    </script>
</head>
<body>

<?php

include('php/db_connect.php');

session_start();

if (!(isset($_SESSION["user_id"])) OR $_SESSION["user_id"] == 0) {

    ?>

    <script type="text/javascript">
        window.location.href = "index.php"
    </script>

<?php

} else if ($_SESSION["user_id"] !== null AND $_SESSION['user_name'] !== null AND $_SESSION['user_email'] !== null) {

    //SQL query to select documents related to signed in User
    $sql = "SELECT * FROM documents WHERE creator_id = '" . $_SESSION["user_id"] . "' ORDER BY last_update DESC";
    $result = mysqli_query($link, $sql);

    $documents = Array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            $documents[] = Array(
                "id" => $row["id"],
                "title" => $row["title"],
                "date_created" => $row["date_created"],
                "creator_id" => $row["creator_id"],
                "last_update" => $row["last_update"],
                "last_updater_id" => $row["last_updater_id"],
                "content" => $row["content"]
            );
        }
    }

    $sql2 = "SELECT document_id FROM document_collaborators WHERE collaborator_id = " . $_SESSION["user_id"];
    $result2 = mysqli_query($link, $sql2);
    if (mysqli_num_rows($result2) > 0) {
        $row2 = mysqli_fetch_array($result2, MYSQLI_BOTH);

        $sql3 = "SELECT * FROM documents WHERE id = " . $row2["document_id"] . " ORDER BY last_update DESC";
        $result3 = mysqli_query($link, $sql3);

        if (mysqli_num_rows($result3) > 0) {
            while ($row3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
                $documents[] = Array(
                    "id" => $row3["id"],
                    "title" => $row3["title"],
                    "date_created" => $row3["date_created"],
                    "creator_id" => $row3["creator_id"],
                    "last_update" => $row3["last_update"],
                    "last_updater_id" => $row3["last_updater_id"],
                    "content" => $row3["content"],
                    "collaborator" => true
                );
            }
        }
    }
?>

    <div id="left"></div>
    <div id="right"></div>
    <div id="top">
        <span class="app-logo">Work<span class="app-logo-bold">flow</span></span>
        <div>
            <span class="header-username">Welcome, <?= $_SESSION['user_name'] ?>.</span>
<!--            <div class="user-image"></div>-->
        </div>
    </div>
    <div id="bottom"></div>

    <div id="app-container">
        <div id="add-something" onclick="window.location.href = 'add_document.php'">
            <span>Add a Project</span>
            <img src="img/icons/plus.svg">
        </div>
        <div id="document-listing">
            <?php
            if (count($documents) > 0) {
                foreach ($documents as $document) {
                    ?>
                    <div id="document_<?= $document["id"] ?>" class="document">
                        <span class="document_title"><?php if (isset($document["collaborator"])) echo "[C] "; echo $document["title"] ?></span>
                        <span class="document_date">Created <?= $document["date_created"] ?></span>
                        <span class="document_editdate">Updated <?= $document["last_update"] ?></span>
                        <img src="img/icons/eye.png" class="document_eye"
                             onclick="window.location.href = 'view_document.php?docID=<?= $document["id"] ?>'">
                        <img src="img/icons/edit.png" class="document_edit"
                             onclick="window.location.href = 'edit_document.php?docID=<?= $document["id"] ?>'">
                        <img src="img/icons/trash.png" class="document_trash"
                             onclick="alert('Are you sure you want to delete <?= $document['title'] ?>?'); window.location.href= 'delete_document.php?docID=<?= $document["id"] ?>'">
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="document">
                    <span class="stand-in-message">Documents will be listed here once you add one.</span>
                </div>
                <?php
            }
            ?>
            <span class="nothing_else">There's nothing else to show</span>
        </div>
    </div>

    <div id="modal">
    </div>

    <div id="modal-box">
        <span class="header"></span>
        <img src="img/icons/x-2.png" class="exit-out">
    </div>

    <?php
} else {

    echo "Something went wrong.";

}

session_write_close();
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>