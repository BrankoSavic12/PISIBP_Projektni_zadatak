<?php
include("klase.php") ;
if(isset($_POST["submit"])){
    $username = isset($_POST["username"]) ? $_POST["username"] : '';
    $password =md5($_POST["password"]);
    $korisnik = $konekcija->getKorisnik($username, $password);
    if($korisnik != false){
        $_SESSION["id_korisnika"]= $korisnik["id_korisnika"];
        $_SESSION["uloga"]= $korisnik["uloga"];
        $_SESSION["ime_prezime"]= $korisnik["ime_prezime"];
        header("Location: naslovna.php");

    }
    else{
        $greska = "Pogresno uneti korisnicko ime ili lozinka!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administarcija - Login</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="text" name="username" placeholder="username" required>
        <input type="password" name="password" placeholder="password" required>
        <label>
            <?php 
                if (isset($greska)){
                    echo "$greska";
                }
            ?>
        </label>
        <input type="submit" value="Ulogujte se" name="submit">
    </form>
</body>
</html>
