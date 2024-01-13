<?php
include "klase.php";
if (isset($_SESSION["id_korisnika"])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacije o radnicima</title>
    <link rel="stylesheet" href="style.css">
    <style>
     
        .urednik-info {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>

</head>

<body>

<div class="navigacija">
    <?php include "menu.php" ?>
    <div class="content">
    <div>
    <h1>Informacije o radnicima</h1>
    </div>
    <h2><a href="naslovna.php" class="back-link">Napusti stranicu</a></h2>
    <div class="info-container" style="max-width: 400px;">
        <?php   

            $glavniUrednici = $konekcija->getGlavniUrednik();
            while($glavniUrednik = $glavniUrednici->fetch_assoc()) {
                echo "<div class='urednik-info'>";
                echo "<h2>Glavni urednik: $glavniUrednik[ime_prezime]</h2>";
                echo "<h2>$glavniUrednik[email]</h2>";
                echo "</div>";
}
           $urednici = $konekcija->getSviUrednici();
           while($urednik = $urednici->fetch_assoc()) {
               echo "<div class='urednik-info'>";
               echo "<h2>Urednik: $urednik[ime_prezime]</h2>";
               echo "<h2>$urednik[email]</h2>";
               echo "</div>";
           }
           
           $novinari = $konekcija->getSviNovinari();
           while($novinar = $novinari->fetch_assoc()) {
               echo "<div class='urednik-info'>";
               echo "<h2>Novinar: $novinar[ime_prezime]</h2>";
               echo "<h2>$novinar[email]</h2>";
               echo "</div>";
           }
          
           
        
        ?>
     
    </body>

    </html>
<?php
} else {
    header("location:index.php");
}
?>