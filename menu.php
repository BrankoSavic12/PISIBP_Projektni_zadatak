<div class="menu">
    <?php
    if (($_SESSION["uloga"]) == 'glavni urednik') {
    ?>
        <h1>Stranica glavnog urednika</h1>
        <div class="sidebar">
            <img src="slike/urednik1.jpg" alt="Zanimljiva slika" class="sidebar-image">
            <h3>Glavni urednik:</h3>
            <h3>Petar Petrović</h3>
            <h3>petar.petrovic@novine.rs</h3>

        </div>

        <div class="menu-section">
            <p>
                <img src="slike/novinari.jpg" alt="Novinari" class="menu-icon">
                "Jedinstvena ekipa, bogata talentima i raznolikošću!
                Upoznajte naš tim novinara i otkrijte širinu njihovih interesovanja i stručnosti."
                <a href="pregled_novinara.php"><button>Pregled</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/urednici.jpg" alt="Urednici" class="menu-icon">
                "Naši urednici - vođe tima, kreativni vizionari i stručnjaci u svojim oblastima.
                Upoznajte ljude koji oblikuju i usmeravaju naš rad."
                <a href="pregled_urednika.php"><button>Pregled</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/rubrike.jpg" alt="Rubrike" class="menu-icon">
                "Raznolika paleta rubrika - istražujemo, informišemo, inspirišemo.
                Otkrijte razne teme i uživajte u šarolikosti našeg novinarskog rada."
                <a href="pregled_rubrika.php"><button>Pregled</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/zahtevi.jpg" alt="Rubrike" class="menu-icon">
                "Naša bogata lepeza članaka pruža raznovrsne teme.Pronađite intrigantne
                i zanimljive priče koje će zadobiti pažnju svakog čitaoca."
                <a href="pregled_zahteva.php"><button>Pregled</button></a>
            </p>
        </div>
        <p class="logout"><a href="logout.php">Logout</a></p>


    <?php  } ?>
    <?php
    if (($_SESSION["uloga"]) == 'novinar') {
    ?>
        <h1>Stranica novinara rubrike</h1>
        <div class="sidebar">
        <div style="display: flex; align-items: center;">
            <img src="slike/Stranica_novinar.jpg" alt="Slika 1" class="sidebar-image" style="width: 200px; height: 180px;">
            <img src="slike/Stranica_novinar1.jpg" alt="Slika 2" class="sidebar-image" style="width: 200px; height: 180px;">
        </div>
    
        <?php
            $rubrike_novinar = $konekcija->getRubrikeByNovinarId($_SESSION["id_korisnika"]);
            $rubrike_nazivi = array();
            while ($rubrika_novinar = $rubrike_novinar->fetch_assoc()) {
                $rubrika = $konekcija->getRubrikaByID($rubrika_novinar["id_rubrike"]);
                $rubrike_nazivi[] = $rubrika['naziv'];
            }
            if (count($rubrike_nazivi) > 0) {
                echo "<h3>Novinar rubrike " . implode(" i ", $rubrike_nazivi) . "</h3>";
            } else {
                echo "<h2>Nemate dodeljenih rubrika</h2>";
            }      
                echo "<h3>$_SESSION[ime_prezime]</h3>";
                echo "<h3>$_SESSION[email]</h3>";
      
        ?>
        </div>
        <div class="menu-section">
   
            <p>
                <img src="slike/novinar_napisi.jpg" alt="Urednici" class="menu-icon">
                " Pisanje novog članka za online novine"
                <a href="napisi_clanak.php"><button>Napiši</button></a>
            </p>
        </div>

        <div>
            <p>
                <img src="slike/novinar_na_cekanju.jpg" alt="Urednici" class="menu-icon">
                "Pregled članaka upućenih na odobrenje"
                <a href="pregled_clanci_na_cekanju.php"><button>Pregled</button></a>
            </p>
        </div>


        <div>
            <p>
                <img src="slike/novinar_odobreni.jpg" alt="Urednici" class="menu-icon">
                " Pregled odobrenih/objavljenih članaka "
                <a href="pregled_odobreni_clanci.php"><button>Pregled</button></a>
                </p>
               
        </div>

        <div>
            <p>
                <img src="slike/novinar_draft.jpg" alt="Urednici" class="menu-icon">
                " Pregled clanaka u radnom/draft stanju "
                <a href="pregled_clanci_draft_stanje.php"><button>Pregled</button></a>
            </p>
               
        </div>

        <div>
            <p>
                <img src="slike/novinar_info.jpg" alt="Urednici" class="menu-icon">
                "Podaci i kontakt email radnika redakcije"
                <a href="informacije_urednici.php"><button>Pregled</button></a>
            </p>
               
        </div>
        

        <p class="logout"><a href="logout.php">Logout</a></p>

    <?php  }
    if (($_SESSION["uloga"]) == 'urednik') {

    ?>
        <h1>Stranica urednika rubrike</h1>
        <div class="sidebar">
        <img src="slike/Novinar.jpg" alt="Zanimljiva slika" class="sidebar-image">
        
        <?php
        $rubrike_urednik = $konekcija->getRubrikeByUrednikId($_SESSION["id_korisnika"]);
        $rubrike_nazivi = array();
        while ($rubrika_urednik = $rubrike_urednik->fetch_assoc()) {
            $rubrika = $konekcija->getRubrikaByID($rubrika_urednik["id_rubrike"]);
            $rubrike_nazivi[] = $rubrika['naziv'];
        }
        if (count($rubrike_nazivi) > 0) {
            echo "<h3>Urednik rubrike " . implode(" i ", $rubrike_nazivi) . "</h3>";
        } else {
            echo "<h2>Nemate dodeljenih rubrika</h2>";
        }      
            echo "<h3>$_SESSION[ime_prezime]</h3>";
            echo "<h3>$_SESSION[email]</h3>";
  
    ?>
    </div>

        <div>
            <p>
                <img src="slike/urednici.jpg" alt="Urednici" class="menu-icon">
                "Svi moji odobreni članci"
                <a href="pregled_odobreni_clanci_urednik.php"><button>Pregled</button></a>
                <?php
                $vesti = $konekcija->getOdovreneVestiByUrednik($_SESSION["id_korisnika"]);
                if ($vesti != false) {
                    while ($vest = $vesti->fetch_assoc()) {
                        echo "<p>$vest[naslov] $vest[datum_vreme_objave] <a href=procitaj_clanak.php?id_vesti=$vest[id_vesti]><button>Pročitaj članak</button></a></p>";
                    }
                } else {
                    echo "<p>Nemate nijednu odobrenu vest</p>";
                }
                ?>

            </p>
        </div>

        <div>
            <p>
                <img src="slike/urednici.jpg" alt="Urednici" class="menu-icon">
                Članci koji čekaju odobrenje
                <?php
                $rubrike_urednik = $konekcija->getRubrikeByUrednikId($_SESSION["id_korisnika"]);
                if ($rubrike_urednik != false) {

                    while ($rubrika_urednik = $rubrike_urednik->fetch_assoc()) {
                        $vesti_po_rubrici = $konekcija->getVestiByRubrika($rubrika_urednik["id_rubrike"]);
                        while ($vest_po_rubrici = $vesti_po_rubrici->fetch_assoc()) {
                            if ($vest_po_rubrici["status"] == "na čekanju") {
                                echo "<p>$vest_po_rubrici[naslov] $vest_po_rubrici[datum_vreme_objave] <a href=procitaj_clanak.php?id_vesti=$vest_po_rubrici[id_vesti]><button>Pročitaj članak</button></a> 
                                <a href=odobri_clanak.php?id_vesti=$vest_po_rubrici[id_vesti]><button>Odobri članak</button></a>
                                
                                </p>";
                            }
                        }
                    }
                } else {
                    echo "<p>Nemate nijednu rubriku</p>";
                }
                ?>

            </p>
        </div>

        <p class="logout"><a href="logout.php">Logout</a></p>
    <?php
    }

    ?>
</div>