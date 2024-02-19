<?php


class TypeCastSizesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function test_ConvertSizes_convertToInteger_convertsToWholeNumber()
    {
        $strings = [
            '1' => 1,
            '2.8' => 3,
            0 => false,
            null => false,
            'foo' => 0
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals($result, \EMedia\PHPHelpers\Util\TypeCast::convertToInteger($string));
        }
    }

    /**
     * @test
     */
    public function test_ConvertSizes_convertToFloat_convertsToFloat()
    {
        $strings = [
            '1' => 1,
            '2.8' => 2.8,
            '1.245' => 1.245,
            '1,000.50' => 1000.5,
            null => false,
            'foo' => 0
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals($result, \EMedia\PHPHelpers\Util\TypeCast::convertToFloat($string));
        }
    }
}