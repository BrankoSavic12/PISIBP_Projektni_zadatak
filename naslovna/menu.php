<section class="wrapper_gore">
    <div class="container">
        <div class="top-header">
            
            <div class="top-header-levo">
                <h3><?php
                date_default_timezone_set('Europe/Belgrade');
                echo date("d.M Y. H:i"); ?></h3>
                <p class="logo">ONLINE NOVINE</p>
            </div>

            <div class="top-header-desno">
                <h3>Uloguj se : <button>Login</button></h3>
                <form action="">
                    <input type="search" placeholder="pretraga">
                    <input type="submit" value="Pretraži">
                </form>
            </div>
        </div>
        <div class="navigacija">
            <ul>
                <li><a href="index.php">Naslovna</a></li>
                <?php
                $rubrike = $konekcija->getSveRubrike();
                while ($rubrika = $rubrike->fetch_assoc()) {
                    echo "<li><a href=rubrika.php?id_rubrike=$rubrika[id_rubrike]>$rubrika[naziv]</a></li>";
                }
                ?>
                <li><a href="najnovije_vesti.php">Najnovije vesti</a></li>
            </ul>
        </div>
    </div>
</section>