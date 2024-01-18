<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled svi odobreni clanci - glavni urednik</title>
        <link rel="stylesheet" href="style.css">

    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h1>Lista objavljenih clanaka</h1>
                </div>
                <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>

                <?php

                $vesti = $konekcija->getVestByStatus("odobrena");
                if ($vesti != false) {
                    while ($vest = $vesti->fetch_assoc()) {
                        echo "<div class='novinar-container' style='width: 400px; text:align:center';>
                                <div class='iznad-dugmica'>
                                <h2>Naslov: $vest[naslov]</h2> 
                                <h2>Odobreno: $vest[datum_vreme_objave]</h2>
                                </div>
                                <div style='text-align:center'>
                                <a href=procitaj_clanak.php?id_vesti=$vest[id_vesti]><button>Pročitaj članak</button></a>
                                <button onclick=\"brisanjeClanaka($vest[id_vesti])\">Brisanje članka</button>
                                </div>
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
                        window.location.href = "brisanje_svi_odobreni_clanci_glavni_urednik.php?id_vesti=" + id_vesti;
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