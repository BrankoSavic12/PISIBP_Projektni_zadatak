<?php
$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["slika"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$check = getimagesize($_FILES["slika"]["tmp_name"]);
if ($check !== false) {

    $uploadOk = 1;
} else {

    $uploadOk = 0;
}

if (file_exists($target_file)) {

    $uploadOk = 0;
}

if ($_FILES["slika"]["size"] > 5000000) {

    $uploadOk = 0;
}

if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {

    $uploadOk = 0;
}

if ($uploadOk == 0) {
} else {
    move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file);
}
