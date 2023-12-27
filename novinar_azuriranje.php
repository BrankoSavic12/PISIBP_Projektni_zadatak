<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $id_novinara = $_GET["id_novinara"];
        $novinar = $konekcija->getKorisnikByID($id_novinara);
        $staro_ime = $novinar["korisnicko_ime"];
        echo $staro_ime;
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

        // Dodatne provere, ako su vrednosti dostupne
        if (isset($_POST["rubrika_dodaj"]) && $_POST["rubrika_dodaj"] != 0) {
            // Dodaj proveru da li rubrika već postoji kod novinara
            if ($konekcija->proveriDodeluRubrikeNovinaru($id_novinara, $_POST["rubrika_dodaj"])) {
                $greska = "Novinar već pripada izabranoj rubrici.";
            } else {
                $konekcija->ubaciRubrikuZaNovinara($id_novinara, $_POST["rubrika_dodaj"]);
            }
        }

        if (isset($_POST["rubrika_ukloni"]) && $_POST["rubrika_ukloni"] != 0) {
            // Dodaj proveru ili kod za uklanjanje rubrike
            $konekcija->ukloniRubrikuNovinaru($id_novinara, $_POST["rubrika_ukloni"]);
        }

        // Bez obzira na promene, izvrši ažuriranje korisnika
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
                <div>
                    <?php
                    $id_novinara = $_GET["id_novinara"];
                    $novinar = $konekcija->getKorisnikByID($id_novinara);
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id_novinara=" . $id_novinara; ?>" method="post">
                        <h1>Azuriraj/unapredi novinara:</h1>
                        <h3>Korisnicko ime:</h3>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required value="<?php echo $novinar["korisnicko_ime"]; ?>">
                        <h3>Lozinka:</h3>
                        <input type="password" name="lozinka" placeholder="Lozinka" required value="<?php echo $novinar["lozinka"]; ?>">
                        <h3>Ime i prezime:</h3>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" required value="<?php echo $novinar["ime_prezime"]; ?>">
                        <h3>Email adresa:</h3>
                        <input type="email" name="email" placeholder="Email" required value="<?php echo $novinar["email"]; ?>">
                        
                        <h3>Unapredi novinara u urednika rubrike:</h3>
                        <select name="rubrika">
                            <option value="0" selected>Nema unapređenje</option>
                            <?php
                            $rubrike = $konekcija->getSveRubrike();

                            while ($rubrika = $rubrike->fetch_assoc()) {
                                echo "<option value=$rubrika[id_rubrike]> $rubrika[naziv] </option>";
                            }
                            ?>
                        </select>
                        <h3>Dodaj rubriku novinaru:</h3>
                        <select name="rubrika_dodaj">
                            <option value="0" selected>Nema dodeljivanja rubrike</option>
                            <?php
                            $rubrike_za_dodavanje = $konekcija->getSveRubrike();

                            while ($rubrika_dodavanje = $rubrike_za_dodavanje->fetch_assoc()) {
                                echo "<option value={$rubrika_dodavanje['id_rubrike']}>{$rubrika_dodavanje['naziv']}</option>";
                            }
                            ?>
                        </select>

                       
                        <h3>Ukloni rubriku novinaru:</h3>
                            <select name="rubrika_ukloni">
                            <option value="0" selected>Nema uklanjanja rubrike</option>
                            <?php
                            $rubrike_za_uklanjanje = $konekcija->getRubrikeByNovinarId($id_novinara);

                            while ($rubrika_uklanjanje = $rubrike_za_uklanjanje->fetch_assoc()) {
                                $rubrikaInfo = $konekcija->getRubrikaByID($rubrika_uklanjanje["id_rubrike"]);
                                echo "<option value={$rubrikaInfo['id_rubrike']}>{$rubrikaInfo['naziv']}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" value="Ažuriraj urednika rubrike" name="submit">
                        </form>

                        <form action="pregled_novinara.php" method="get">
                        <input type="submit" value="Odustani od ažuriranja" name="odustani">
                        </form>
                        

                        <?php if (isset($greska)) {
                            echo $greska;
                        } ?>
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
    