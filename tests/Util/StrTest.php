<?php


use EMedia\PHPHelpers\Util\Str;

class StrTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function test_Str_textToLines_converts_str_into_array()
    {
        $strings = [
            "one\ntwo" => ["one", "two"],
            "one, two,   three
four
five" => ["one", "two", "three", "four", "five"],
            "onetwo" => ["onetwo"],
            "" => [],
            "," => []
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals(Str::textToLinesArray($string), $result);
        }

    }
}
