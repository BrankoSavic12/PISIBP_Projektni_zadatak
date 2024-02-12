<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Kreiranje članaka</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="https://code.jquery.com/jquery-1.11.3.js"></script>

        <link rel="stylesheet" href="style.css">
        <style>
            .content {
                padding: 20px;
            }
        </style>

    </head>

    <body>
        <div class="navigacija">
            <?php include "menu.php" ?>
            <div class="content" style="width: 60%;">
            <div class="info-container" style="width: 550px;">
                <?php
                $id_vesti = $_GET["id_vesti"];
                $vest = $konekcija->getClanakByID($id_vesti);
                echo "<div><h1>$vest[naslov]</h1></div>";
                echo "<h6>Datum:$vest[datum_vreme_objave]</h6>";
                $tagovi = $konekcija->getTagoviByVest($id_vesti);
                if ($tagovi != false) {
                    echo "<h6>  Tagovi: ";
                    $brojac = 0;
                    while ($tag = $tagovi->fetch_assoc()) {
                        $brojac++;
                        if ($brojac == $tagovi->num_rows) {
                            echo "$tag[sadrzaj]";
                        } else {
                            echo "$tag[sadrzaj], ";
                        }
                    }
                    echo "</h6>";
                }
                echo "<h6>Glavna slika</h6>";
                echo "<div><img src=../$vest[lead_slika_url] class=lead_slika></div>";
                echo '<span style="font-size: 15px;">' . $vest["sadrzaj"] . '</span>';


                $prethodnaStranica = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                $zavrsiCitanjeHref = '';

                if (strpos($prethodnaStranica, "pregled_odobreni_clanci.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_odobreni_clanci.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_na_cekanju.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_na_cekanju.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_draft_stanje.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_draft_stanje.php";
                } elseif (strpos($prethodnaStranica, "pregled_odobreni_clanci_urednik.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_odobreni_clanci_urednik.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_na_cekanju_urednik.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_na_cekanju_urednik.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_na_cekanju_glavni_urednik.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_na_cekanju_glavni_urednik.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_na_cekanju_urednik.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_na_cekanju_urednik.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_zahtevi_glavni_urednik.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_zahtevi_glavni_urednik.php";
                } elseif (strpos($prethodnaStranica, "pregled_clanci_zahtevi.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_clanci_zahtevi.php";
                }elseif (strpos($prethodnaStranica, "pregled_svi_odobreni_clanci_glavni_urednik.php") !== false) {
                    $zavrsiCitanjeHref = "pregled_svi_odobreni_clanci_glavni_urednik.php";
                }

                ?>

                <a href="<?php echo $zavrsiCitanjeHref; ?>" style="display: inline-block; margin: 10px">
                <a  href="<?php echo $zavrsiCitanjeHref; ?>" class="back-link">Završi čitanje</a>
                </a>


            </div>



    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
