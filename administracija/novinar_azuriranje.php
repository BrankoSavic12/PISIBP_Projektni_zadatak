<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $id_novinara = $_GET["id_novinara"];
        $novinar = $konekcija->getKorisnikByID($id_novinara);
        $staro_ime = $novinar["korisnicko_ime"];
        $korisnicko_ime = $_POST["korisnicko_ime"];
        $lozinka = md5($_POST["lozinka"]);
        $ime_prezime = $_POST["ime_prezime"];
        $id_rubrike_ukloni = $_POST["rubrika_ukloni"];
        $id_rubrike_dodaj = $_POST["rubrika_dodaj"];
        $email = $_POST["email"];
        $id_rubrike = $_POST["rubrika"];

        if ($id_rubrike == 0) {
            $uloga = "novinar";
        } else {
            $uloga = "urednik";
        }
        if (isset($_POST["rubrika_dodaj"]) && $_POST["rubrika_dodaj"] != 0) {
            if ($konekcija->proveriDodeluRubrikeNovinaru($id_novinara, $_POST["rubrika_dodaj"])) {
                $greska = "Novinar već pripada izabranoj rubrici.";
            } else {
                $konekcija->ubaciRubrikuZaNovinara($id_novinara, $_POST["rubrika_dodaj"]);
            }
        }

        if (isset($_POST["rubrika_ukloni"]) && $_POST["rubrika_ukloni"] != 0) {
            $konekcija->ukloniRubrikuNovinaru($id_novinara, $_POST["rubrika_ukloni"]);
        }

        if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false || $staro_ime == $korisnicko_ime) {
            $konekcija->azurirajKorisnika($id_novinara, $korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email);
            if ($uloga == "urednik") {
                $konekcija->ubaciUrednikRubrika($id_novinara, $id_rubrike);
            }
            $potvrda = "Urednik uspešno ažuriran.";
            echo '<script>setTimeout(function() { vratiNaPregledNovinara(); }, 1000);</script>';
            
        } else {
            $greska = "Korisnik sa istim imenom već postoji";
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pregled novinara</title>
        <link rel="stylesheet" href="style.css">
    
        <script>
            function vratiNaPregledNovinara() {
                window.location.href = 'pregled_novinara.php';
            }
        </script>
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
        
                <div class="form" style="max-width:450px">
                    <?php
                    $id_novinara = $_GET["id_novinara"];
                    $novinar = $konekcija->getKorisnikByID($id_novinara);
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id_novinara=" . $id_novinara; ?>" method="post">
                        <div><h1>Azuriranje novinara rurbike:</h1></div>
                        <h2>Korisnicko ime:</h2>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" class="search-input" required value="<?php echo $novinar["korisnicko_ime"]; ?>">
                        <h2>Lozinka:</h2>
                        <input type="password" name="lozinka" placeholder="Lozinka" class="search-input" required value="<?php echo $novinar["lozinka"]; ?>">
                        <h2>Ime i prezime:</h2>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" class="search-input" required value="<?php echo $novinar["ime_prezime"]; ?>">
                        <h2>Email adresa:</h2>
                        <input type="email" name="email" placeholder="Email" class="search-input" required value="<?php echo $novinar["email"]; ?>">
                        
                        <h2>Unapredi novinara u urednika:</h2>
                        <select name="rubrika" class="search-input">
                            <option value="0" selected>Nema unapređenje</option>
                            <?php
                            $rubrike = $konekcija->getSveRubrike();

                            while ($rubrika = $rubrike->fetch_assoc()) {
                                echo "<option value=$rubrika[id_rubrike]> $rubrika[naziv] </option>";
                            }
                            ?>
                        </select>
                        <h2>Dodaj rubriku novinaru:</h2>
                        <select name="rubrika_dodaj" class="search-input">
                            <option value="0" selected>Nema dodeljivanja rubrike</option>
                            <?php
                            $rubrike_za_dodavanje = $konekcija->getSveRubrike();

                            while ($rubrika_dodavanje = $rubrike_za_dodavanje->fetch_assoc()) {
                                echo "<option value={$rubrika_dodavanje['id_rubrike']}>{$rubrika_dodavanje['naziv']}</option>";
                            }
                            ?>
                        </select>

                       
                        <h2>Ukloni rubriku novinaru:</h2>
                            <select name="rubrika_ukloni" class="search-input">
                            <option value="0" selected>Nema uklanjanja rubrike</option>
                            <?php
                            $rubrike_za_uklanjanje = $konekcija->getRubrikeByNovinarId($id_novinara);

                            while ($rubrika_uklanjanje = $rubrike_za_uklanjanje->fetch_assoc()) {
                                $rubrikaInfo = $konekcija->getRubrikaByID($rubrika_uklanjanje["id_rubrike"]);
                                echo "<option value={$rubrikaInfo['id_rubrike']}>{$rubrikaInfo['naziv']}</option>";
                            }
                            
                            ?>
                        </select>
                        <?php if (isset($greska)) {
                            echo $greska;
                        } ?>
                        <div class="button-container">
                            <input type="submit" value="Sačuvaj izmene" name="submit" class="btn"/>
                            <input type="button" value="Vrati na početak" class="btn" onclick="vratiNaPregledNovinara()" />
                        </div>
                    </form>

                    <h3> <?php if (isset($potvrda)) {
                                echo $potvrda;
                            } ?></h3>
                </div>
            </div>
        </div>


    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
    