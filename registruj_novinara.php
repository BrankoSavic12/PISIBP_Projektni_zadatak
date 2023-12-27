<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $korisnicko_ime = $_POST["korisnicko_ime"];
        $lozinka = md5($_POST["lozinka"]);
        $ime_prezime = $_POST["ime_prezime"];
        $id_rubrike = $_POST["rubrika"];
        $email = $_POST["email"];
        $uloga = "novinar";

        if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false) {
            $konekcija->ubaciKorisnika($korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email);
            $novi_korisnik = $konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime);
            $id_novog_novinara = $novi_korisnik["id_korisnika"];
            $konekcija->ubaciRubrikuZaNovinara($id_novog_novinara, $id_rubrike);
            $potvrda = "Uspešno ste uneli novinara " . $ime_prezime;
                echo '<script>setTimeout(function() { vratiNaPregledUrednika(); }, 1000);</script>';
        } else {
            $greska = "Korisnik sa istim imenov već postoji";
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
            function vratiNaPregledUrednika() {
                window.location.href = 'pregled_novinara.php';
            }
        </script>
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h1>Registracija novog novinara:</h1>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h3>Korisnicko ime:</h3>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required>
                        <h3>Lozinka:</h3>
                        <input type="password" name="lozinka" placeholder="Lozinka" required>
                        <h3>Ime i prezime:</h3>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" required>
                        <h3>Email adresa:</h3>
                        <input type="email" name="email" placeholder="Email" required>
                        <h3>Rubrika kojoj novinar pripada:</h3>
                        <select name="rubrika" class="custom-select">
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
                        <input type="submit" value="Registruj novinara" name="submit">
                    </form>
                    <form action="pregled_urednika.php" method="get">
                        <input type="submit" value="Odustani od registracije" name="odustani">
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
