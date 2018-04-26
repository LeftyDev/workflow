<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Document | Workflow</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
    <!--<link rel="stylesheet" href="css/css/font-awesome.min.css">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600,800|Raleway:200,300,400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>Add Document</h1>
    <form id="add_document_form" name="add_document_form" action="" method="">
        <div class="input-fields">
            <input type="text" id="add_title" name="add_title" class="add_title"
                   placeholder="Document Title">
            <span class="add_error"></span>
        </div>
        <div class="input-fields input-add-content">
            <textarea id="add_content" name="add_content" class="add_content"
                      placeholder="Document Body"></textarea>
            <span class="add_error"></span>
        </div>
        <input type="hidden" id='add_user' value="<?= $_SESSION["user_id"] ?>">
        <button type="submit" class="add-submit">Submit</button>
    </form>

    <script type="text/javascript">
        $("#add_document_form").submit(function(event) {
           $(".add_error").html = "";
           event.preventDefault();
           $.post('php/add.php', {
               title: $("#add_title").val(),
               body: $("#add_content").val(),
               user: $("#add_user").val()
           },
           function(data) {
               $(".add_error").html = "";

               if (data.status == "success") {
                   window.location.href = "application.php";
               } else if (data.status == "failed") {
                   $(".input-fields:first-child .add_error").html(data.title_error);
                   $(".input-add-content .add_error").html(data.body_error);
               }
           }, "json");
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
<?php session_write_close(); ?>