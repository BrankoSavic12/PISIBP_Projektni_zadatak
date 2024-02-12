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
        $status = $_POST["status"]; // Dodato polje za status

        if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false) {
            $konekcija->ubaciKorisnika($korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email, $status); // Dodato polje za status
            $novi_korisnik = $konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime);
            $id_novog_novinara = $novi_korisnik["id_korisnika"];
            $konekcija->ubaciRubrikuZaNovinara($id_novog_novinara, $id_rubrike);
            $potvrda = "Uspešno ste uneli novinara " . $ime_prezime;
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
                <div><h1>Registracija novinara:</h1></div>
                <h2>Korisničko ime:</h2>
                <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" class="search-input" required>
                <h2>Lozinka:</h2>
                <input type="password" name="lozinka" placeholder="Lozinka" class="search-input" required>
                <h2>Ime i prezime:</h2>
                <input type="text" name="ime_prezime" placeholder="Ime i prezime" class="search-input" required>
                <h2>Email adresa:</h2>
                <input type="email" name="email" placeholder="Email" class="search-input" required>
                <h2>Rubrika kojoj novinar pripada:</h2>
                <select name="rubrika" class="search-input">
                    <?php
                    $rubrike = $konekcija->getSveRubrike();

                    while ($rubrika = $rubrike->fetch_assoc()) {
                        echo "<option value=$rubrika[id_rubrike]> $rubrika[naziv] </option>";
                    }
                    ?>
                </select>
                <h2>Status:</h2>
                <select name="status" class="search-input">
                    <option value="aktivan">Aktivan</option>
                    <option value="neaktivan">Neaktivan</option>
                </select>

                <?php if (isset($greska)) {
                    echo $greska;
                } ?>
                <div class="button-container">
                    <input type="submit" value="Sačuvaj izmene" name="submit" class="btn"/>
                    <input type="button" value="Vrati na početak" class="btn" onclick="vratiNaPregledUrednika()" />
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
?>
