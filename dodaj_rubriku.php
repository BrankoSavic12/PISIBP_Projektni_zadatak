<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $naziv = $_POST["naziv"];
        if ($konekcija->proveriPostojanjeRubrike($naziv) == false) {
        $konekcija->ubaciRubriku($naziv);
        $potvrda = "Rubrika " .$naziv. " uspešno dodata.";
        echo '<script>setTimeout(function() { vratiNaPregledRubrika(); }, 1000);</script>';
        }
        else{
        $potvrda = "Rubrika sa istim nazivom već postoji";
        echo '<script>setTimeout(function() { vratiNaPregledRubrika(); }, 1000);</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj rubriku</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function vratiNaPregledRubrika() {
            window.location.href = 'pregled_rubrika.php';
        }
    </script>
    
</head>

<body>

    <div class="navigacija">
        <?php include "menu.php" ?>
        <div class="content">
            <div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h1>Dodavanje nove rubrike</h1>
                    <h3>Unesi naziv nove rubrike:</h3>
                    <input type="text" name="naziv" placeholder="Naziv rubrike" required>
                    <input type="submit" value="Dodavanje nove rubriku" name="submit">
                </form>
                <form action="pregled_rubrika.php" method="get">
                    <input type="submit" value="Odustani od dodavanja rubrike" name="odustani">
                </form>
                <h3> <?php if (isset($potvrda)) { echo $potvrda; } ?></h3>
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
