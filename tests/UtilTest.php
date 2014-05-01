<?php

use \Lethe\Json\Util;

class UtilTest extends PHPUnit_Framework_TestCase
{

    public function testStripJsonComments()
    {
        $this->assertEquals(Util::stripJsonComments("//comment\n{\"a\":\"b\"}"), "\n{\"a\":\"b\"}");
        $this->assertEquals(Util::stripJsonComments("/*//comment*/{\"a\":\"b\"}"), "{\"a\":\"b\"}");
        $this->assertEquals(Util::stripJsonComments("{\"a\":\"b\"//comment\n}"), "{\"a\":\"b\"\n}");
        $this->assertEquals(Util::stripJsonComments("{\"a\":\"b\"/*comment*/}"), "{\"a\":\"b\"}");
        $this->assertEquals(Util::stripJsonComments("{\"a\"/*\n\n\ncomment\r\n*/:\"b\"}"), "{\"a\":\"b\"}");
    }

    public function testNotStripCommentsInsideStrings()
    {
        $this->assertEquals(Util::stripJsonComments("{\"a\":\"b//c\"}"), "{\"a\":\"b//c\"}");
        $this->assertEquals(Util::stripJsonComments("{\"a\":\"b/*c*/\"}"), "{\"a\":\"b/*c*/\"}");
        $this->assertEquals(Util::stripJsonComments("{\"/*a\":\"b\"}"), "{\"/*a\":\"b\"}");
        $this->assertEquals(Util::stripJsonComments("{\"\\\"/*a\":\"b\"}"), "{\"\\\"/*a\":\"b\"}");
    }

}
