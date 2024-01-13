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
                    $urednikId = $_SESSION['id_korisnika'];
                    $clanci = $konekcija->getOdobreneVestiUrednika($urednikId);
                 }
                if ($clanci != false) {
                    while ($clanak = $clanci->fetch_assoc()) {
                        echo "<div class='clanak-container'>
                        <h2 class='naslov'>Naslov: $clanak[naslov]</h2> 
                        <h2>Datum odobrenja: $clanak[datum_vreme_objave]</h2>
                        <a href='procitaj_clanak?id_vesti=$clanak[id_vesti]'><button>Pročitaj članak</button></a>
                        <button onclick=\"brisanjeClanaka($clanak[id_vesti])\">Brisanje članaka</button>
                    </div>";
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
            window.location.href = "brisanje_odobreni_clanci_urednik.php?id_vesti=" + id_vesti;
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