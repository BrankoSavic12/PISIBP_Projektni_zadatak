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
        <style>
            .clanak-container {
                max-width: 600px;
                margin: 0px auto;
                padding: 5px;
                text-align: center;
            }

            .naslov {
                word-wrap: break-word;
                overflow-wrap: break-word;
            }

            .btn {
                margin-left: 5px;
            }

            .flex-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .search-input {
                width: 110px;
            }
        </style>

    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h1>Lista zahteva za izmene/brisanje</h1>
                </div>
                <div class="flex-container">

                    <form action='pregled_clanci_zhtevi_glavni_urednik.php' method='get' class="search-form">
                        <input type='text' name='pretragaNaslov' placeholder='Pretraga' class="search-input">
                        <input type='submit' value='Pretraži clanke' class='btn'>
                    </form>
                    <input type="button" value="Napusti" onclick="window.location.href='naslovna.php'" class="btn">

                </div>

                <div>

                    <?php
                    $zahtevi = $konekcija->getSviZahtevi();
                    if ($zahtevi != false) {
                        while ($zahtev = $zahtevi->fetch_assoc()) {
                            $vest = $konekcija->getClanakByID($zahtev["id_vesti"]);

                            echo "<div class='clanak-container'>
                                <h3 class='naslov'>Naslov: $vest[naslov]</h3> 
                                <h3>Vrsta zahteva:$zahtev[vrsta]</h3>
                                <div><a href=procitaj_clanak.php?id_vesti=$vest[id_vesti]><button>Pročitaj članak</button></a>
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