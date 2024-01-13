<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $rubrika_id = $_POST["rubrika"];
        $naslov = $_POST["title"];
        $sadrzaj = $_POST["long_desc"];
        date_default_timezone_set('Europe/Belgrade');
        $datum_vreme = date("Y-m-d H:i:s");
        include "upload_slika.php";
        if ($uploadOk == 1) {
            $slika_url = "images/" . htmlspecialchars(basename($_FILES["slika"]["name"]));
            $konekcija->unesiClanak($_SESSION["id_korisnika"], $rubrika_id, $naslov, $sadrzaj, $datum_vreme, "draft", $slika_url);
            $potvrda = "<h6>Članak je sačuvan u draftu</h6>";
            $uneta_vest = $konekcija->getPoslednjiUnetClanak();
            $tagovi = $_POST["tagovi"];
            $tagovi_niz = explode(",", $tagovi);
            foreach ($tagovi_niz as $tag) {
                $konekcija->ubaciTag($uneta_vest["id_vesti"], $tag);
            }
        } else {
            $greska = "<h6>Vest nije moguće sačuvati zbog pogrešne slike</h6>";
        }
        echo '<script>setTimeout(function() { vratiNaPregledDraftClanaka(); }, 1000);</script>';
    }

    if (isset($_POST["odobri"])) {
        $rubrika_id = $_POST["rubrika"];
        $naslov = $_POST["title"];
        $sadrzaj = $_POST["long_desc"];
        date_default_timezone_set('Europe/Belgrade');
        $datum_vreme = date("Y-m-d H:i:s");
        include "upload_slika.php";
        if ($uploadOk == 1) {
            $slika_url = "images/" . htmlspecialchars(basename($_FILES["slika"]["name"]));
            $konekcija->unesiClanak($_SESSION["id_korisnika"], $rubrika_id, $naslov, $sadrzaj, $datum_vreme, "na čekanju", $slika_url);
            $potvrda = "<h6>Članak je poslat na odobrenje</h6>";

            $uneta_vest = $konekcija->getPoslednjiUnetClanak();
            $tagovi = $_POST["tagovi"];
            $tagovi_niz = explode(",", $tagovi);
            foreach ($tagovi_niz as $tag) {
                $konekcija->ubaciTag($uneta_vest["id_vesti"], $tag);
            }
        } else {
            $greska = "<h6>Vest nije moguće proslediti</h6>";
        }
        echo '<script>setTimeout(function() { vratiNaPregledClanakaNaCekanju(); }, 1000);</script>';
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Kreiranje članaka</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.tiny.cloud/1/3wrh81rf47kz5uhx860nh15rygis6s6puk10pm3qr4nuspua/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

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
        <div class="navigacija" >
            <?php include "menu.php" ?>
            <div class="row justify-content-center" style="overflow: auto;height: 100vh;width: 1300px;">
                <div style="text-align: center;" >
                    <?php
                    if (isset($potvrda)) {
                        echo "<h6>$potvrda</h6>";
                    }
                    if (isset($greska)) {
                        echo "<h6>$greska</h6>";
                    }
                    ?>

                </div class="form">
                <div class="col-12" >
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method='post' action='' enctype="multipart/form-data">
                                <h3 style="text-align: center;"><strong>Pisanje novog clanka:</strong></h3>
                                    <h6><strong>Naziv rubrike:</strong></h6>
                                    
                                    <select name="rubrika" class="form-control" style="height: 35px;">
                                        <?php
                                        $rubrike_novinar = $konekcija->getRubrikeByNovinarId($_SESSION["id_korisnika"]);
                                        while ($rubrika_novinar = $rubrike_novinar->fetch_assoc()) {
                                            $rubrika = $konekcija->getRubrikaByID($rubrika_novinar["id_rubrike"]);
                                            echo "<option value=$rubrika[id_rubrike]>$rubrika[naziv]</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="mb-3">
                                        <h6><strong>Naslov :</strong></h6>
                                        <input type="text" name="title" class="form-control" style="height: 30px;" required>
                                    </div>
                                    <div class="mb-1">
                                        <h6><strong>Tagovi :</strong></h6>
                                        <input type="text" name="tagovi" class="form-control" style="height: 30px;" required>
                                    </div>
                                    <div class="mb-3">
                                        <h6><strong>Glavna slika :</strong></h6>
                                        <input type="file" name="slika" class="form-control" style="height: 35px;" required>
                                    </div>
                                    <div class="mb-1">
                                        <h5 style="text-align:center"><strong>Napiši clanak :</strong></h5>
                                        <textarea id="mytextarea" name='long_desc' class="form-control" style="height: 500px;"></textarea><br>
                                    </div>
                                    <div class="button-container">
                                        <input type="submit" name="submit" value="Sačuvaj kao draft stanje" class="btn">
                                        <input type="submit" name="odobri" value="Pošalji članak na odobrenje"  class="btn">

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

                    images_upload_url: 'upload.php',
                    images_upload_handler: image_upload_handler_callback


                });
            </script>


    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
