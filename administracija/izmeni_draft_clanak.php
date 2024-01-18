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
        <script src="https://cdn.tiny.cloud/1/iz2p1l82qdrmzktejgzo1i1qayr12hszcurdxccvfa5f5l7r/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

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
            <div class="row justify-content-center" style="overflow: auto;height: 100vh;width: 1300px;">
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
                                        <h3 style="text-align: center;"><strong>Izmena postojećeg clanka:</strong></h3>
                                            <div class="mb-3" style="text-align: left;">
                                                <h6><strong>Naslov članka :</strong></h6>
                                                <input type="text" name="title" class="form-control" style="height: 30px;" value="<?php echo $clanak["naslov"] ?>">
                                            </div>
                                            <h6 style="text-align: left;"><strong>Naziv rubrike:</strong></h6>
                                            <select name="rubrika"  class="form-control" style="height: 35px;">
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
                                            <?php
                                            
                                            echo "<h6><strong>Glavna slika</strong></h6>";
                                            echo "<div><img src=../$clanak[lead_slika_url] class=lead_slika></div>";
                                            ?>
                                            <div class="mb-1" style="text-align: left;">
                                                <h5><strong>Promeni tekst :</strong></h5>
                                                <textarea id="mytextarea" name='long_desc' class="form-control" style="height: 450px;"><?php echo $clanak["sadrzaj"] ?></textarea><br>
                                            </div>
                                            <div class="button-container">
                                                <input type="submit" name="draft" value="Sačuvaj kao draft stanje" class="btn">
                                                <input type="submit" name="na_čekanju" value="Pošalji članak na odobrenje" class="btn">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
                            const xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            xhr.open('POST', 'upload.php');

                            xhr.upload.onprogress = (e) => {
                                progress(e.loaded / e.total * 100);
                            };

                            xhr.onload = () => {
                                if (xhr.status === 403) {
                                    reject({
                                        message: 'HTTP Error: ' + xhr.status,
                                        remove: true
                                    });
                                    return;
                                }

                                if (xhr.status < 200 || xhr.status >= 300) {
                                    reject('HTTP Error: ' + xhr.status);
                                    return;
                                }

                                const json = JSON.parse(xhr.responseText);

                                if (!json || typeof json.location != 'string') {
                                    reject('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }

                                resolve(json.location);
                            };

                            xhr.onerror = () => {
                                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                            };

                            const formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());

                            xhr.send(formData);
                        });

                        tinymce.init({
                            selector: '#mytextarea',
                            plugins: [
                                'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                                'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
                            ],
                            toolbar: 'undo redo | formatpainter casechange styleselect | bold italic backcolor | ' +
                                'alignleft aligncenter alignright alignjustify | ' +
                                'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help',
                            // without images_upload_url set, Upload tab won't show up
                            images_upload_url: 'upload.php',

                            // override default upload handler to simulate successful upload
                            images_upload_handler: image_upload_handler_callback


                        });
                    </script>

    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
