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
            <div class="content">

            <?php
            $id_vesti = $_GET["id_vesti"];
            $vest = $konekcija->getClanakByID($id_vesti);
            echo "<div><h2>$vest[naslov]</h2></div>";
            echo "<h6>Datum:$vest[datum_vreme_objave]</h6>";
            echo $vest["sadrzaj"];

            $prethodnaStranica = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
            $zavrsiCitanjeHref = '';
            
            if (strpos($prethodnaStranica, "pregled_odobreni_clanci.php") !== false) {
                $zavrsiCitanjeHref = "pregled_odobreni_clanci.php";
            } elseif (strpos($prethodnaStranica, "pregled_clanci_na_cekanju.php") !== false) {
                $zavrsiCitanjeHref = "pregled_clanci_na_cekanju.php";
            } elseif (strpos($prethodnaStranica, "pregled_clanci_draft_stanje.php") !== false) {
                $zavrsiCitanjeHref = "pregled_clanci_draft_stanje.php";
            }
         
            ?>
            
            <a href="<?php echo $zavrsiCitanjeHref; ?>" style="display: inline-block; margin: 10px;">
                <button style="padding: 5px 10px; font-size: 12px;">Završi čitanje</button>
            </a>
            
            
        </div>



    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
