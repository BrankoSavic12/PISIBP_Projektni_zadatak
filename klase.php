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
    function obrisiNovinara($id_novinara)
    {
        // Obrisi povezane redove u novinar_rubrika
        $this->obrisiPovezaneRedoveNovinara($id_novinara);

        // Sada obrisi novinara
        $stm = $this->conn->prepare("DELETE FROM korisnici WHERE id_korisnika = ?");
        $stm->bind_param("i", $id_novinara);
        $stm->execute();
    }

    function obrisiPovezaneRedoveNovinara($id_novinara)
    {
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
    {
        $stmt = $this->conn->prepare("insert into urednik_rubrika (id_urednika, id_rubrike) values(?,?)");
        $stmt->bind_param("ii", $id_urednika, $id_rubrike);
        $stmt->execute();
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

    function obrisiUrednika($id_urednika)
    {
        $this->obrisiVezuUrednikRubrika($id_urednika);
        $this->obrisiVezuNovinarRubrika($id_urednika);
        $stm = $this->conn->prepare("DELETE FROM korisnici WHERE id_korisnika = ?");
        $stm->bind_param("i", $id_urednika);
        $stm->execute();
    }
    function obrisiVezuUrednikRubrika($id_urednika)
    {
        $stm = $this->conn->prepare("DELETE FROM urednik_rubrika WHERE id_urednika = ?");
        $stm->bind_param("i", $id_urednika);
        $stm->execute();
    }
    function obrisiVezuNovinarRubrika($id_urednika)
    {
        $stm = $this->conn->prepare("DELETE FROM novinar_rubrika WHERE id_novinara = ?");
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
    function getGlavniUrednik()
    {
        $stmt = $this->conn->prepare("SELECT * FROM korisnici WHERE uloga = 'glavni urednik'");
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat;
        } else {
            return false;
        }
    }

    function getUredniciByRubrikaId($id_rubrike)
    {
        $stmt = $this->conn->prepare("SELECT korisnici.* FROM korisnici
            WHERE korisnici.id_korisnika IN (SELECT id_urednika FROM urednik_rubrika WHERE id_rubrike = ?)");
        $stmt->bind_param("i", $id_rubrike);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }


    function obrisiRubriku($id_rubrike)
    {
        // Prvo obrisi povezane redove u novinar_rubrika
        $this->obrisiPovezaneRedoveRubrike($id_rubrike);

        // Zatim obrisi rubriku
        $stmt = $this->conn->prepare("DELETE FROM rubrika WHERE id_rubrike = ?");
        $stmt->bind_param("i", $id_rubrike);
        $stmt->execute();
    }


    function obrisiPovezaneRedoveRubrike($id_rubrike)
    {
        $stmt = $this->conn->prepare("DELETE FROM novinar_rubrika WHERE id_rubrike = ?");
        $stmt->bind_param("i", $id_rubrike);
        $stmt->execute();
    }


    function ubaciRubriku($naziv)
    {
        $stmt = $this->conn->prepare("INSERT INTO rubrika (naziv) VALUES (?)");
        $stmt->bind_param("s", $naziv);
        $stmt->execute();
    }
    function proveriPostojanjeRubrike($naziv)
    {
        $stmt = $this->conn->prepare("select * from rubrika where naziv = ?");
        $stmt->bind_param("s", $naziv);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat->fetch_assoc();
        } else {
            return false;
        }
    }

    function getRubrikaInfo($id_rubrike)
    {
        $rubrika = $this->getRubrikaByID($id_rubrike);

        if ($rubrika) {
            $urednici = $this->getUredniciByRubrikaId($id_rubrike);

            return [
                'ime_rubrike' => $rubrika['naziv'],
                'urednici' => $urednici
            ];
        }

        return false;
    }
    function proveriDodeluRubrikeUredniku($id_urednika, $id_rubrike)
    {
        $upit = "SELECT * FROM urednik_rubrika WHERE id_urednika = ? AND id_rubrike = ?";
        $stmt = $this->conn->prepare($upit);
        $stmt->bind_param("ii", $id_urednika, $id_rubrike);
        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat && $rezultat->num_rows > 0) {
            return true; // Rubrika je već dodeljena uredniku
        } else {
            return false; // Rubrika nije dodeljena uredniku
        }
    }

    function proveriDodeluRubrikeNovinaru($id_novinara, $id_rubrike)
    {
        $upit = "SELECT * FROM novinar_rubrika WHERE id_novinara = ? AND id_rubrike = ?";
        $stmt = $this->conn->prepare($upit);
        $stmt->bind_param("ii", $id_novinara, $id_rubrike);
        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat && $rezultat->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function ukloniRubrikuUredniku($id_urednika, $id_rubrike)
    {
        $stmt = $this->conn->prepare("DELETE FROM urednik_rubrika WHERE id_urednika = ? AND id_rubrike = ?");
        $stmt->bind_param("ii", $id_urednika, $id_rubrike);
        $stmt->execute();
    }
    function ukloniRubrikuNovinaru($id_novinara, $id_rubrike)
    {
        $stmt = $this->conn->prepare("DELETE FROM novinar_rubrika WHERE id_novinara = ? AND id_rubrike = ?");
        $stmt->bind_param("ii", $id_novinara, $id_rubrike);
        $stmt->execute();
    }


    function unesiClanak($id_novinara, $id_rubrike, $naslov, $sadrzaj, $datum_vreme, $status)
    {
        $stmt = $this->conn->prepare("INSERT INTO vest (naslov, sadrzaj, id_rubrike, status, datum_vreme_objave, id_novinara) values (?,?,?,?,?,?)");
        $stmt->bind_param("ssissi", $naslov, $sadrzaj, $id_rubrike, $status, $datum_vreme, $id_novinara);
        $stmt->execute();
    }

    function getSveVesti()
    {
        $stmt = $this->conn->prepare("select * from vest");
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {

            return $rezultat;
        } else {
            return false;
        }
    }
    function getNovinariByImePrezime($pretraga)
    {
        $pretraga = $this->conn->real_escape_string($pretraga);
        $stmt = $this->conn->prepare("SELECT * FROM korisnici WHERE uloga = 'novinar' AND ime_prezime LIKE ?");

        // Dodajemo % na početak i kraj pretrage kako bismo pronašli delimične podudarnosti
        $pretraga = "%" . $pretraga . "%";

        $stmt->bind_param("s", $pretraga);

        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
    function getUredniciByImePrezime($pretraga)
    {
        $pretraga = $this->conn->real_escape_string($pretraga);
        $stmt = $this->conn->prepare("SELECT * FROM korisnici WHERE uloga = 'urednik' AND ime_prezime LIKE ?");

        // Dodajemo % na početak i kraj pretrage kako bismo pronašli delimične podudarnosti
        $pretraga = "%" . $pretraga . "%";

        $stmt->bind_param("s", $pretraga);

        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
    function getRubrikeByNaziv($naziv)
    {
        $naziv = $this->conn->real_escape_string($naziv);
        $stmt = $this->conn->prepare("SELECT * FROM rubrika WHERE naziv LIKE ?");

        // Dodajemo % na početak i kraj pretrage kako bismo pronašli delimične podudarnosti
        $naziv = "%" . $naziv . "%";

        $stmt->bind_param("s", $naziv);

        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }

    function getSveClankeNovinara($id_novinara, $status)
    {
        $stmt = $this->conn->prepare("SELECT * from vest where id_novinara = ? and status = ?  order by datum_vreme_objave desc");
        $stmt->bind_param("is", $id_novinara, $status);
        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }

    function getClanakByID($id_vesti)
    {
        $stmt = $this->conn->prepare("SELECT * from vest where id_vesti = ?");
        $stmt->bind_param("i", $id_vesti);
        $stmt->execute();

        $rezultat = $stmt->get_result();

        if ($rezultat->num_rows > 0) {
            return $rezultat->fetch_assoc();
        } else {
            return false;
        }
    }

    function azurirajClanak($id_rubrike, $naslov, $sadrzaj, $status, $datum_vreme, $id_vesti)
    {
        $stmt = $this->conn->prepare("update vest set naslov = ?, sadrzaj = ?, id_rubrike = ?, datum_vreme_objave= ?, status = ? where id_vesti = ?");
        $stmt->bind_param("ssissi", $naslov, $sadrzaj, $id_rubrike, $datum_vreme, $status, $id_vesti);
        $stmt->execute();
    }

    function posaljiZahtev($id_vesti, $id_novinara, $id_rubrike, $vrsta)
    {
        $stmt = $this->conn->prepare("insert into zahtevi (id_vesti, id_rubrike, id_novinara, vrsta) value (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $id_vesti, $id_rubrike, $id_novinara, $vrsta);
        $stmt->execute();
    }

    function izmeniStatusVesti($id_vesti, $status)
    {
        $stmt = $this->conn->prepare("update vest set status = ? where id_vesti = ?");
        $stmt->bind_param("si", $status, $id_vesti);
        $stmt->execute();
    }

    function getOdovreneVestiByUrednik($id_urednika)
    {
        $stmt = $this->conn->prepare("select * from vest where id_urednika = ? order by datum_vreme_objave desc");
        $stmt->bind_param("i", $id_urednika);
        $stmt->execute();

        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }

    function getVestiByRubrika($id_rubrike)
    {
        $stmt = $this->conn->prepare("select * from vest where id_rubrike = ? order by datum_vreme_objave desc");
        $stmt->bind_param("i", $id_rubrike);
        $stmt->execute();

        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }

    function odobriVest($id_vesti, $datum_vreme, $id_urednika, $status)
    {
        $stmt = $this->conn->prepare("update vest set datum_vreme_objave = ?, id_urednika = ?, status = ? where id_vesti = ?");
        $stmt->bind_param("sisi", $datum_vreme, $id_urednika, $status, $id_vesti);
        $stmt->execute();
    }
    function obrisiVest($id_vesti)
    {
        $stm = $this->conn->prepare("DELETE FROM vest WHERE id_vesti = ?");
        $stm->bind_param("i", $id_vesti);
        $stm->execute();
    }
    function pretraziClankeNaCekanjuPoNaslovu($pretragaNaslov, $novinarId)
    {
        $pretragaNaslov = $this->conn->real_escape_string($pretragaNaslov);
        $stmt = $this->conn->prepare("SELECT * FROM vest WHERE status = 'na čekanju' AND id_novinara = ? AND naslov LIKE ?");
        
        $pretragaNaslov = "%" . $pretragaNaslov . "%";
    
        $stmt->bind_param("is", $novinarId, $pretragaNaslov);
    
        $stmt->execute();
    
        $rezultat = $stmt->get_result();
    
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
    
    function getVestiNaCekanju($novinarId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM vest WHERE status = 'na čekanju' AND id_novinara = ?");
        $stmt->bind_param("i", $novinarId);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
    function pretraziOdobreneClankePoNaslovu($pretragaNaslov, $novinarId)
    {
        $pretragaNaslov = $this->conn->real_escape_string($pretragaNaslov);
        $stmt = $this->conn->prepare("SELECT * FROM vest WHERE status = 'odobrena' AND id_novinara = ? AND naslov LIKE ?");
        
        $pretragaNaslov = "%" . $pretragaNaslov . "%";
    
        $stmt->bind_param("is", $novinarId, $pretragaNaslov);
    
        $stmt->execute();
    
        $rezultat = $stmt->get_result();
    
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
    
    function getOdobreneVesti($novinarId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM vest WHERE status = 'odobrena' AND id_novinara = ?");
        $stmt->bind_param("i", $novinarId);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }

    function pretraziDraftClankePoNaslovu($pretragaNaslov, $novinarId)
    {
        $pretragaNaslov = $this->conn->real_escape_string($pretragaNaslov);
        $stmt = $this->conn->prepare("SELECT * FROM vest WHERE status = 'draft' AND id_novinara = ? AND naslov LIKE ?");
        
        $pretragaNaslov = "%" . $pretragaNaslov . "%";
    
        $stmt->bind_param("is", $novinarId, $pretragaNaslov);
    
        $stmt->execute();
    
        $rezultat = $stmt->get_result();
    
        if ($rezultat->num_rows > 0) {
            return $rezultat;
        } else {
            return false;
        }
    }
    
    function getDraftVesti($novinarId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM vest WHERE status = 'draft' AND id_novinara = ?");
        $stmt->bind_param("i", $novinarId);
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
