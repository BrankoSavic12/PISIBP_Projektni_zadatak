<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled clanaka na cekanju</title>
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
            <h1>Lista clanaka za odobrenje</h1>
        </div>
            <div class="flex-container">
            
            <form action='pregled_clanci_na_cekanju_urednik.php' method='get' class="search-form">
                <input type='text' name='pretragaNaslov' placeholder='Pretraga' class="search-input">
                <input type='submit' value='Pretraži clanke' class='btn'>
            </form>
            <input type="button" value="Napusti" onclick="window.location.href='naslovna.php'" class="btn">

            </div>
            <?php
        $pretragaNaslov = isset($_GET['pretragaNaslov']) ? $_GET['pretragaNaslov'] : '';
        $pronadjeniClanci = false;

        $rubrike_urednik = $konekcija->getRubrikeByUrednikId($_SESSION["id_korisnika"]);
        if ($rubrike_urednik != false) {
            while ($rubrika_urednik = $rubrike_urednik->fetch_assoc()) {
                $vesti_po_rubrici = $konekcija->getVestiByRubrika($rubrika_urednik["id_rubrike"]);
                while ($vest_po_rubrici = $vesti_po_rubrici->fetch_assoc()) {
                    if ($vest_po_rubrici["status"] == "na čekanju" && (empty($pretragaNaslov) || stripos($vest_po_rubrici['naslov'], $pretragaNaslov) !== false)) {
                        $pronadjeniClanci = true;
                        echo "<div class='clanak-container'>
                            <h3 class='naslov'>Naslov: $vest_po_rubrici[naslov]</h3> 
                            <h3>Datum odobrenja: $vest_po_rubrici[datum_vreme_objave]</h3>
                            <a href=procitaj_clanak.php?id_vesti=$vest_po_rubrici[id_vesti]><button>Pročitaj članak</button></a> 
                            <a href=odobri_clanak.php?id_vesti=$vest_po_rubrici[id_vesti]><button>Odobri članak</button></a>
                            <button onclick=\"brisanjeClanaka($vest_po_rubrici[id_vesti])\">Brisanje članaka</button>
                            </div>";
                    }
                }
            }
        }
        ?>
            

    <script>
        function brisanjeClanaka(id_vesti) {
            var customDialog = document.createElement('div');
            customDialog.className = 'custom-dialog';
            customDialog.innerHTML = `
                <p>Da li ste sigurni da želite da obrišete clanak?</p>
                <button class="confirm-button" onclick="potvrdiBrisanje(${id_vesti})">Potvrdi</button>
                <button class="cancel-button" onclick="ponistiBrisanje()">Poništi</button>
            `;
            document.body.appendChild(customDialog);
        }

        function potvrdiBrisanje(id_vesti) {
            window.location.href = "brisanje_clanci_na_cekanju_urednik.php?id_vesti=" + id_vesti;
            ukloniCustomDialog();
        }

        function ponistiBrisanje() {
            ukloniCustomDialog();
        }

        function ukloniCustomDialog() {
            var customDialog = document.querySelector('.custom-dialog');
            if (customDialog) {
                customDialog.remove();
            }
        }
    </script>
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
