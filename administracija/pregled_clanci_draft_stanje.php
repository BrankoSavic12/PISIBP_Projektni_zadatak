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
            <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>
            <div class="info-container" style="width:auto">
        
            <?php
                 if (isset($_SESSION['id_korisnika'])) {
                    $novinarId = $_SESSION['id_korisnika'];
                    $clanci = $konekcija->getDraftVesti($novinarId);
                 }
                
                if ($clanci != false) {
                    while ($clanak = $clanci->fetch_assoc()) {
                        echo "<div class='clanak-container'>
                                <h2 class='naslov'>Naslov: $clanak[naslov]</h2> 
                                <h2>Datum: $clanak[datum_vreme_objave]</h2>
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
                <h2>Da li ste sigurni da želite da obrišete clanak?</h2>
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