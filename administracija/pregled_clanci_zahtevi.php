<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled odobrenih clanaka</title>
        <link rel="stylesheet" href="style.css">

    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h1>Lista zahteva za izmenu</h1>
                </div>
                <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>
                <div class="info-container" style="width:auto">

                <div>

                    <?php
                    $rubrike = $konekcija->getRubrikeByUrednikId($_SESSION["id_korisnika"]);
                    if ($rubrike != false) {
                        while ($rubrika = $rubrike->fetch_assoc()) {
                            $vesti_zahtevi = $konekcija->getZahteviByRubrika($rubrika["id_rubrike"]);
                            if ($vesti_zahtevi != false) {
                                while ($vest_zahtev = $vesti_zahtevi->fetch_assoc()) {

                                    $vest = $konekcija->getClanakByID($vest_zahtev["id_vesti"]);

                                    echo "<div class='clanak-container'>
                                    <div class='iznad-dugmica' style='padding: 15px; width:375px'>
                                    <h2 class='naslov'>Naslov: $vest[naslov]</h2> 
                                    <h2>Vrsta zahteva:$vest_zahtev[vrsta]</h2>
                                    <a href=procitaj_clanak.php?id_vesti=$vest[id_vesti]><button>Pročitaj članak</button></a>
                                    <a href=prihvati_zahtev.php?id_vesti=$vest[id_vesti]&zahtev=$vest_zahtev[vrsta]&id_zahteva=$vest_zahtev[id_zahteva]><button>Prihvatanje zahteva</button></a>
                                    <a href=odbijanje_zahteva.php?id_zahteva=$vest_zahtev[id_zahteva]><button>Odbijanje zahteva</button></a>
                                    </div>
                                    </div>";
                                 
                                }
                            }
                        }
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