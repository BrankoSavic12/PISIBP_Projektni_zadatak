<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled urednika</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h1>Lista svih zahteva za odobravanje</h1>
                    <a href="naslovna.php"><button>Napusti stranicu</button></a>
                    
            </div>
        </div>
    </div>

        
    </body>
    </html>
<?php
} else {
    header("location:index.php");
}
?>
