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
                echo "<div>";
                echo "<h3>Glavni urednik redakcije:</h3>";
                echo "<h3>$glavniUrednik[ime_prezime]</h3>";
                echo "<h3>$glavniUrednik[email]</h3>";
                echo "</div>";
            }
    ?>
            <a href="azuriranje_glavni_urednik.php"><button style="margin-top: 10px;">Uredi profil</button></a>
            <a href="../naslovna"><button style="margin-top: 10px;">Logout</button></a>
            
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

        <div class="menu-section">
            <p>
                <img src="slike/svi.jpg" alt="Rubrike" class="menu-icon">
                "Dobrodošli u prostor gde se naše priče stapaju s istraživanjem,
                informacije plešu s radoznalošću, a inspiracija nikada ne miruje
                donoseći šarm i dubinu."
                <a href="pregled_svi_odobreni_clanci_glavni_urednik.php"><button>Objavljeni članci</button></a>
            </p>
        </div>
    <?php  } ?>



    <?php
    if (($_SESSION["uloga"]) == 'novinar') {
    ?>
        <div style="font-weight: bold;";><h1>Stranica novinara rubrike</h1></div>
        <div class="sidebar">
            <div style="display: flex; justify-content: center;">
                <img src="slike/novinar_stranica1.jpg" alt="Slika 2" class="sidebar-image1">
            </div>
            <div>
            <?php
            $rubrike_novinar = $konekcija->getRubrikeByNovinarId($_SESSION["id_korisnika"]);
            $rubrike_nazivi = array();
            while ($rubrika_novinar = $rubrike_novinar->fetch_assoc()) {
                $rubrika = $konekcija->getRubrikaByID($rubrika_novinar["id_rubrike"]);
                $rubrike_nazivi[] = $rubrika['naziv'];
            }
            
            if (count($rubrike_nazivi) > 0) {
                echo "<h3> Novinar rubrike " . implode(" i ", $rubrike_nazivi) . "</h3>";
            } else {
                echo "<h3>Nemate dodeljenih rubrika</h3>";
            }
            echo "<h3>$_SESSION[ime_prezime]</h3>";
            echo "<h3>$_SESSION[email]</h3>";
            
            
            ?>
            </div>
        </div>
    
        <div class="novinar-container">

            <p>
                <img src="slike/novinar_napisi.jpg" alt="Urednici" class="menu-icon" style="text-align: center;">
                "Rečima stvaramo most između nas autora i vas čitalaca."
                <a href="napisi_clanak.php"><button>Napiši</button></a>
            </p>
        </div>
        <div class="novinar-container">

            <p>
                <img src="slike/na_cekanju.jpg" alt="Urednici" class="menu-icon">
                " Donosimo priče koje čekaju da obogate umove čitalaca."
                <a href="pregled_clanci_na_cekanju.php"><button>Poslano</button></a>
            </p>
        </div>

        <div class="novinar-container">
            <p>
                <img src="slike/novinar_odobreni.jpg" alt="Urednici" class="menu-icon">
                " Pregled članaka koji su ipisivali priče i očaravali čitaoce."
                <a href="pregled_odobreni_clanci.php"><button>Odobreno</button></a>
            </p>

        </div>

        <div class="novinar-container">
            <p>
                <img src="slike/novinar_draft.jpg" alt="Urednici" class="menu-icon">
                "Spisak draft stanja, pregled reči dok još oblikuju svoj put."
                <a href="pregled_clanci_draft_stanje.php"><button>Draft</button></a>
            </p>

        </div>

        <div class="novinar-container">
            <p>
                <img src="slike/novinar_info1.jpg" alt="Urednici" class="menu-icon">
                "Pregled umetnika koji kreiraju svet svojim toplim izrazom"
                <a href="informacije_urednici.php"><button>Informacije</button></a>
            </p>

        </div>

        <h2 style="font-size: 25px;"><a href="../naslovna" class="back-link" style="padding-left: 10px">Logout</a></h2>


        

    <?php  }
    if (($_SESSION["uloga"]) == 'urednik') {

    ?>
        <h1>Stranica urednika rubrike</h1>
        <div class="sidebar">
            <div style="display: flex; justify-content: center;">
                <img src="slike/stranica_urednik4.jpg" alt="Slika 2" class="sidebar-image1">
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

        <div class="novinar-container">
            <p>
                <img src="slike/novinar_odobreni.jpg" alt="Urednici" class="menu-icon">
                " Pregled članaka koji su ipisivali priče i očaravali čitaoce."
                <a href="pregled_odobreni_clanci_urednik.php"><button>Odobreni</button></a>
            </p>
        </div>

        <div class="novinar-container">
            <p>
                <img src="slike/na_cekanju.jpg" alt="Urednici" class="menu-icon">
                "Članci na čekanju, pregled reči dok još oblikuju svoj put."
                <a href="pregled_clanci_na_cekanju_urednik.php"><button>Na čekanju</button></a>
            </p>
        </div>

        <div class="novinar-container">
            <p>
                <img src="slike/izmene2.jpg" alt="Urednici" class="menu-icon">
                " Pazljivo biramo, jer rečima stvaramo vezu sa čitaocima."
                <a href="pregled_clanci_zahtevi.php"><button>Zahtevi</button></a>
            </p>
        </div>

        <div class="novinar-container">
            <p>
                <img src="slike/novinar_info1.jpg" alt="Urednici" class="menu-icon">
                "Pregled umetnika koji kreiraju svet svojim toplim izrazom"
                <a href="informacije_urednici.php"><button>Informacije</button></a>
            </p>
        </div>
        <h2 style="font-size: 25px;"><a href="../naslovna" class="back-link" style="padding-left: 10px">Logout</a></h2>

    <?php
    }

    ?>
</div>