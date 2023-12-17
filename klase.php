<?php
class Konekcija
{
    private $host;
    private $username;
    private $password;
    private $db;
    private $conn;

    function __construct($host, $username, $password, $db)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);

        mysqli_set_charset($this->conn, 'utf8');
    }

    function getKorisnik($korisnicko_ime, $lozinka)
    {
        $stmt = $this->conn->prepare("SELECT * FROM korisnici WHERE korisnicko_ime=? AND lozinka=?");
        $stmt->bind_param("ss", $korisnicko_ime, $lozinka);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            $korisnik = $rezultat->fetch_assoc();
            return $korisnik;
        } else {
            return false;
        }
    }

    function getSviNovinari()
    {
        $stmt = $this->conn->prepare("select * from korisnici where uloga = 'novinar'");
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat;
        } else {
            return false;
        }
    }

    function obrisiNovinara($id_novinara)
    {
        // Prvo obrišite povezane redove iz novinar_rubrika
        $stmt1 = $this->conn->prepare("DELETE FROM novinar_rubrika WHERE id_novinara = ?");
        $stmt1->bind_param("i", $id_novinara);
        $stmt1->execute();
    
        // Zatim obrišite novinara
        $stmt2 = $this->conn->prepare("DELETE FROM korisnici WHERE id_korisnika = ?");
        $stmt2->bind_param("i", $id_novinara);
        $stmt2->execute();
    }

    function getSveRubrike()
    {
        $stmt = $this->conn->prepare("select * from rubrika");
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat;
        } else {
            return false;
        }
    }

    function proveriPostojanjeKorisnickogImena($korisnicko_ime)
    {
        $stmt = $this->conn->prepare("select * from korisnici where korisnicko_ime = ?");
        $stmt->bind_param("s", $korisnicko_ime);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat->fetch_assoc();
        } else {
            return false;
        }
    }

    function ubaciKorisnika($korisnicko_ime, $lozinka, $ime_prezime, $uloga)
    {
        $stmt = $this->conn->prepare("insert into korisnici (korisnicko_ime, lozinka, ime_prezime, uloga) values(?,?,?,?)");
        $stmt->bind_param("ssss", $korisnicko_ime, $lozinka, $ime_prezime, $uloga);
        $stmt->execute();
    }

    function ubaciRubrikuZaNovinara($id_novinara, $id_rubrike)
    {
        $stmt = $this->conn->prepare("insert into novinar_rubrika (id_novinara, id_rubrike) values(?,?)");
        $stmt->bind_param("ii", $id_novinara, $id_rubrike);
        $stmt->execute();
    }
}

$konekcija = new Konekcija("localhost", "root", "", "branko_novine");
session_start();

