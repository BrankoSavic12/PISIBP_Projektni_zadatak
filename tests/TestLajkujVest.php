<?php
require_once '../administracija/klase.php'; 
use PHPUnit\Framework\TestCase;

class TestLajkujVest extends TestCase {
    
    public function testLajkujVest() {
        $konekcijaMock = $this->getMockBuilder(Konekcija::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $konekcijaMock->expects($this->once())
                      ->method('povecajPozitivne')
                      ->with($this->anything());

        $this->processVote($konekcijaMock);

        $this->expectOutputString("Location: vest.php?id_vesti=123&lajk=1");
    }

    private function processVote($konekcija) {
        $_GET["id_vesti"] = 123;

        $id_vesti = $_GET["id_vesti"];
        $konekcija->povecajPozitivne($id_vesti);

        ob_start();
        header("Location: vest.php?id_vesti=$id_vesti&lajk=1");
        $output = ob_get_clean();
        echo $output;
    }
}


