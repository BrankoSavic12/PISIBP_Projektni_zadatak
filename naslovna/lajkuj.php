<?php
include "../administracija/klase.php";
include "funkcije.php";
$id_vesti = $_GET["id_vesti"];
$konekcija->povecajPozitivne($id_vesti);
header("location:vest.php?id_vesti=$id_vesti&lajk=1");
