<?php
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase {
    public function testSum() {
        $result = 2 + 2;
        $this->assertEquals(4, $result);
    }

    public function testStringLength() {
        $string = "Hello, world!";
        $length = strlen($string);
        $this->assertEquals(13, $length);
    }

    public function testArrayHasKey() {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $this->assertArrayHasKey('b', $array);
    }
}
?>
