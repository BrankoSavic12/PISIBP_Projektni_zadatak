<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled rubrika</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="navigacija">
        <?php include "menu.php" ?>
        <div class="content">
                <div><h1>Lista dostupnih rubrika:</h1></div>
                
                <div >
                <a href="dodaj_rubriku.php"><button>Dodavanje rubrike</button></a>
                <a href="naslovna.php"><button>Napusti stranicu</button></a>
                </div>
              

                <?php
                $rubrike = $konekcija->getSveRubrike();
                if ($rubrike != false) {
                    while ($rubrika = $rubrike->fetch_assoc()) {
                        echo "<div class='novinar-container' style='width: 250px;'><h2>Naziv rubrike:$rubrika[naziv]</h2>
                        <a href=rubrika_info.php?id_rubrike=$rubrika[id_rubrike]><button>Informacije</button></a>
                        <button onclick=\"brisanjeRubrike({$rubrika['id_rubrike']})\">Brisanje</button></div>";
                    }
                } else {
                    echo "<p>Nema rubrika u bazi</p>";
                }
                ?>
                <?php
                if (isset($_SESSION['obrisi_rubriku_poruka'])) {
                    echo "<p>{$_SESSION['obrisi_rubriku_poruka']}</p>";
                    unset($_SESSION['obrisi_rubriku_poruka']); // Obrisi poruku iz sesije
                }
                ?>

            </div>
        </div>
    </div>
    <script>
        function brisanjeRubrike(id_rubrike) {
            var customDialog = document.createElement('div');
            customDialog.className = 'custom-dialog';
            customDialog.innerHTML = `
                <h3>Da li ste sigurni da želite da obrišete rubriku?</h3>
                <button class="confirm-button" onclick="potvrdiBrisanje(${id_rubrike})">Potvrdi</button>
                <button class="cancel-button" onclick="ponistiBrisanje()">Poništi</button>`;
            document.body.appendChild(customDialog);
        }

        function potvrdiBrisanje(id_rubrike) {
            window.location.href = "rubrika_brisanje.php?id_rubrike=" + id_rubrike;
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
