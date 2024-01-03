<?php
include "klase.php";
$id_vesti = $_GET["id_vesti"];
$datum_vreme = date("Y-m-d h:i:s");
$konekcija->odobriVest($id_vesti, $datum_vreme, $_SESSION["id_korisnika"], "odobrena");
header("location:naslovna.php");
