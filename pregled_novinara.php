<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled novinara</title>
        <link rel="stylesheet" href="style.css">


    </head>

    <body>

    <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h1>Lista svih novinara rubrika</h1>
                    <a href="registruj_novinara.php"><button>Registracija novinara</button></a>
                    <a href="naslovna.php"><button>Napusti stranicu</button></a>
                    <?php
                    $novinari = $konekcija->getSviNovinari();
                    if ($novinari != false) {
                        while ($novinar = $novinari->fetch_assoc()) {
                            $id_novinara = $novinar['id_korisnika'];
                            echo "<div>
                                    <h3> Novinar: $novinar[ime_prezime]</h3>
                                    <a href=novinar_info.php?id_novinara=$id_novinara><button>Informacije</button></a>  
                                    <a href=novinar_azuriranje.php?id_novinara=$id_novinara><button>Ažuriranje</button></a>
                                    <button onclick=\"brisanjeNovinara($id_novinara)\">Brisanje</button>
                                </div>";
                        }
                    } else {
                        echo "<p>Nema novinara u bazi</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <script>
            function brisanjeNovinara(id_novinara) {
                var customDialog = document.createElement('div');
                customDialog.className = 'custom-dialog';
                customDialog.innerHTML = `
                    <p>Da li ste sigurni da želite da obrišete novinara?</p>
                    <button class="confirm-button" onclick="potvrdiBrisanje(${id_novinara})">Potvrdi</button>
                    <button class="cancel-button" onclick="ponistiBrisanje()">Poništi</button>
                `;
                document.body.appendChild(customDialog);
            }

            function potvrdiBrisanje(id_novinara) {
                window.location.href = "novinar_brisanje.php?id_novinara=" + id_novinara;
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