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
            header("location:pregled_rubrika.php");
        }
    } else {
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
            <div class="info-container"  style="max-width:450px;">
                <div>
                    <div><h1>Informacije o rubrici</h1></div>
                    <?php if (isset($ime_rubrike)) { ?>
                        <div class="rubrika-info-item">
                            <h2>Ime rubrike:</h2>
                            <h3><?php echo $ime_rubrike; ?></h3>
                        </div>
                    <?php } ?>
                    <div class="rubrika-info-item">
                        <h2>Urednici rubrike:</h2>
                        <?php
                        if (isset($urednici) && $urednici != false) {
                            while ($urednik = $urednici->fetch_assoc()) {
                                echo "<h3>$urednik[ime_prezime] - $urednik[email]</h3>";
                            }
                        } else {
                            echo "<h3>Nema urednika za ovu rubriku.</h3>";
                        }
                        ?>
                    </div>
                    <a href="pregled_rubrika.php" class="back-link" style="padding-left: 10px">Napusti stranicu</a>
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
