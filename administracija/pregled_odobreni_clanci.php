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
            <h1>Lista odobrenih clanaka</h1>
        </div>
        <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>
        <div class="info-container" style="width:auto">
            <?php
                
                if (isset($_SESSION['id_korisnika'])) {
                    $novinarId = $_SESSION['id_korisnika'];
                    $clanci = $konekcija->getOdobreneVesti($novinarId);
                }
           
                while ($clanak = $clanci->fetch_assoc()) {
                    echo "<div class='clanak-container' style='text-align:center'>
                        <div class='iznad-dugmica' style='padding: 15px; width:400px'>
                        <h2>Naslov: $clanak[naslov]</h2> 
                        <h2>Datum odobrenja: $clanak[datum_vreme_objave]</h2>
                        <a href='procitaj_clanak?id_vesti=$clanak[id_vesti]'><button>Pročitaj članak</button></a>
                        <a href='posalji_zahtev_za_izmenu?id_vesti=$clanak[id_vesti]&return_page=odobreni_clanci'><button>Zahtev za izmenu</button></a>
                        <a href='posalji_zahtev_za_brisanje?id_vesti=$clanak[id_vesti]&return_page=odobreni_clanci'><button>Zahtev za brisanje</button></a>
                        </div>
                        </div>";
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