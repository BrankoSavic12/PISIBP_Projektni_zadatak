<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $naziv = $_POST["naziv"];
        if ($konekcija->proveriPostojanjeRubrike($naziv) == false) {
        $konekcija->ubaciRubriku($naziv);
        $potvrda = "<h2>Rubrika " .$naziv. " uspešno dodata.</h2>";
        echo '<script>setTimeout(function() { vratiNaPregledRubrika(); }, 1000);</script>';
        }
        else{
        $potvrda = "<h2>Rubrika sa istim nazivom već postoji</h2>";
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
                    <div><h1>Dodavanje nove rubrike</h1></div>
                    <h2>Unesi naziv nove rubrike:</h2>
                    <input type="text" name="naziv" placeholder="Naziv rubrike" class="search-input" required>
                        <div class="button-container">
                        <input type="submit" value="Sačuvaj izmene" name="submit" class="btn"/>
                        <input type="button" value="Vrati na početak" class="btn" onclick="vratiNaPregledRubrika()" />
                    </div>
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
