<?php
namespace Baijian\Algorithm;

use Baijian\Algorithm\AhoCorasick;

class AhoCorasickTest extends \PHPUnit_Framework_TestCase {

    public function testEmpty() {
        $stack = array();
        $this->assertEmpty($stack);
        return $stack;
    }
}
