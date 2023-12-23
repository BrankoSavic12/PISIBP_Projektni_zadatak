<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $naziv = $_POST["naziv"];
        $konekcija->ubaciRubriku($naziv);
        $potvrda = "Rubrika uspešno dodata.";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj rubriku</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="navigacija">
        <?php include "menu.php" ?>
        <div class="content">
            <div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h2>Dodavanje nove rubrike</h2>
                    <h4>Unesi naziv nove rubrike:</h4>
                    <input type="text" name="naziv" placeholder="Naziv rubrike" required>
                    <input type="submit" value="Dodaj rubriku" name="submit">
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
