<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled clanaka na cekanju:</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content">
        <div>
            <h1>Lista clanaka na cekanju:</h1>
        </div>
        <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>
            <div class="info-container" style="width:auto">
            <?php
                if (isset($_SESSION['id_korisnika'])) {
                    $novinarId = $_SESSION['id_korisnika'];
                    $clanci = $konekcija->getVestiNaCekanju($novinarId);
                    
                    if ($clanci !== false && $clanci->num_rows > 0) {
                        while ($clanak = $clanci->fetch_assoc()) {
                            echo "<div>
                                <div class='iznad-dugmica' style='padding: 15px; width:375px'>
                                <h2>Naslov: $clanak[naslov]</h2> 
                                <h2>Datum: $clanak[datum_vreme_objave]</h2>
                                <a href='procitaj_clanak?id_vesti=$clanak[id_vesti]'><button>Pročitaj</button></a>
                                <a href='izmeni_draft_clanak?id_vesti=$clanak[id_vesti]'><button>Izmeni</button></a>
                                <button onclick=\"brisanjeClanaka($clanak[id_vesti])\">Obrši</button>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<h3>Nema članaka na čekanju.</h3>";
                    }
                }
            
            ?>
    <script>
        function brisanjeClanaka(id_vesti) {
            var customDialog = document.createElement('div');
            customDialog.className = 'custom-dialog';
            customDialog.innerHTML = `
                <h2>Da li ste sigurni da želite da obrišete članak?</h2>
                <button class="confirm-button" onclick="potvrdiBrisanje(${id_vesti})">Potvrdi</button>
                <button class="cancel-button" onclick="ponistiBrisanje()">Poništi</button>
            `;
            document.body.appendChild(customDialog);
        }

        function potvrdiBrisanje(id_vesti) {
            window.location.href = "brisanje_clanaka_na_cekanju.php?id_vesti=" + id_vesti;
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
