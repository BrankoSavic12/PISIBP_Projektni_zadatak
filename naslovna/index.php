<?php
include "../administracija/klase.php";
include "funkcije.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naslovna strana</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "menu.php";
    ?>

    <section class="main">
    <div class="container container_main">
    <div class="glavne_vesti">
    <h1 class="logo">
        <span>Dobro došli na </span>
        <span style="font-family: Algerian;">ONLINE METEOR!</span>
    </h1>

        <?php
        $vesti_po_rubrikama = $konekcija->getSveOdobreneVestiPoRubrikama();
        if ($vesti_po_rubrikama !== false) {
            foreach ($vesti_po_rubrikama as $rubrika => $vesti) {
                echo "<h3>$rubrika</h3>";

                foreach ($vesti as $vest) {
                    date_default_timezone_set('Europe/Belgrade');
                    $datum_vreme = date("d.M Y. H:i", strtotime($vest["datum_vreme_objave"]));
                    $sadrzaj = $vest["sadrzaj"];
                    $sadrzaj_ispis = string_between_two_string($sadrzaj, "<p>", "</p>");

                    echo "<div class=vest>";
                    echo "<div class=vest_opis>
                        <a href=vest.php?id_vesti=$vest[id_vesti]><h2>$vest[naslov]</h2></a>
                        <p>$sadrzaj_ispis</p>
                        <h4>$rubrika - $datum_vreme</h4>
                    </div>";
                    echo "<div class=vest_slika><a href=vest.php?id_vesti=$vest[id_vesti]><img src=../$vest[lead_slika_url] class=lead_slika></a></div>";
                    echo "</div>";
                }
            }
        } else {
            echo "<p>Trenutno nema odobrenih vesti.</p>";
        }
        ?>
            </div>
            <?php
            include "aktuelnosti.php";
            ?>
        </div>
    </section>
</body>

</html>