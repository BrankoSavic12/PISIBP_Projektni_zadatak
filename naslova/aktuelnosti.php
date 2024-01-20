<div class="aktuelne_vesti">
    <h2>Aktuelnosti</h2>
    <?php
    $aktuelne_vesti = $konekcija->getVestIdByTag("aktuelno");
    if ($aktuelne_vesti != false) {
        while ($aktuelna_vest = $aktuelne_vesti->fetch_assoc()) {
            $vest = $konekcija->getClanakByID($aktuelna_vest["id_vesti"]);
            $sadrzaj = $vest["sadrzaj"];
            $sadrzaj_ispis = string_between_two_string($sadrzaj, "<p>", "</p>");
            date_default_timezone_set('Europe/Belgrade');
            $datum_vreme = date("d.m.Y. H:i", strtotime($vest["datum_vreme_objave"]));

            echo "<div class=aktuelna_vest>
                        <a href=vest.php?id_vesti=$vest[id_vesti]><h3>$vest[naslov]</h3></a>
                        <p>$sadrzaj_ispis</p>
                        <p>$datum_vreme</p>
                            </div>";
        }
    } else {
        echo "<div><h4>Nema aktuelnih vesti</h4></div>";
    }
    ?>

</div>