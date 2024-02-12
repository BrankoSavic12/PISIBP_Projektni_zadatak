<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled zahteva za izmene</title>
        <link rel="stylesheet" href="style.css">


    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h1>Lista zahteva za izmene ili brisanje</h1>
                </div>
                <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>

                <div>

                    <?php
                    $zahtevi = $konekcija->getSviZahtevi();
                    if ($zahtevi != false) {
                        while ($zahtev = $zahtevi->fetch_assoc()) {
                            $vest = $konekcija->getClanakByID($zahtev["id_vesti"]);

                            echo "<div class='novinar-container' style='text-align:center; width:400px'>
                                <div class='iznad-dugmica'>
                                <h2>Naslov: $vest[naslov]</h2> 
                                <h2>Vrsta zahteva:$zahtev[vrsta]</h2>
                                </div>
                                <a href=procitaj_clanak.php?id_vesti=$vest[id_vesti]><button>Pročitaj članak</button></a>
                                <a href=prihvati_zahtev.php?id_vesti=$vest[id_vesti]&zahtev=$zahtev[vrsta]&id_zahteva=$zahtev[id_zahteva]><button>Prihvatanje zahtev</button></a>
                                <a href=odbijanje_zahteva.php?id_zahteva=$zahtev[id_zahteva]><button>Odbijanje zahteva</button></a></div>";
                          
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