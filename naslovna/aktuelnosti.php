<div class="aktuelne_vesti">
    <h2>Aktuelnosti</h2>
    <?php
    $aktuelne_vesti = $konekcija->getVestIdByTag("aktuelno");
    if ($aktuelne_vesti != false) {
        while ($aktuelna_vest = $aktuelne_vesti->fetch_assoc()) {
            $vest = $konekcija->getClanakByID($aktuelna_vest["id_vesti"]);
            // Provera da li je status vesti "odobrena"
            if ($vest["status"] === "odobrena") {
                $sadrzaj = $vest["sadrzaj"];
                date_default_timezone_set('Europe/Belgrade');
                $datum_vreme = date("d.m.Y. H:i", strtotime($vest["datum_vreme_objave"]));
                $rubrika_vest = $konekcija->getRubrikaByID($vest["id_rubrike"]);
                $rubrika= "$rubrika_vest[naziv]";
                echo "<div class=aktuelna_vest>
                            <div class=aktuelna_vest_slika><a href=vest.php?id_vesti=$vest[id_vesti]><img src=../$vest[lead_slika_url] class=lead_slika></a></div>
                            <a href=vest.php?id_vesti=$vest[id_vesti]><h3>$vest[naslov]</h3></a>
                            <p>$rubrika - $datum_vreme</p>
                        </div>";
            }
        }
    } else {
        echo "<div><h4>Nema aktuelnih vesti</h4></div>";
    }
    ?>
</div>
