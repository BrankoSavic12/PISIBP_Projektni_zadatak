<?php
require_once '../administracija/klase.php'; 
use PHPUnit\Framework\TestCase;

class TestDislajkujVest extends TestCase {
    
    public function testDislajkujVest() {
        $konekcijaMock = $this->getMockBuilder(Konekcija::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $konekcijaMock->expects($this->once())
                      ->method('povecajNegativne')
                      ->with($this->anything());

        $this->processVote($konekcijaMock);

        $this->expectOutputString("Location: vest.php?id_vesti=123&dislajk=1");
    }

    private function processVote($konekcija) {
        $_GET["id_vesti"] = 123;

        $id_vesti = $_GET["id_vesti"];
        $konekcija->povecajNegativne($id_vesti);

        ob_start();
        header("Location: vest.php?id_vesti=$id_vesti&dislajk=1");
        $output = ob_get_clean();
        echo $output;
    }
}

