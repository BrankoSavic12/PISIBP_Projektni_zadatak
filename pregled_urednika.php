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
                    <h2>Lista urednika</h2>
                    <a href="registruj_urednika.php"><button>Registruj urednika</button></a>
                    <a href="#"><button>Izađi</button></a>
                    <?php
                    $urednici = $konekcija->getSviUrednici();
                    if ($urednici != false) {
                        while ($urednik = $urednici->fetch_assoc()) {
                            echo "<div> $urednik[ime_prezime] 
                            <a href=urednik_info.php?id_urednika=$urednik[id_korisnika]><button>Info</button></a>  
                            <a href=urednik_azuriranje.php?id_urednika=$urednik[id_korisnika]><button>Ažuriraj urednika</button></a>
                            <a href=urednik_brisanje.php?id_urednika=$urednik[id_korisnika]><button>Obriši urednika</button></a>
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
