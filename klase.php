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

    // dodat deo koda zbog vracanja errora
   function obrisiNovinara($id_novinara) {
    // Obrisi povezane redove u novinar_rubrika
    $this->obrisiPovezaneRedoveNovinara($id_novinara);

    // Sada obrisi novinara
    $stm = $this->conn->prepare("DELETE FROM korisnici WHERE id_korisnika = ?");
    $stm->bind_param("i", $id_novinara);
    $stm->execute();
    }

    function obrisiPovezaneRedoveNovinara($id_novinara) {
        $stm = $this->conn->prepare("DELETE FROM novinar_rubrika WHERE id_novinara = ?");
        $stm->bind_param("i", $id_novinara);
        $stm->execute();
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

    function ubaciKorisnika($korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email)
    {
        $stmt = $this->conn->prepare("insert into korisnici (korisnicko_ime, lozinka, ime_prezime, uloga, email) values(?,?,?,?,?)");
        $stmt->bind_param("sssss", $korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email);
        $stmt->execute();
    }

    function ubaciRubrikuZaNovinara($id_novinara, $id_rubrike)
    {
        $stmt = $this->conn->prepare("insert into novinar_rubrika (id_novinara, id_rubrike) values(?,?)");
        $stmt->bind_param("ii", $id_novinara, $id_rubrike);
        $stmt->execute();
    }

    function getKorisnikByID($id_novinara)
    {
        $stmt = $this->conn->prepare("select * from korisnici where id_korisnika = ?");
        $stmt->bind_param("i", $id_novinara);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat->fetch_assoc();
        } else {
            return false;
        }
    }

    function getRubrikeByNovinarId($id_novinara)
    {
        $stmt = $this->conn->prepare("select * from novinar_rubrika where id_novinara=?");
        $stmt->bind_param("i", $id_novinara);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat;
        } else {
            return false;
        }
    }

    function getRubrikaByID($id_rubrike)
    {
        $stmt = $this->conn->prepare("select * from rubrika where id_rubrike = ?");
        $stmt->bind_param("i", $id_rubrike);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat->fetch_assoc();
        } else {
            return false;
        }
    }

    function azurirajKorisnika($id_korisnika, $korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email)
    {
        $stmt = $this->conn->prepare("update korisnici set korisnicko_ime = ?, lozinka = ?, ime_prezime = ?, uloga = ?, email = ? where id_korisnika = ?");
        $stmt->bind_param("sssssi", $korisnicko_ime, $lozinka, $ime_prezime, $uloga, $email, $id_korisnika);
        $stmt->execute();
    }

    function ubaciUrednikRubrika($id_urednika, $id_rubrike)
    { {
            $stmt = $this->conn->prepare("insert into urednik_rubrika (id_urednika, id_rubrike) values(?,?)");
            $stmt->bind_param("ii", $id_urednika, $id_rubrike);
            $stmt->execute();
        }
    }
    function getRubrikeByUrednikId($id_urednika)
    {
        $stmt = $this->conn->prepare("select * from urednik_rubrika where id_urednika=?");
        $stmt->bind_param("i", $id_urednika);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }

    function obrisiUrednika($id_urednika) {
        // Obrisi povezane redove u urednik_rubrika
        $this->obrisiPovezaneRedoveUrednika($id_urednika);
    
        // Sada obrisi urednika
        $stm = $this->conn->prepare("DELETE FROM korisnici WHERE id_korisnika = ?");
        $stm->bind_param("i", $id_urednika);
        $stm->execute();
    }
    
    function obrisiPovezaneRedoveUrednika($id_urednika) {
        $stm = $this->conn->prepare("DELETE FROM urednik_rubrika WHERE id_urednika = ?");
        $stm->bind_param("i", $id_urednika);
        $stm->execute();
    }
    

      function getSviUrednici()
    {
        $stmt = $this->conn->prepare("SELECT * FROM korisnici WHERE uloga = 'urednik'");
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
}

$konekcija = new Konekcija("localhost", "root", "", "branko_novine");
session_start();
