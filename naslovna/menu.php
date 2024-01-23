<?php


if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $korisnik = $konekcija->getKorisnik($username, $password);
    if ($korisnik !=  false) {
        echo ("ok");
        $_SESSION["id_korisnika"] = $korisnik["id_korisnika"];
        $_SESSION["uloga"] = $korisnik["uloga"];
        $_SESSION["ime_prezime"] = $korisnik["ime_prezime"];
        $_SESSION["email"] = $korisnik["email"];
        header("location:../administracija/naslovna.php");
    } else {
        $greska = "Pogrešno uneto korisničko ime ili lozinka!";
    }
}
?>


<section class="wrapper_gore">
    <div class="container">
        <div class="top-header">

            <div class="top-header-levo">
                <h3><?php
                    date_default_timezone_set('Europe/Belgrade');
                    echo date("d.M Y. H:i"); ?></h3>
                <p class="logo" style="font-family: Algerian;"> ONLINE METEOR</p>
            </div>

            <div class="top-header-desno">
                <h3>Uloguj se : <button class="show-modal">Login</button></h3>
                <form action="pretraga_vesti.php" method="post">
                    <input type="search" placeholder="pretraga" name="termin">
                    <input type="date" name="datum">
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


<div class="modal hidden">

<button class="close-modal">&times;</button>
<form action="" method="post" class="modal-form">
    <h1>Prijavite se:</h1>
    <div class="form-group">
        <h2><label for="username">Korisničko ime:</label></h2>
        <input type="text" name="username" id="username" placeholder="Unesi korisničko ime" required>
    </div>
    <div class="form-group">
        <h2><label for="password">Lozinka:</label></h2>
        <input type="password" name="password" id="password" placeholder="Unesi lozinku" required>
    </div>
    <label class="error-message"><?php if (isset($greska)) echo $greska; ?></label>
    <input type="submit" value="Ulogujte se" name="submit">
</form>


    </form>

    </form>
</div>
<div class="overlay hidden"></div>

<script>
    const modal = document.querySelector('.modal');
    const overlay = document.querySelector('.overlay');
    const btnCloseModal = document.querySelector('.close-modal');
    const btnsOpenModal = document.querySelectorAll('.show-modal');
    const submit = document.getElementById("submit");

    const openModal = function() {
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
    };

    const closeModal = function() {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    };

    for (let i = 0; i < btnsOpenModal.length; i++)
        btnsOpenModal[i].addEventListener('click', openModal);

    btnCloseModal.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);

    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
</script>

<?php
if (isset($greska)) {
?>
    <script>
        document.querySelector('.modal').classList.remove("hidden");
        document.querySelector('.overlay').classList.remove("hidden");
    </script>
<?php

}

?>