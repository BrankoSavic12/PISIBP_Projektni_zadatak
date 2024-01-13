<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informacije o uredniku:</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
    <div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content">
        <div class="info-container" style="max-width:450px;">
            <?php
            $id_urednika = $_GET["id_urednika"];
            $urednik = $konekcija->getKorisnikByID($id_urednika);
            echo "<div><h1>Informacije o uredniku:</h1></div>";
            echo "<div class='info-item'>
                    <h2>Ime i prezime urednika:</h2>
                    <h3>$urednik[ime_prezime]</h3>
                </div>";
            echo "<div class='info-item'>
                    <h2>Korisnicko ime urednika:</h2>
                    <h3>$urednik[korisnicko_ime]</h3>
                </div>";
            echo "<div class='info-item'>
                    <h2>Email adresa urednika:</h2>
                    <h3>$urednik[email]</h3>
                </div>";

            $rubrike = $konekcija->getRubrikeByUrednikId($id_urednika);
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
            <a href="pregled_urednika.php" class="back-link" style="padding-left: 10px">Napusti stranicu</a>
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
