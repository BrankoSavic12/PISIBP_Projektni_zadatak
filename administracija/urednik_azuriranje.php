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
        $id_rubrike= $_POST["rubrika"];
        $id_rubrike_ukloni = $_POST["ukloni_rubriku"];
        $email = $_POST["email"];
        

        if ($id_rubrike != 0 && $konekcija->proveriDodeluRubrikeUredniku($id_urednika, $id_rubrike)) {
            $greska = "Urednik već pripada izabranoj rubrici.";
        
        } else {
            if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false || $staro_ime == $korisnicko_ime) {
                $konekcija->azurirajKorisnika($id_urednika, $korisnicko_ime, $lozinka, $ime_prezime, "urednik", $email);
                
                if ($id_rubrike != 0) {
                    $konekcija->ubaciUrednikRubrika($id_urednika, $id_rubrike);
                }
                
                if ($id_rubrike_ukloni != 0) {
                    $konekcija->ukloniRubrikuUredniku($id_urednika, $id_rubrike_ukloni);
                }

                $potvrda = "Urednik uspešno ažuriran.";
                echo '<script>setTimeout(function() { vratiNaPregledUrednika(); }, 1000);</script>';
            } 
            else {
                $greska = "Korisnik sa istim imenom već postoji";
            }
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
                    <?php
                    $id_urednika = $_GET["id_urednika"];
                    $urednik = $konekcija->getKorisnikByID($id_urednika);
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?id_urednika=" . $id_urednika; ?>" method="post">
                        <div><h1>Azuriranje urednika rubrike:</h1></div>
                        <h2>Korisnicko ime:</h2>
                        <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" class="search-input" required value="<?php echo $urednik["korisnicko_ime"]; ?>">
                        <h2>Lozinka:</h2>
                        <input type="password" name="lozinka" placeholder="Lozinka" class="search-input" required value="<?php echo $urednik["lozinka"]; ?>">
                        <h2>Ime i prezime:</h2>
                        <input type="text" name="ime_prezime" placeholder="Ime i prezime" class="search-input" required value="<?php echo $urednik["ime_prezime"]; ?>">
                        <h2>Email adresa:</h2>
                        <input type="email" name="email" placeholder="Email" class="search-input" required value="<?php echo $urednik["email"]; ?>">
                        <h2>Dodaj rubriku uredniku:</h2>
                        <select name="rubrika" class="search-input">
                            <option value="0" selected>Nema dodeljivanja rubrike</option>
                            <?php
                            $rubrike = $konekcija->getSveRubrike();

                            while ($rubrika = $rubrike->fetch_assoc()) {
                                echo "<option value=$rubrika[id_rubrike]> $rubrika[naziv] </option>";
                            }
                            ?>
                        
                        </select>
                        <h2>Ukloni rubriku uredniku:</h2>
                        <select name="ukloni_rubriku" class="search-input">
                            <option value="0" selected>Nema uklanjanja rubrike</option>
                            <?php
                            $rubrikeUrednika = $konekcija->getRubrikeByUrednikId($id_urednika);

                            while ($rubrikaUrednika = $rubrikeUrednika->fetch_assoc()) {
                                $rubrikaInfo = $konekcija->getRubrikaByID($rubrikaUrednika["id_rubrike"]);
                                echo "<option value={$rubrikaInfo['id_rubrike']}>{$rubrikaInfo['naziv']}</option>";
                            }
                            ?>
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
