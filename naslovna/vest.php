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

// Fetch comments from the database
$komentariResult = $konekcija->getKomentariByVestId($id_vesti);

// Check if the result is not false before using array_slice
$komentari = ($komentariResult !== false) ? $komentariResult->fetch_all(MYSQLI_ASSOC) : [];
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
    <?php include "menu.php"; ?>

    <section class="main">
        <div class="container container_main">
            <div class="glavne_vesti">
                <div class="aktuelna_vest">
                <div class="aktuelna_vest" style="position: relative;">
                    <div class="pise_datum">
                        <?php
                        $novinar = $konekcija->getKorisnikByID($vest["id_novinara"]);
                        $rubrika_vest = $konekcija->getRubrikaByID($vest["id_rubrike"]);
                        $datum_vreme = date("d.m.Y. H:i", strtotime($vest["datum_vreme_objave"]));
                        echo "Novinar: $novinar[ime_prezime]";
                        ?>
                    </div>
                    <a href="vest.php?id_vesti=<?php echo $vest['id_vesti']; ?>">
                        <img src="../<?php echo $vest['lead_slika_url']; ?>" class="lead_slika" alt="Lead slika" style="height: 400px; outline: none;">
                        <div class="naslov_bloka">
                            <h2 class="naslov_slike"><?php echo $vest["naslov"]; ?></h2>
                        </div>
                        <div class="datum_blok">
                            <?php echo $datum_vreme; ?>
                        </div>
                    </a>
                </div>

                    <div class='glavna_vest_sadrzaj'>
                        <?php
                        $sadrzaj = str_replace("", "", $vest["sadrzaj"]);
                        $rubrika_vest = $konekcija->getRubrikaByID($vest["id_rubrike"]);
                        $novinar = $konekcija->getKorisnikByID($vest["id_novinara"]);
                        echo "<div>$sadrzaj</div>";
                        ?>
                    </div>
                </div>

                <div class="lajkovi">
                    <p>Broj pozitivnih ocena: <?php echo $vest["broj_pozitivnih"]; ?>
                        <?php if (!isset($_GET["lajk"])) { ?>
                            <a href="<?php echo "lajkuj.php?id_vesti=$vest[id_vesti]"; ?>"> <i class="fa fa-thumbs-up lajk"></i></a>
                        <?php } ?>
                    </p>
                    <p>Broj negativnih ocena: <?php echo $vest["broj_negativnih"]; ?>
                        <?php if (!isset($_GET["lajk"])) { ?>
                            <a href="<?php echo "dislajkuj.php?id_vesti=$vest[id_vesti]"; ?>"> <i class="fa fa-thumbs-down lajk"></i></a>
                        <?php } ?>
                    </p>
                </div>

                <div class="komentari">
                    <h3 class="komentari-header">
                        Komentari
                        <button class="comment-button" onclick="toggleCommentForm()">Unesi komentar</button>
                    </h3>
                    <?php
                    if (!empty($komentari)) {
                        foreach ($komentari as $komentar) {
                            $datum_vreme_komentara = date("d.m.Y. H:i", strtotime($komentar["datum_vreme"]));

                            echo "<div class='komentar'>
                                <div class='levo'>
                                    <h3>$komentar[citalac]</h3>
                                    <p class='komentari-datum'>$datum_vreme_komentara</p>
                                    <p>$komentar[sadrzaj]</p>
                                </div>
                                <div class='desno'>
                                    <div class='lajkovi_komentara'>
                                        <p>Lajkovi: {$komentar["broj_pozitivnih"]}";
                            if (!isset($_GET["lajk_komentara"]) || (isset($_GET["lajk_komentara"]) && $_GET["id_komentara"] != $komentar["id_komentara"])) {
                                echo " <a href='lajkuj_komentar.php?id_vesti={$komentar["id_vesti"]}&id_komentara={$komentar["id_komentara"]}'><i class='fa fa-thumbs-up lajk'></i></a>";
                            }
                            echo "</p>
                                            <p style='padding-left: 10px;'>Dislajkovi: {$komentar["broj_negativnih"]}";
                            if (!isset($_GET["lajk_komentara"]) || (isset($_GET["lajk_komentara"]) && $_GET["id_komentara"] != $komentar["id_komentara"])) {
                                echo " <a href='dislajkuj_komentar.php?id_vesti={$komentar["id_vesti"]}&id_komentara={$komentar["id_komentara"]}'><i class='fa fa-thumbs-down lajk'></i></a>";
                            }
                            echo "</p>
                                    </div>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<p>Nema komentara za ovu vest</p>";
                    }
                    ?>
                </div>

                <div class="komentar-forma" id="commentFormContainer" style="display: none;">
                    <?php if (isset($potvrda)) { ?>
                        <h3><?php echo $potvrda; ?></h3>
                    <?php } else { ?>
                        <h4>Unesi jednokratno ime i ostavi komentar</h4>
                        <form action="vest.php?id_vesti=<?php echo $id_vesti; ?>" method="post">
                            <label for="citalac">Tvoje ime:</label>
                            <input type="text" name="citalac" id="citalac" required placeholder="Unesi jednokratno ime" value="<?php echo isset($_POST['citalac']) ? htmlspecialchars($_POST['citalac']) : ''; ?>">

                            <label for="sadrzaj">Tvoj komentar:</label>
                            <textarea name="sadrzaj" id="sadrzaj" cols="10" rows="2" placeholder="Unesi komentar" required><?php echo isset($_POST['sadrzaj']) ? htmlspecialchars($_POST['sadrzaj']) : ''; ?></textarea>

                            <input type="submit" value="Pošalji" name="submit">
                        </form>
                    <?php } ?>
                </div>
            </div>
            <?php include "aktuelnosti.php"; ?>
        </div>
    </section>

    <script>
        function toggleCommentForm() {
            var commentFormContainer = document.getElementById('commentFormContainer');
            commentFormContainer.style.display = (commentFormContainer.style.display === 'none') ? 'block' : 'none';
        }
    </script>

</body>

</html>
