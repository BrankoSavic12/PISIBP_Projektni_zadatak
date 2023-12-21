<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informacije o uredniku</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <?php
                    $id_urednika = $_GET["id_urednika"];
                    $urednik = $konekcija->getKorisnikByID($id_urednika);
                    echo "<h3>Ime i prezime urednika:</h3>
                    <h4>$urednik[ime_prezime]</h4>";
                    echo "<h3>Email adresa urednika:</h3>
                    <h4>$urednik[email]</h4>";
                    $rubrike = $konekcija->getRubrikeByUrednikId($id_urednika);
                    if ($rubrike != false) {
                        echo "<h3>Dodeljene rubrike:</h3>";
                        while ($rubrika = $rubrike->fetch_assoc()) {
                            $rubrika_info = $konekcija->getRubrikaByID($rubrika["id_rubrike"]);
                            echo "<h4>$rubrika_info[naziv]</h4>";
                        }
                    } else {
                        echo "<h3>Ovaj urednik nije dodeljen nijednoj rubrici</h3>";
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
?>
