<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    if (isset($_POST["submit"])) {
        $rubrika_id = $_POST["rubrika"];
        $naslov = $_POST["title"];
        $sadrzaj = $_POST["long_desc"];
        $konekcija->unesiClanak($_SESSION["id_korisnika"], $rubrika_id, $naslov, $sadrzaj);
        $potvrda = "Članak je poslan na odobrenje";
    }

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


    </head>

    <body>
        <div class="navigacija">
            <?php include "menu.php" ?>
        </div>

        <?php
        if (isset($potvrda)) {
            echo "<h3>$potvrda</h3>";
        }
        ?>






        <div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method='post' action=''>
                                <select name="rubrika">
                                    <?php
                                    $rubrike_novinar = $konekcija->getRubrikeByNovinarId($_SESSION["id_korisnika"]);
                                    while ($rubrika_novinar = $rubrike_novinar->fetch_assoc()) {
                                        $rubrika = $konekcija->getRubrikaByID($rubrika_novinar["id_rubrike"]);
                                        echo "<option value=$rubrika[id_rubrike]>$rubrika[naziv]</option>";
                                    }
                                    ?>
                                </select>
                                <div class="mb-3">
                                    <label><strong>Title :</strong></label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <div class="mb-1">
                                    <label><strong>Long Description :</strong></label>
                                    <textarea id="mytextarea" name='long_desc' class="form-control"></textarea><br>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
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
