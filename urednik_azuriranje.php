<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $id_urednika = $_GET["id_urednika"];
        $urednik = $konekcija->getKorisnikByID($id_urednika);
        $staro_ime = $urednik["korisnicko_ime"];
        $korisnicko_ime = $_POST["korisnicko_ime"];
        $lozinka = md5($_POST["lozinka"]);
        $ime_prezime = $_POST["ime_prezime"];
        $id_rubrike = $_POST["rubrika"];
        $email = $_POST["email"];

        if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false || $staro_ime == $korisnicko_ime) {
            $konekcija->azurirajKorisnika($id_urednika, $korisnicko_ime, $lozinka, $ime_prezime, "urednik", $email);
            $konekcija->obrisiPovezaneRedoveUrednika($id_urednika);
            if ($id_rubrike != 0) {
                $konekcija->ubaciUrednikRubrika($id_urednika, $id_rubrike);
            }
            header("location:pregled_urednika.php");
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
                    <?php
                    $id_urednika = $_GET["id_urednika"];
                    $urednik = $konekcija->getKorisnikByID($id_urednika);
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id_urednika=" . $id_urednika; ?>" method="post">
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required value="<?php echo $urednik["korisnicko_ime"]; ?>">
                        <input type="password" name="lozinka" placeholder="Lozinka" required value="<?php echo $urednik["lozinka"]; ?>">
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" required value="<?php echo $urednik["ime_prezime"]; ?>">
                        <input type="email" name="email" placeholder="Email" required value="<?php echo $urednik["email"]; ?>">
                        <label>Dodeli rubriku uredniku</label>
                        <select name="rubrika">
                            <option value="0" selected>Nema dodeljenu rubriku</option>
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
?>
