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
    <h1 style="padding-bottom: 20px;">Pretraga vesti</h1>
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
                        date_default_timezone_set('Europe/Belgrade');
                        $datum_vreme = date("d.M Y. H:i", strtotime($vest_naslov["datum_vreme_objave"]));
                        $sadrzaj = $vest_naslov["sadrzaj"];
                        $sadrzaj_ispis = string_between_two_string($sadrzaj, "<p>", "</p>");
                
                        echo "<div class='vest'>";
                        echo "<div class='vest_opis'>
                            <a href='vest.php?id_vesti={$vest_naslov["id_vesti"]}'><h2>{$vest_naslov["naslov"]}</h2></a>
              
                            <p>$sadrzaj_ispis</p>
                            <h4>{$datum_vreme}</h4>
                        </div>";
                        echo "<div class='vest_slika'><a href='vest.php?id_vesti={$vest_naslov["id_vesti"]}'><img src='../{$vest_naslov["lead_slika_url"]}' class='lead_slika'></a></div>";
                        echo "</div>";
                    }
                }
                
                $vesti_tagovi = $konekcija->getTagoviBySadrzaj($_POST["termin"]);
                
                if ($vesti_tagovi != false) {
                    $rezultat = 1;
                
                    while ($vest_tag = $vesti_tagovi->fetch_assoc()) {
                        if (!in_array($vest_tag["id_vesti"], $vesti_niz)) {
                            array_push($vesti_niz, $vest_tag["id_vesti"]);
                            $vest_iz_taga = $konekcija->getClanakByID($vest_tag["id_vesti"]);
                
                            date_default_timezone_set('Europe/Belgrade');
                            $datum_vreme_tag = date("d.M Y. H:i", strtotime($vest_iz_taga["datum_vreme_objave"]));
                            $sadrzaj_tag = $vest_iz_taga["sadrzaj"];
                            $sadrzaj_ispis_tag = string_between_two_string($sadrzaj_tag, "<p>", "</p>");
                
                            echo "<div class='vest'>";
                            echo "<div class='vest_opis'>
                                <a href='vest.php?id_vesti={$vest_iz_taga["id_vesti"]}'><h2>{$vest_iz_taga["naslov"]}</h2></a>
                                <p>$sadrzaj_ispis_tag</p>
                                <h4>{$datum_vreme_tag}</h4>
                            </div>";
                            echo "<div class='vest_slika'><a href='vest.php?id_vesti={$vest_iz_taga["id_vesti"]}'><img src='../{$vest_iz_taga["lead_slika_url"]}' class='lead_slika'></a></div>";
                            echo "</div>";
                        
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
                                date_default_timezone_set('Europe/Belgrade');
                                $datum_vreme_datum = date("d.M Y. H:i", strtotime($vest_datum["datum_vreme_objave"]));
                                $sadrzaj_datum = $vest_datum["sadrzaj"];
                                $sadrzaj_ispis_datum = string_between_two_string($sadrzaj_datum, "<p>", "</p>");
                
                                echo "<div class='vest'>";
                                echo "<div class='vest_opis'>
                                    <a href='vest.php?id_vesti={$vest_datum["id_vesti"]}'><h2>{$vest_datum["naslov"]}</h2></a>
                                    <p>$sadrzaj_ispis_datum</p>
                                    <h4>{$datum_vreme_datum}</h4>
                                </div>";
                                echo "<div class='vest_slika'><a href='vest.php?id_vesti={$vest_datum["id_vesti"]}'><img src='../{$vest_datum["lead_slika_url"]}' class='lead_slika'></a></div>";
                                echo "</div>";
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