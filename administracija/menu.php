<div class="menu">
    <?php
    if (($_SESSION["uloga"]) == 'glavni urednik') {
    ?>
    <h1>Stranica glavnog urednika</h1>
        <footer>
        <div class="sidebar" style=" margin-left: auto;margin-right: auto;">
            <img src="slike/urednik1.jpg" alt="Zanimljiva slika" class="sidebar-image">
            <?php
            $glavniUrednici = $konekcija->getGlavniUrednik();
            while ($glavniUrednik = $glavniUrednici->fetch_assoc()) {
                echo "<div class='urednik-info'>";
                echo "<h3>Glavni urednik redakcije:</h3>";
                echo "<h3>$glavniUrednik[ime_prezime]</h3>";
                echo "<h3>$glavniUrednik[email]</h3>";
                echo "</div>";
            }
    ?>
            <a href="azuriranje_glavni_urednik.php"><button style="margin-top: 10px;">Uredi profil</button></a>
            <a href="logout.php"><button style="margin-top: 10px;">Logout</button></a>
            
        </div>

    
        <div class="menu-section">
            <p>
                <img src="slike/novinari1.jpg" alt="Novinari" class="menu-icon" >
                
                "Upoznajte našu izuzetnu ekipu, spoj različitih talenata i bogatstva raznolikosti!
                Dobrodošli u fascinantan svet novinarstva koji gradimo zajedno!"
                <a href="pregled_novinara.php"><button>Pregled novinara</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/stranica_urednik1.jpg" alt="Urednici" class="menu-icon">
                "Upoznajte vođe tima - izuzetne vizionare i stručnjake.
                Otkrijte osobe koje kreativno oblikuju, inspirišu i usmjeravaju naš rad ka izvanrednosti!"
                <a href="pregled_urednika.php"><button>Pregled urednika</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/rubrike1.jpg" alt="Rubrike" class="menu-icon">
                "Uplovljavamo u raznovrsni svet rubrika - istražujemo, pružamo informacije, i inspirišemo.
                Informišite se i uživajte u raznolikosti našeg novinarskog rada."
                <a href="pregled_rubrika.php"><button>Pregled rubrika</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/zahtevi1.jpg" alt="Zahtevi" class="menu-icon">
                "Studiozno pristupamo obradi zahteva, pružajući temeljnu analizu
                kako bismo osigurali da svaki odobreni zahtev odražava našu profesionalnost."
                <a href="pregled_clanci_na_cekanju_glavni_urednik.php"><button>Zahtevi za odobrenje</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/izmene1.jpg" alt="Rubrike" class="menu-icon">
                
                "Sa pažnjom i efikasnošću rukujemo zahtevima za izmenu i brisanje
                kako bismo osigurali da svaka promena odražava posvećenost kvalitetu."
                <a href="pregled_clanci_zahtevi_glavni_urednik.php"><button>Zahtevi za izmene</button></a>
            </p>
        </div>
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
            <div style="display: flex; align-items: center;">
                <img src="slike/Stranica_urednik1.jpg" alt="Slika 1" class="sidebar-image" style="width: 200px; height: 180px;">
                <img src="slike/Stranica_urednik.jpg" alt="Slika 2" class="sidebar-image" style="width: 200px; height: 180px;">
            </div>

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
                <img src="slike/novinar_odobreni.jpg" alt="Urednici" class="menu-icon">
                " Pregled odobrenih/objavljenih članaka "
                <a href="pregled_odobreni_clanci_urednik.php"><button>Pregled</button></a>
            </p>
        </div>

        <div>
            <p>
                <img src="slike/novinar_na_cekanju.jpg" alt="Urednici" class="menu-icon">
                " Pregled članaka koji čekaju odobrenje "
                <a href="pregled_clanci_na_cekanju_urednik.php"><button>Pregled</button></a>
            </p>
        </div>

        <div>
            <p>
                <img src="slike/izmene.jpg" alt="Urednici" class="menu-icon">
                " Pregled zahteva za menjanje i brisanje "
                <a href="pregled_clanci_zahtevi.php"><button>Pregled</button></a>
            </p>
        </div>

        <div>
            <p>
                <img src="slike/novinar_info.jpg" alt="Urednici" class="menu-icon">
                "Podaci i kontakt email radnika redakcije "
                <a href="informacije_urednici.php"><button>Pregled</button></a>
            </p>

        </div>

        <p class="logout"><a href="logout.php">Logout</a></p>
    <?php
    }

    ?>
</div>