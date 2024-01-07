<?php
include "klase.php";

if (isset($_SESSION["id_korisnika"])) {
    if (isset($_GET["id_rubrike"])) {
        $id_rubrike = $_GET["id_rubrike"];
        
        // Provera da li postoje urednici povezani sa rubrikom
        $urednici = $konekcija->getUredniciByRubrikaId($id_rubrike);

        if ($urednici != false && $urednici->num_rows > 0) {
            // Ako postoje urednici, postavi poruku o nemogućnosti brisanja u sesiju
            $_SESSION['obrisi_rubriku_poruka'] = "Nije moguće obrisati rubriku jer postoje urednici povezani sa njom.";
        } else {
            // Ako nema urednika, izvrši brisanje rubrike i postavi poruku o uspehu u sesiju
            $konekcija->obrisiRubriku($id_rubrike);
        }
        
        // Preusmeri korisnika nazad na pregled rubrika
        header("location: pregled_rubrika.php");
    } else {
        // Ako nema ID-a rubrike u URL-u
        echo "Nije prosleđen ID rubrike.";
    }
} else {
    header("location:index.php");
}
?>
