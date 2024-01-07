<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled odobrenih clanaka</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .clanak-container {
        max-width: 600px;
        margin: 0px auto;
        padding: 5px;
        text-align: center;
    }
    .naslov {
        word-wrap: break-word;
        overflow-wrap: break-word;
    } 
    .btn{
        margin-left: 5px; 
    }
    .flex-container {
        display: flex;
        justify-content: space-between; 
        align-items: center; 
    }
    .search-input {
        width: 110px;
    }
    </style>

</head>

<body>

<div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content">
        <div>
            <h1>Lista odobrenih clanaka</h1>
        </div>
        <div class="flex-container">
            
        <form action='pregled_odobreni_clanci_urednik.php' method='get' class="search-form">
            <input type='text' name='pretragaNaslov' placeholder='Pretraga' class="search-input">
            <input type='submit' value='Pretraži clanke' class='btn'>
        </form>
        <input type="button" value="Napusti" onclick="window.location.href='naslovna.php'" class="btn">

        </div>
        
        <div>
           
            <?php
                
                if (isset($_GET['pretragaNaslov'])) {
                    $pretragaNaslov = $_GET['pretragaNaslov'];
                    $urednikId = isset($_SESSION['id_korisnika']) ? $_SESSION['id_korisnika'] : 0; 
                    $clanci = $konekcija->pretraziOdobreneClankeUrednikaPoNaslovu($pretragaNaslov, $urednikId);
                } else {
                    $urednikId = isset($_SESSION['id_korisnika']) ? $_SESSION['id_korisnika'] : 0; 
                    $clanci = $konekcija->getOdobreneVestiUrednika($urednikId);
                }
              
                if ($clanci != false) {
                    while ($clanak = $clanci->fetch_assoc()) {
                        echo "<div class='clanak-container'>
                        <h3 class='naslov'>Naslov: $clanak[naslov]</h3> 
                        <h3>Datum odobrenja: $clanak[datum_vreme_objave]</h3>
                        <a href='procitaj_clanak?id_vesti=$clanak[id_vesti]'><button>Pročitaj članak</button></a>
                        <button onclick=\"brisanjeClanaka($clanak[id_vesti])\">Brisanje članaka</button>
                    </div>";
                    }
                }
            ?>

    <script>
        function brisanjeClanaka(id_vesti) {
            var customDialog = document.createElement('div');
            customDialog.className = 'custom-dialog';
            customDialog.innerHTML = `
                <p>Da li ste sigurni da želite da obrišete clanak?</p>
                <button class="confirm-button" onclick="potvrdiBrisanje(${id_vesti})">Potvrdi</button>
                <button class="cancel-button" onclick="ponistiBrisanje()">Poništi</button>
            `;
            document.body.appendChild(customDialog);
        }

        function potvrdiBrisanje(id_vesti) {
            window.location.href = "brisanje_odobreni_clanci_urednik.php?id_vesti=" + id_vesti;
            ukloniCustomDialog();
        }

        function ponistiBrisanje() {
            ukloniCustomDialog();
        }

        function ukloniCustomDialog() {
            var customDialog = document.querySelector('.custom-dialog');
            if (customDialog) {
                customDialog.remove();
            }
        }
    </script>
        </div>
    </div>
</div>


    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
?>
