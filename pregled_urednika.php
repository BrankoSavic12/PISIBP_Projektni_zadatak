<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled urednika</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h2>Lista svih urednika rubrika</h2>
                    <a href="registruj_urednika.php"><button>Registracija urednika</button></a>
                    <a href="menu.php"><button>Napusti stranicu</button></a>
                    <?php
                    $urednici = $konekcija->getSviUrednici();
                    if ($urednici != false) {
                        while ($urednik = $urednici->fetch_assoc()) {
                            echo "<div><h3>Urednik:$urednik[ime_prezime]</h3>
                            <a href=urednik_info.php?id_urednika=$urednik[id_korisnika]><button>Informacije</button></a>  
                            <a href=urednik_azuriranje.php?id_urednika=$urednik[id_korisnika]><button>Ažuriranje</button></a>
                            <a href=urednik_brisanje.php?id_urednika=$urednik[id_korisnika]><button>Brisanje</button></a>
                            </div>";
                        }
                    } else {
                        echo "<p>Nema urednika u bazi</p>";
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
