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
                    <h2>Lista novinara</h2>
                    <a href="registruj_novinara.php"><button>Registruj novinara</button></a>
                    <a href="#"><button>Izađi</button></a>
                    <?php
                    $novinari = $konekcija->getSviNovinari();
                    if ($novinari != false) {
                        while ($novinar = $novinari->fetch_assoc()) {
                            echo "<div> $novinar[ime_prezime] 
                            <a href=novinar_info.php?id_novinara=$novinar[id_korisnika]><button>Info</button></a>  
                            <a href=novinar_azuriranje.php?id_novinara=$novinar[id_korisnika]><button>Ažuriraj novinara</button></a>
                            <a href=novinar_brisanje.php?id_novinara=$novinar[id_korisnika]><button>Obriši novinara</button></a>
                            </div>";
                        }
                    } else {
                        echo "<p>Nema novinara u bazi</p>";
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
