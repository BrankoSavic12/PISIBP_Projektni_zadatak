<?php
include "klase.php";

if (isset($_SESSION["id_korisnika"]) && $_SESSION["uloga"] == "glavni urednik") {
    $id_glavnog_urednika = $_SESSION["id_korisnika"];
    $glavni_urednik = $konekcija->getKorisnikByID($id_glavnog_urednika);

    if ($glavni_urednik) {
        if (isset($_POST["submit"])) {
            $korisnicko_ime = $_POST["korisnicko_ime"];
            $lozinka = md5($_POST["lozinka"]);
            $ime_prezime = $_POST["ime_prezime"];
            $email = $_POST["email"];
            $staro_ime = $glavni_urednik["korisnicko_ime"];

            if ($konekcija->proveriPostojanjeKorisnickogImena($korisnicko_ime) == false || $staro_ime == $korisnicko_ime) {
                $konekcija->azurirajKorisnika($id_glavnog_urednika, $korisnicko_ime, $lozinka, $ime_prezime, "glavni urednik", $email);

                if ($_FILES["nova_slika"]["error"] == UPLOAD_ERR_OK) {
                    $putanja_do_foldera = "slike/";
                    $naziv_slike = "urednik1.jpg";
                    
                    move_uploaded_file($_FILES["nova_slika"]["tmp_name"], $putanja_do_foldera . $naziv_slike);
                }

                $potvrda = "Podaci su uspešno sačuvani.";
                echo '<script>setTimeout(function() { vratiNaPregledUrednika(); }, 1000);</script>';
            } else {
                $greska = "<h3>Korisnik sa istim imenom već postoji<h3>";
            }
        }
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ažuriranje profila glavnog urednika</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #file-input {
            border: 2px solid #333;
            padding: 10px;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
            background-color: #f9f9f9;
            color: #333;
            width: 100%;
            height: 45px;
            line-height: 20px;
        }

        #file-input::placeholder {
            line-height: 45px; 
        }
    </style>
    <script>
        function vratiNaPregledUrednika() {
            window.location.href = 'naslovna.php';
        }
    </script>
</head>
<body>

<div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content" >
        <div class="form" style="max-width:420px">
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div><h1>Ažuriranje ličnih podataka:</h1></div>
            <h2>Korisničko ime:</h2>
            <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" class="search-input" required value="<?php echo $glavni_urednik["korisnicko_ime"]; ?>">
            <h2>Lozinka:</h2>
            <input type="password" name="lozinka" placeholder="Lozinka" class="search-input" required value="<?php echo $glavni_urednik["lozinka"]; ?>">
            <h2>Ime i prezime:</h2>
            <input type="text" name="ime_prezime" placeholder="Ime i prezime" class="search-input" required value="<?php echo $glavni_urednik["ime_prezime"]; ?>">
            <h2>Email adresa:</h2>
            <input type="email" name="email" placeholder="Email" class="search-input" required value="<?php echo $glavni_urednik["email"]; ?>">
            <h2>Promeni sliku:</h2>
            <input type="file" name="nova_slika" id="file-input" accept="image/*">
            <?php if (isset($greska)) {
                echo $greska;
            } ?>

            <div class="button-container">
                <input type="submit" value="Sačuvaj izmene" name="submit" class="btn" />
                <input type="button" value="Vrati na početak" class="btn" onclick="vratiNaPregledUrednika()" />
            </div>
        </form>
        
        <h3> <?php if (isset($potvrda)) {
                echo $potvrda;
            } ?></h3>
    </div>
</div>

</body>
</html>
