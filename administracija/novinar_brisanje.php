<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
    $id_novinara = $_GET["id_novinara"];
    $konekcija->obrisiNovinara($id_novinara);
    header("location:pregled_novinara.php");
} else {
    header("location:index.php");
}
