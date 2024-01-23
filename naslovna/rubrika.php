<?php
include "../administracija/klase.php";
include "funkcije.php";
$rubrika_id_ulaz = $_GET["id_rubrike"];
$rubrika_info = $konekcija->getRubrikaByID($rubrika_id_ulaz);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        echo $rubrika_info["naziv"];
        ?>
    </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "menu.php";
    ?>

    <section class="main">

        <div class="container container_main">
            <div class="glavne_vesti">
                <?php
                echo "<h1 style='padding-bottom: 20px;'>$rubrika_info[naziv]</h1>";
                $sve_vesti = $konekcija->getVestiByRubrika($rubrika_id_ulaz);
                if ($sve_vesti != false) {
                    while ($vest = $sve_vesti->fetch_assoc()) {
                        date_default_timezone_set('Europe/Belgrade');
                        $datum_vreme = date("d.M Y. H:i", strtotime($vest["datum_vreme_objave"]));
                        $sadrzaj = $vest["sadrzaj"];
                        $sadrzaj_ispis = string_between_two_string($sadrzaj, "<p>", "</p>");
                        $rubrika_vest = $konekcija->getRubrikaByID($vest["id_rubrike"]);
                        $rubrika = "$rubrika_vest[naziv]";
                        echo "<div class=vest>";
                        echo "<div class=vest_opis>
                <a href=vest.php?id_vesti=$vest[id_vesti]><h2>$vest[naslov]</h2></a>
                <p>$sadrzaj_ispis</p>
                <h4>$rubrika - $datum_vreme</h4>
                </div>";
                        echo "<div class=vest_slika><a href=vest.php?id_vesti=$vest[id_vesti]><img src=../$vest[lead_slika_url] class=lead_slika></a></div>";

                        echo "</div>";
                    }
                } else {
                    echo "<h3>Nema vesti iz ove rubrike</h3>";
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