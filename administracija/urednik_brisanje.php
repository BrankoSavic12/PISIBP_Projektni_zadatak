<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    $id_urednika = $_GET["id_urednika"];
    $konekcija->obrisiUrednika($id_urednika);
    header("location:pregled_urednika.php");
} else {
    header("location:index.php");
}
?>
