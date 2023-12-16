<?php
class Konekcija{
    private $host;
    private $username;
    private $password;
    private $db;
    private $conn;

    function __construct($host,$username,$password,$db){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->db);

        mysqli_set_charset($this->conn, 'utf8');
    }
    function getKorisnik( $korisnicko_ime, $lozinka){

        $stm = $this->conn->prepare("SELECT * FROM korisnici WHERE korisnicko_ime=? AND lozinka=?");
        $stm->bind_param("ss", $korisnicko_ime, $lozinka);//baindovanje parametara
        $stm->execute();
        $rezultat=$stm->get_result(); //rezultat jos nije upotrebljiv
        //a ko broj redova ima vise od 0 znaci da je pronasao i treba asocijativni niz da napravi
        if($rezultat->num_rows> 0){ 
            $korisnik = $rezultat->fetch_assoc();
            return $korisnik;
        }
        else{
            return false;
        }
    }
}


$konekcija = new Konekcija('localhost','root','','branko_novine');
session_start();

?>

