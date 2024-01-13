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
        <div class="info-container"  style="max-width:450px;">
        <div><h1>Informacije o novinaru:</h1></div>
            <?php
            $id_novinara = $_GET["id_novinara"];
            $novinar = $konekcija->getKorisnikByID($id_novinara);
            echo "<div class='info-item'>
                    <h2>Ime i prezime novinara:</h2>
                    <h3>$novinar[ime_prezime]</h3>
                </div>";
            echo "<div class='info-item'>
                    <h2>Korisnicko ime novinara:</h2>
                    <h3>$novinar[korisnicko_ime]</h3>
            </div>";
            echo "<div class='info-item'>
                    <h2>Email adresa novinara:</h2>
                    <h3>$novinar[email]</h3>
                </div>";

                $rubrike = $konekcija->getRubrikeByNovinarId($id_novinara);
                if ($rubrike != false) {
                    echo "<div class='info-item'>
                            <h2>Rubrike kojima pripada:</h2>";
                    while ($rubrika = $rubrike->fetch_assoc()) {
                        $rubrika_info = $konekcija->getRubrikaByID($rubrika["id_rubrike"]);
                        echo "<h3>$rubrika_info[naziv]</h3>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='info-item'>
                            <h3>Ovaj urednik nije dodeljen nijednoj rubrici</h3>
                        </div>";
                }
            ?>
            <a href="pregled_novinara.php" class="back-link" style="padding-left: 10px">Napusti stranicu</a>

        </div>
    </div>
</div>



    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
