<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_GET["id_rubrike"])) {
        $id_rubrike = $_GET["id_rubrike"];
        $rubrikaInfo = $konekcija->getRubrikaInfo($id_rubrike);

        if ($rubrikaInfo) {
            $ime_rubrike = $rubrikaInfo['ime_rubrike'];
            $urednici = $rubrikaInfo['urednici'];
        } else {
            // Ako rubrika nije pronađena
            header("location:pregled_rubrika.php");
        }
    } else {
        // Ako nema ID-a rubrike u URL-u
        header("location:pregled_rubrika.php");
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informacije o rubrici</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content">
            <div class="info-container">
                <div>
                    <h2>Osnovne informacije o rubrici</h2>
                    <?php if (isset($ime_rubrike)) { ?>
                        <div class="rubrika-info-item">
                            <h3>Ime rubrike:</h3>
                            <h4><?php echo $ime_rubrike; ?></h4>
                        </div>
                    <?php } ?>
                    <div class="rubrika-info-item">
                        <h3>Urednici rubrike:</h3>
                        <?php
                        if (isset($urednici) && $urednici != false) {
                            while ($urednik = $urednici->fetch_assoc()) {
                                echo "<h4>$urednik[ime_prezime] - $urednik[email]</h4>";
                            }
                        } else {
                            echo "<h4>Nema urednika za ovu rubriku.</h4>";
                        }
                        ?>
                    </div>
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
