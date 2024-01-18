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

</head>

<body>

<div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content">
        <div>
            <h1>Lista clanaka za odobrenje</h1>
            </div>
        <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>
        <div class="info-container" style="width:auto">
            <?php
        $rubrike_urednik = $konekcija->getRubrikeByUrednikId($_SESSION["id_korisnika"]);
        if ($rubrike_urednik != false) {
            while ($rubrika_urednik = $rubrike_urednik->fetch_assoc()) {
                $vesti_po_rubrici = $konekcija->getVestiByRubrika($rubrika_urednik["id_rubrike"]);
                while ($vest_po_rubrici = $vesti_po_rubrici->fetch_assoc()) {
                    if ($vest_po_rubrici["status"] == "na čekanju" && (empty($pretragaNaslov) || stripos($vest_po_rubrici['naslov'], $pretragaNaslov) !== false)) {
                        $pronadjeniClanci = true;
                        echo "<div class='clanak-container'>
                            <div class='iznad-dugmica' style='padding: 15px; width:375px'>
                            <h2 class='naslov'>Naslov: $vest_po_rubrici[naslov]</h2> 
                            <h2>Datum slanja: $vest_po_rubrici[datum_vreme_objave]</h2>
                            <a href=procitaj_clanak.php?id_vesti=$vest_po_rubrici[id_vesti]><button>Pročitaj članak</button></a> 
                            <a href=odobri_clanak.php?id_vesti=$vest_po_rubrici[id_vesti]><button>Odobri članak</button></a>
                            <button onclick=\"brisanjeClanaka($vest_po_rubrici[id_vesti])\">Brisanje članaka</button>
                            </div>
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
                <h2>Da li ste sigurni da želite da obrišete clanak?</h2>
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