<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["na_čekanju"])) {
        $id_vesti = $_GET["id_vesti"];
        $rubrika_id = $_POST["rubrika"];
        $naslov = $_POST["title"];
        $sadrzaj = $_POST["long_desc"];
        date_default_timezone_set('Europe/Belgrade');
        $datum_vreme = date("Y-m-d H:i:s");
        $konekcija->azurirajClanak($rubrika_id, $naslov, $sadrzaj, "na čekanju", $datum_vreme, $id_vesti);
        $potvrda = "Članak je poslat na odobrenje";
        echo '<script>setTimeout(function() { vratiNaPregledClanakaNaCekanju(); }, 1000);</script>';
    }

    if (isset($_POST["draft"])) {
        $id_vesti = $_GET["id_vesti"];
        $rubrika_id = $_POST["rubrika"];
        $naslov = $_POST["title"];
        $sadrzaj = $_POST["long_desc"];
        date_default_timezone_set('Europe/Belgrade');
        $datum_vreme = date("Y-m-d H:i:s");
        $konekcija->azurirajClanak($rubrika_id, $naslov, $sadrzaj, "draft", $datum_vreme, $id_vesti);
        $potvrda = "Članak je sačuvan u draft";
        echo '<script>setTimeout(function() { vratiNaPregledDraftClanaka(); }, 1000);</script>';
    }
    

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Izmena draft članka</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script src="https://code.jquery.com/jquery-1.11.3.js"></script>

        <link rel="stylesheet" href="style.css">
        <script>
            function vratiNaPregledDraftClanaka() {
                window.location.href = 'pregled_clanci_draft_stanje.php';
            }
            function vratiNaPregledClanakaNaCekanju() {
                window.location.href = 'pregled_clanci_na_cekanju.php';
            }
        </script>


    </head>

    <body>
    <div class="navigacija">
            <?php include "menu.php" ?>
        <div class="row justify-content-center">
        <div style="text-align: center;">
        <?php
        if (isset($potvrda)) {
            echo "<h6>$potvrda</h6>";
        }
        ?>

        <div>
            <?php
            $id_vesti = $_GET["id_vesti"];
            $clanak = $konekcija->getClanakByID($id_vesti);
            ?>
            <div class="row" style="width: 700px;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method='post' action='<?php echo "izmeni_draft_clanak.php?id_vesti=$id_vesti"; ?>'>
                                <select name="rubrika">
                                    <?php


                                    $rubrike_novinar = $konekcija->getRubrikeByNovinarId($_SESSION["id_korisnika"]);
                                    while ($rubrika_novinar = $rubrike_novinar->fetch_assoc()) {
                                        $rubrika = $konekcija->getRubrikaByID($rubrika_novinar["id_rubrike"]);
                                        echo "<option value=$rubrika[id_rubrike] ";
                                        if ($clanak["id_rubrike"] == $rubrika["id_rubrike"]) {
                                            echo "selected";
                                        }
                                        echo ">$rubrika[naziv]</option>";
                                    }
                                    ?>
                                </select>
                                <div class="mb-3">
                                    <label><strong>Title :</strong></label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $clanak["naslov"] ?>">
                                </div>
                                <div class="mb-1">
                                    <label><strong>Long Description :</strong></label>
                                    <textarea id="mytextarea" name='long_desc' class="form-control" style="height: 450px;"><?php echo $clanak["sadrzaj"] ?></textarea><br>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input type="submit" name="draft" value="Sačuvaj kao draft stanje"  style="margin-right: 10px" >
                                    <input type="submit" name="na_čekanju" value="Pošalji članak na odobrenje">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            tinymce.init({
                selector: '#mytextarea',
                plugins: [
                    'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                    'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                    'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | formatpainter casechange styleselect | bold italic backcolor | ' +
                    'alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
            });
        </script>

    </body>

    </html>
<?php
} else {
    header("location:index.php");
}