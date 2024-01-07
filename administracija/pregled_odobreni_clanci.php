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
    .btn{
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
            <h1>Lista odobrenih clanaka</h1>
        </div>
        <div class="flex-container">
            
        <form action='pregled_odobreni_clanci.php' method='get' class="search-form">
            <input type='text' name='pretragaNaslov' placeholder='Pretraga po naslovu' class="search-input">
            <input type='submit' value='Pretraži clanke' class='btn'>
        </form>
        <input type="button" value="Napusti" onclick="window.location.href='naslovna.php'" class="btn">

        </div>
        
        <div>
           
            <?php
                
                if (isset($_GET['pretragaNaslov'])) {
                    $pretragaNaslov = $_GET['pretragaNaslov'];
                    $novinarId = isset($_SESSION['id_korisnika']) ? $_SESSION['id_korisnika'] : 0; // Postavi default vrednost na 0 ili prilagodi prema potrebi
                    $clanci = $konekcija->pretraziOdobreneClankePoNaslovu($pretragaNaslov, $novinarId);
                } else {
                    $novinarId = isset($_SESSION['id_korisnika']) ? $_SESSION['id_korisnika'] : 0; // Postavi default vrednost na 0 ili prilagodi prema potrebi
                    $clanci = $konekcija->getOdobreneVesti($novinarId);
                }
                
                if ($clanci != false) {
                    while ($clanak = $clanci->fetch_assoc()) {
                        echo "<div class='clanak-container'>
                        <h3 class='naslov'>Naslov: $clanak[naslov]</h3> 
                        <h3>Datum odobrenja: $clanak[datum_vreme_objave]</h3>
                        <a href='procitaj_clanak?id_vesti=$clanak[id_vesti]'><button>Pročitaj clanak</button></a>
                        <a href='posalji_zahtev_za_izmenu?id_vesti=$clanak[id_vesti]'><button>Zahtev za izmenu</button></a>
                        <a href='posalji_zahtev_za_brisanje?id_vesti=$clanak[id_vesti]'><button>Zahtev za brisanje</button></a>
                    </div>";
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
