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
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
                <div>
                    <h2>Registracija novog urednika:</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h4>Korisnicko ime:</h4>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required>
                        <h4>Lozinka:</h4>
                        <input type="password" name="lozinka" placeholder="Lozinka" required>
                        <h4>Ime i prezime:</h4>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" required>
                        <h4>Email adresa:</h4>
                        <input type="email" name="email" placeholder="Email" required>
                        <h4>Naziv rubrike:</h4>
                        <select name="rubrika">
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
                        <input type="submit" value="Registruj urednika" name="submit">
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
?>
