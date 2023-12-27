<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <?php
        if (($_SESSION["uloga"]) == 'glavni urednik') {
            echo "<title>Stranica glavnog urednika</title>";
        } elseif (($_SESSION["uloga"]) == 'urednik') {
            echo "<title>Stranica urednika</title>";
        } elseif (($_SESSION["uloga"]) == 'novinar') {
            echo "<title>Stranica glavnog urednika</title>";
        }

        ?>

    </head>

    <body>
        <div class="navigacija">
            <?php include "menu.php" ?>
        </div>


    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
