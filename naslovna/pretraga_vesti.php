<?php
include "../administracija/klase.php";
include "funkcije.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najnovije vesti</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "menu.php";
    ?>

    <section class="main">

        <div class="container container_main">
            <div class="glavne_vesti">
                <h1>Pretraga vesti</h1>
                <?php
                if (!empty($_POST["termin"]) || !empty($_POST["datum"])) {
                    $rezultat = 0;
                    $vesti_niz = array();
                    if (!empty($_POST["termin"])) {
                        $vesti_naslov = $konekcija->pretragaVestiNaslov($_POST["termin"]);

                        if ($vesti_naslov != false) {
                            $rezultat = 1;
                            while ($vest_naslov = $vesti_naslov->fetch_assoc()) {
                                array_push($vesti_niz, $vest_naslov["id_vesti"]);
                                echo "<h3><a href=vest.php?id_vesti=$vest_naslov[id_vesti]>$vest_naslov[naslov]</a></h3>";
                            }
                        }

                        $vesti_tagovi = $konekcija->getTagoviBySadrzaj($_POST["termin"]);

                        if ($vesti_tagovi != false) {
                            $rezultat = 1;

                            while ($vest_tag = $vesti_tagovi->fetch_assoc()) {

                                if (!in_array($vest_tag["id_vesti"], $vesti_niz)) {
                                    array_push($vesti_niz, $vest_tag["id_vesti"]);
                                    $vest_iz_taga = $konekcija->getClanakByID($vest_tag["id_vesti"]);
                                    echo "<h3><a href=vest.php?id_vesti=$vest_iz_taga[id_vesti]>$vest_iz_taga[naslov]</a></h3>";
                                }
                            }
                        }
                    }

                    if (!empty($_POST["datum"])) {
                        $vesti_datum = $konekcija->pretragaVestiDatum($_POST["datum"]);
                        if ($vesti_datum != false) {
                            $rezultat = 1;
                            while ($vest_datum = $vesti_datum->fetch_assoc()) {
                                if (!in_array($vest_datum["id_vesti"], $vesti_niz)) {
                                    array_push($vesti_niz, $vest_datum["id_vesti"]);
                                    echo "<h3><a href=vest.php?id_vesti=$vest_datum[id_vesti]>$vest_datum[naslov]</a></h3>";
                                }
                            }
                        }
                    }


                    if ($rezultat == 0) {
                        echo "<p>Nema rezultata pretrage</p>";
                    }
                } else {
                    echo "<p>Niste uneli termin za pretragu</p>";
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