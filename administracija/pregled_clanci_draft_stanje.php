<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled clanaka u draft stanju</title>
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
            width: 160px;
        }


    </style>

</head>

<body>

<div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content">
        <div>
            <h1>Lista clanaka u draft stanju</h1>
        </div>
        <div class="flex-container">
            
        <form action='pregled_clanci_draft_stanje.php' method='get' class="search-form">
            <input type='text' name='pretragaNaslov' placeholder='Pretraga po naslovu' class="search-input">
            <input type='submit' value='Pretraži' class='btn'>
        </form>
        <input type="button" value="Napusti" onclick="window.location.href='naslovna.php'" class="btn">

        </div>
        <div>
           
            <?php
                
                if (isset($_GET['pretragaNaslov'])) {
                    $pretragaNaslov = $_GET['pretragaNaslov'];
                    $novinarId = isset($_SESSION['id_korisnika']) ? $_SESSION['id_korisnika'] : 0; // Postavi default vrednost na 0 ili prilagodi prema potrebi
                    $clanci = $konekcija->pretraziDraftClankePoNaslovu($pretragaNaslov, $novinarId);
                } else {
                    $novinarId = isset($_SESSION['id_korisnika']) ? $_SESSION['id_korisnika'] : 0; // Postavi default vrednost na 0 ili prilagodi prema potrebi
                    $clanci = $konekcija->getDraftVesti($novinarId);
                }
                
                
                if ($clanci != false) {
                    while ($clanak = $clanci->fetch_assoc()) {
                        echo "<div class='clanak-container'>
                                <h3 class='naslov'>Naslov: $clanak[naslov]</h3> 
                                <h3>Datum: $clanak[datum_vreme_objave]</h3>
                                <a href='procitaj_clanak?id_vesti=$clanak[id_vesti]'><button>Pročitaj</button></a>
                                <a href='izmeni_draft_clanak?id_vesti=$clanak[id_vesti]'><button>Izmeni</button></a>
                                <button onclick=\"brisanjeClanaka($clanak[id_vesti])\">Obrši</button>
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
            window.location.href = "brisanje_draft_clanci.php?id_vesti=" + id_vesti;
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
