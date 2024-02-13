<?php

require_once 'D:/WampNovi/www/PISIBP_Projektni_zadatak/administracija/klase.php';

use PHPUnit\Framework\TestCase;

class TestOdobriVest extends TestCase {
    
    public function testOdobriVest() {
        $konekcijaMock = $this->getMockBuilder(Konekcija::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        
        $konekcijaMock->expects($this->once())
                      ->method('odobriVest')
                      ->with($this->anything(), $this->anything(), $this->anything(), $this->anything())
                      ->willReturn(true);

        $this->assertTrue($this->odobriVest($konekcijaMock));
    }

    private function odobriVest($konekcija) {
        $id_vesti = 12;
        $datum_vreme = "2024-02-09 10:00:00";
        $id_urednika = 4;
        $status = "odobrena";

        return $konekcija->odobriVest($id_vesti, $datum_vreme, $id_urednika, $status);
    }
}



