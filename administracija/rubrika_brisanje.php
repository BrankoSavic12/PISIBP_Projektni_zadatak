<?php
include "klase.php";

if (isset($_SESSION["id_korisnika"])) {
    if (isset($_GET["id_rubrike"])) {
        $id_rubrike = $_GET["id_rubrike"];
        
        $urednici = $konekcija->getUredniciByRubrikaId($id_rubrike);

        if ($urednici != false && $urednici->num_rows > 0) {
            $_SESSION['obrisi_rubriku_poruka'] = "<h3>Nije moguće obrisati rubriku jer postoje urednici povezani sa njom.<h3>";
        } else {
            $konekcija->obrisiRubriku($id_rubrike);
        }
        header("location: pregled_rubrika.php");
    } else {
        echo "Nije prosleđen ID rubrike.";
    }
} else {
    header("location:index.php");
}
?>
