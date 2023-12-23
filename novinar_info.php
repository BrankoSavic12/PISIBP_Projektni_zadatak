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
        <div class="info-container">
            <?php
            $id_novinara = $_GET["id_novinara"];
            echo "<h2>Osnovne informacije o novinaru</h2>";
            $novinar = $konekcija->getKorisnikByID($id_novinara);
            echo "<div class='info-item'>
                    <h3>Ime i prezime novinara:</h3>
                    <h4>$novinar[ime_prezime]</h4>
                </div>";
            echo "<div class='info-item'>
                    <h3>Email adresa novinara:</h3>
                    <h4>$novinar[email]</h4>
                </div>";

            $rubrike = $konekcija->getRubrikeByNovinarId($id_novinara);
            if ($rubrike != false) {
                while ($rubrika = $rubrike->fetch_assoc()) {
                    $rubrika_info = $konekcija->getRubrikaByID($rubrika["id_rubrike"]);
                    echo "<div class='info-item'>
                            <h3>Dodeljena rubrika:</h3>
                            <h4>$rubrika_info[naziv]</h4>
                        </div>";
                }
            } else {
                echo "<div class='info-item'>
                        <h3>Ovaj novinar nema nijednu rubriku</h3>
                    </div>";
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
