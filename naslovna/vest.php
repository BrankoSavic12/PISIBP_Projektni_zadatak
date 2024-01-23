<?php
include "../administracija/klase.php";
include "funkcije.php";

$id_vesti = $_GET["id_vesti"];
$vest = $konekcija->getClanakByID($id_vesti);


if (isset($_POST["submit"])) {

    $citalac = $_POST["citalac"];
    $sadrzaj = $_POST["sadrzaj"];
    $konekcija->unesiKomentar($id_vesti, $citalac, $sadrzaj);
    $potvrda = "<h3>Vaš komentar je unet</h3>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vest["naslov"]; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "menu.php";
    ?>

    <section class="main">
        <div class="container container_main">
            <div class="glavne_vesti">
                <div class='glavna_vest_sadrzaj'>
                <?php
                $sadrzaj = str_replace("", "", $vest["sadrzaj"]);
                echo "<h1>$vest[naslov]</h1>";
                $rubrika_vest = $konekcija->getRubrikaByID($vest["id_rubrike"]);
                $novinar = $konekcija->getKorisnikByID($vest["id_novinara"]);
                echo "<h3>Piše: $novinar[ime_prezime]</h3>";
                $datum_vreme = date("d.m.Y. H:i", strtotime($vest["datum_vreme_objave"]));
                echo "<h3>$rubrika_vest[naziv]-$datum_vreme</h3>";
                echo "<div>$sadrzaj</div>";
                ?>
                </div>

                <div class="lajkovi">
                    <p>Broj pozitivnih ocena: <?php echo $vest["broj_pozitivnih"]; ?>
                        <?php
                        if (!isset($_GET["lajk"])) {
                        ?>
                            <a href="<?php echo "lajkuj.php?id_vesti=$vest[id_vesti]"; ?>"> <i class="fa fa-thumbs-up lajk"></i></a>
                        <?php
                        }
                        ?>

                    </p>
                    <p>Broj negativnih ocena: <?php echo $vest["broj_negativnih"]; ?>
                        <?php
                        if (!isset($_GET["lajk"])) {
                        ?>
                            <a href="<?php echo "dislajkuj.php?id_vesti=$vest[id_vesti]"; ?>"> <i class="fa fa-thumbs-down lajk"></i></a>
                        <?php
                        }
                        ?>
                    </p>
                </div>

            <div class="komentari">
                <h3>Komentari</h3>
                <?php
                $komentari = $konekcija->getKomentariByVestId($id_vesti);
                if ($komentari != false) {
                    while ($komentar = $komentari->fetch_assoc()) {
                        $datum_vreme_komentara = date("d.m.Y. H:i", strtotime($komentar["datum_vreme"]));
                        echo "<div>
                        <h4>$komentar[citalac]</h4>
                        <p>$komentar[sadrzaj]</p>
                        <p class='komentari-datum'>$datum_vreme_komentara</p>
                        </div>";
                    }
                } else {
                    echo "<p>Nema komentara za ovu vest</p>";
                }
                ?>
            </div>
        
            <div class="komentar-forma">
                <?php if (isset($potvrda)) { ?>
                    <h3><?php echo $potvrda; ?></h3>
                <?php } else { ?>
                    <h4>Unesi jednokratno ime i ostavi komentar</h4>
                    <form action="<?php echo "vest.php?id_vesti=$id_vesti"; ?>" method="post">
                        <label for="citalac">Tvoje ime:</label>
                        <input type="text" name="citalac" id="citalac" required placeholder="Unesi jednokratno ime" value="<?php echo isset($_POST['citalac']) ? htmlspecialchars($_POST['citalac']) : ''; ?>">

                        <label for="sadrzaj">Tvoj komentar:</label>
                        <textarea name="sadrzaj" id="sadrzaj" cols="10" rows="2" placeholder="Unesi komentar" required><?php echo isset($_POST['sadrzaj']) ? htmlspecialchars($_POST['sadrzaj']) : ''; ?></textarea>

                        <input type="submit" value="Pošalji" name="submit">
                    </form>
                <?php } ?>
            </div>


            </div>
            <?php
            include "aktuelnosti.php";
            ?>
        </div>
    </section>
</body>

</html>