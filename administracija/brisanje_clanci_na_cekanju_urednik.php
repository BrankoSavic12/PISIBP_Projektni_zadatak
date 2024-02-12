<?php
    include "klase.php";
    if (isset($_SESSION["id_korisnika"])) {
        $id_vesti = $_GET["id_vesti"];
        $konekcija->obrisiVest($id_vesti);
        header("location:pregled_clanci_na_cekanju_urednik.php");
    } else {
        header("location:index.php");
    }
       
?>
