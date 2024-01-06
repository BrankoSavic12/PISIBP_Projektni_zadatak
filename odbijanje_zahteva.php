<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {

    $id_zahteva = $_GET["id_zahteva"];


    $konekcija->obrisiZahtevByIDZahteva($id_zahteva);
    header("location:pregled_clanci_zahtevi_glavni_urednik.php");
} else {
    header("location:index.php");
}
