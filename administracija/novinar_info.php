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
            echo "<div><h1>Osnovne informacije o novinaru</h1></div>";
            $novinar = $konekcija->getKorisnikByID($id_novinara);
            echo "<div class='info-item'>
                    <h3>Ime i prezime novinara:</h3>
                    <h4>$novinar[ime_prezime]</h4>
                </div>";
            echo "<div class='info-item'>
                    <h3>Korisnicko ime novinara:</h3>
                    <h4>$novinar[korisnicko_ime]</h4>
            </div>";
            echo "<div class='info-item'>
                    <h3>Email adresa novinara:</h3>
                    <h4>$novinar[email]</h4>
                </div>";

                $rubrike = $konekcija->getRubrikeByNovinarId($id_novinara);
                if ($rubrike != false) {
                    echo "<div class='info-item'>
                            <h3>Rubrike kojima pripada:</h3>";
                    while ($rubrika = $rubrike->fetch_assoc()) {
                        $rubrika_info = $konekcija->getRubrikaByID($rubrika["id_rubrike"]);
                        echo "<h4>$rubrika_info[naziv]</h4>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='info-item'>
                            <h3>Ovaj urednik nije dodeljen nijednoj rubrici</h3>
                        </div>";
                }
            ?>
            
            <form action="pregled_novinara.php" method="get">
                <input type="submit" value="Povratak na prethodnu stranu" name="odustani" class="btn";">
            </form>
            
        </div>
    </div>
</div>



    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
