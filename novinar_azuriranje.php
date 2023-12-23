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
        $id_rubrike = $_POST["rubrika"];
        $email = $_POST["email"];
        if ($id_rubrike == 0) {
            $uloga = "novinar";
        } else {
            $uloga = "urednik";
        }

        if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false || $staro_ime == $korisnicko_ime) {
            $konekcija->azurirajKorisnika($id_novinara, $korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email);
            if ($uloga == "urednik") {
                $konekcija->ubaciUrednikRubrika($id_novinara, $id_rubrike);
            }
            header("location:pregled_novinara.php");
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
                        <h2>Azuriranje ili unapredjenje novinara</h2>
                        <h4>Korisnicko ime:</h4>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required value="<?php echo $novinar["korisnicko_ime"]; ?>">
                        <h4>Lozinka:</h4>
                        <input type="password" name="lozinka" placeholder="Lozinka" required value="<?php echo $novinar["lozinka"]; ?>">
                        <h4>Ime i prezime:</h4>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" required value="<?php echo $novinar["ime_prezime"]; ?>">
                        <h4>Email adresa:</h4>
                        <input type="email" name="email" placeholder="Email" required value="<?php echo $novinar["email"]; ?>">
                        <h4>Unapredi novinara u urednika rubrike:</h4>
                        <select name="rubrika">
                            <option value="0" selected>Nema unapređenje</option>
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
                        <input type="submit" value="Ažuriraj" name="submit">
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
