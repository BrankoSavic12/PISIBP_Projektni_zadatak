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
            <div>
                <h2>Lista svih rubrika</h2>
                <a href="dodaj_rubriku.php"><button>Dodavanje rubrike</button></a>
                <a href="menu.php"><button>Napusti stranicu</button></a>
                
                <?php
                $rubrike = $konekcija->getSveRubrike();
                if ($rubrike != false) {
                    while ($rubrika = $rubrike->fetch_assoc()) {
                        echo "<div><h3>Naziv rubrike:$rubrika[naziv]</h3>
                        <a href=rubrika_info.php?id_rubrike=$rubrika[id_rubrike]><button>Informacije</button></a>
                        <a href=rubrika_brisanje.php?id_rubrike=$rubrika[id_rubrike]><button>Brisanje</button></a></div>";
                    }
                } else {
                    echo "<p>Nema rubrika u bazi</p>";
                }
                ?>
                
                <!-- Prikazivanje poruke obrisane rubrike (ako postoji) -->
                <?php
                if (isset($_SESSION['obrisi_rubriku_poruka'])) {
                    echo "<p>{$_SESSION['obrisi_rubriku_poruka']}</p>";
                    unset($_SESSION['obrisi_rubriku_poruka']); // Obrisi poruku iz sesije
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
