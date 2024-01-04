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
    <div class="info-container">
        
            <h1>Informacije o svim radnicima</h1>
    
        <?php   

            $glavniUrednici = $konekcija->getGlavniUrednik();
            while($glavniUrednik = $glavniUrednici->fetch_assoc()) {
                echo "<div class='urednik-info'>";
                echo "<h3>Glavni urednik: $glavniUrednik[ime_prezime]</h3>";
                echo "<h3>$glavniUrednik[email]</h3>";
                echo "</div>";
}
           $urednici = $konekcija->getSviUrednici();
           while($urednik = $urednici->fetch_assoc()) {
               echo "<div class='urednik-info'>";
               echo "<h3>Urednik: $urednik[ime_prezime]</h3>";
               echo "<h3>$urednik[email]</h3>";
               echo "</div>";
           }
           
           $novinari = $konekcija->getSviNovinari();
           while($novinar = $novinari->fetch_assoc()) {
               echo "<div class='urednik-info'>";
               echo "<h3>Novinar: $novinar[ime_prezime]</h3>";
               echo "<h3>$novinar[email]</h3>";
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