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
                    <h1>Lista svih urednika rubrika</h1>
                    <a href="registruj_urednika.php"><button>Registracija urednika</button></a>
                    <a href="naslovna.php"><button>Napusti stranicu</button></a>
                    <?php
                    $urednici = $konekcija->getSviUrednici();
                    if ($urednici != false) {
                        while ($urednik = $urednici->fetch_assoc()) {
                            echo "<div><h3>Urednik:$urednik[ime_prezime]</h3>
                            <a href=urednik_info.php?id_urednika=$urednik[id_korisnika]><button>Informacije</button></a>  
                            <a href=urednik_azuriranje.php?id_urednika=$urednik[id_korisnika]><button>Ažuriranje</button></a>
                            <button onclick=\"brisanjeUrednika({$urednik['id_korisnika']})\">Brisanje</button>
                            </div>";
                        }
                } else {
                    echo "<p>Nema urednika u bazi</p>";
                }
                ?>
            </div>
        </div>
    </div>

        <script>
            function brisanjeUrednika(id_urednika) {
                var customDialog = document.createElement('div');
                customDialog.className = 'custom-dialog';
                customDialog.innerHTML = `
                    <p>Da li ste sigurni da želite da obrišete urednika?</p>
                    <button class="confirm-button" onclick="potvrdiBrisanje(${id_urednika})">Potvrdi</button>
                    <button class="cancel-button" onclick="ponistiBrisanje()">Poništi</button>`;
                document.body.appendChild(customDialog);
            }

            function potvrdiBrisanje(id_urednika) {
                window.location.href = "urednik_brisanje.php?id_urednika=" + id_urednika;
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
    </body>
    </html>
<?php
} else {
    header("location:index.php");
}
?>
