<?php
include "../administracija/klase.php";
include "funkcije.php";
$id_vesti = $_GET["id_vesti"];
$id_komenatara = $_GET["id_komentara"];
$konekcija->povecajNegativneKomentare($id_vesti, $id_komenatara);
header("location:vest.php?id_vesti=$id_vesti&lajk_komentara=1&id_komentara=$id_komenatara");
