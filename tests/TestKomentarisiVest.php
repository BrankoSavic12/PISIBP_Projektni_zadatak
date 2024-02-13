<?php
require_once '../administracija/klase.php'; 

use PHPUnit\Framework\TestCase;

class TestKomentarisiVest extends TestCase {
    
    public function testKomentarisanje() {
        $konekcijaMock = $this->getMockBuilder(Konekcija::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        
        $konekcijaMock->expects($this->once())
                      ->method('unesiKomentar')
                      ->with(
                          $this->anything(),
                          $this->anything(),
                          $this->anything()
                      );

        $this->obradiKomentarisanje($konekcijaMock);
    }

    private function obradiKomentarisanje($konekcija) {
        $_POST["citalac"] = "Testni korisnik";
        $_POST["sadrzaj"] = "Ovo je testni komentar.";

        $_GET["id_vesti"] = 123;

        $id_vesti = $_GET["id_vesti"];
        $citalac = $_POST["citalac"];
        $sadrzaj = $_POST["sadrzaj"];

        $konekcija->unesiKomentar($id_vesti, $citalac, $sadrzaj);

        $this->expectOutputString("<h3>Vaš komentar je unet</h3>");
        include_once('vest.php');

        $komentari = $konekcija->getKomentariByVestId($id_vesti);
        $this->assertNotEmpty($komentari);

        $found = false;
        foreach ($komentari as $komentar) {
            if ($komentar['citalac'] === $citalac && $komentar['sadrzaj'] === $sadrzaj) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }
}

