<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $korisnicko_ime = $_POST["korisnicko_ime"];
        $lozinka = md5($_POST["lozinka"]);
        $ime_prezime = $_POST["ime_prezime"];
        $id_rubrike = $_POST["rubrika"];
        $email = $_POST["email"];
        $uloga = "urednik";

        if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false) {
            $konekcija->ubaciKorisnika($korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email);
            $novi_korisnik = $konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime);
            $id_novog_urednika = $novi_korisnik["id_korisnika"];
            $konekcija->ubaciUrednikRubrika($id_novog_urednika, $id_rubrike);
            $potvrda = "Uspešno ste uneli urednika " . $ime_prezime;
                echo '<script>setTimeout(function() { vratiNaPregledUrednika(); }, 1000);</script>';
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
        <title>Pregled urednika</title>
        <link rel="stylesheet" href="style.css">
        <script>
            function vratiNaPregledUrednika() {
                window.location.href = 'pregled_urednika.php';
            }
        </script>
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <div><h1>Registracija novog urednika:</h1></div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3>Korisnicko ime:</h3>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" class="search-input" required>
                        <h3>Lozinka:</h3>
                        <input type="password" name="lozinka" placeholder="Lozinka" class="search-input" required>
                        <h3>Ime i prezime:</h3>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" class="search-input" required>
                        <h3>Email adresa:</h3>
                        <input type="email" name="email" placeholder="Email" class="search-input" required>
                        <h3>Naziv rubrike:</h3>
                        <select name="rubrika" class="search-input">
                            <?php
                            $rubrike = $konekcija->getSveRubrike();

                            while ($rubrika = $rubrike->fetch_assoc()) {
                                echo "<option value=$rubrika[id_rubrike]> $rubrika[naziv] </option>";
                            }
                            ?>
                        </select>
                        <?php if (isset($greska)) {
                            echo $greska;
                        } ?>
                       <div class="button-container">
                            <form action="" method="set" >
                                <input type="submit" value="Registracija urednika rubrike" name="submit" class='btn' />
                            </form>
                            <form action="pregled_urednika.php" method="get" >
                                <input type="submit" value="Odustani od registracije" name="Odustani" class='btn' />
                            </form>
                        </div>
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
?>
