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
                "Nas tim novinara - jedinstvena ekipa, bogata talentima i raznolikošću!
                Upoznajte sve članove našeg tima novinara i otkrijte širinu njihovih interesovanja i stručnosti."
                <a href="pregled_novinara.php"><button>Pregled</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/urednici.jpg" alt="Urednici" class="menu-icon">
                "Nasi urednici - vođe tima, kreativni vizionari i stručnjaci u svojim oblastima.
                Upoznajte ljude koji oblikuju i usmeravaju naš rad."
                <a href="pregled_urednika.php"><button>Pregled</button></a>
            </p>
        </div>

        <div class="menu-section">
            <p>
                <img src="slike/rubrike.jpg" alt="Rubrike" class="menu-icon">
                "Naša raznolika paleta rubrika - istražujemo, informišemo, inspirišemo
                Otkrijte teme koje pokrivamo i uživajte u šarolikosti našeg novinarskog rada.
                <a href="pregled_rubrika.php"><button>Pregled</button></a>
            </p>
        </div>

        <p class="logout"><a href="logout.php">Logout</a></p>

    <?php  } ?>

    <?php
    if (($_SESSION["uloga"]) == 'novinar') {
    ?>
        <div class="menu-section">
            <p>
                <img src="slike/urednici.jpg" alt="Urednici" class="menu-icon">
                "Nasi urednici - vođe tima, kreativni vizionari i stručnjaci u svojim oblastima.
                Upoznajte ljude koji oblikuju i usmeravaju naš rad."
                <a href="napisi_clanak.php"><button>Napisi clanak</button></a>
            </p>
        </div>

        <p class="logout"><a href="logout.php">Logout</a></p>

    <?php  } ?>
</div>