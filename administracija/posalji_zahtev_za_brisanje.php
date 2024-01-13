<?php
include "klase.php";
$id_vesti = $_GET["id_vesti"];
$clanak = $konekcija->getClanakByID($id_vesti);
$konekcija->posaljiZahtev($id_vesti, $clanak["id_novinara"], $clanak["id_rubrike"], "brisanje");
header("location:pregled_odobreni_clanci.php");
?>
