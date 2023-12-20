<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled novinara</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <?php
                    $id_novinara = $_GET["id_novinara"];
                    $novinar = $konekcija->getKorisnikByID($id_novinara);
                    echo "<h2>$novinar[ime_prezime]</h2>";
                    echo "<h3>$novinar[email]</h3>";
                    $rubrike = $konekcija->getRubrikeByNovinarId($id_novinara);
                    if ($rubrike != false) {
                        while ($rubrika = $rubrike->fetch_assoc()) {
                            $rubrika_info = $konekcija->getRubrikaByID($rubrika["id_rubrike"]);
                            echo "<h3>$rubrika_info[naziv]</h3>";
                        }
                    } else {
                        echo "<h3>Ovaj novinar nema nijednu rubriku</h3>";
                    }




                    ?>
                </div>
            </div>
        </div>


    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
