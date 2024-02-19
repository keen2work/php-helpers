<?php


class ConvertSizesTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function test_ConvertSizes_bytesToHumans_converts_to_2_decimals()
    {
        $bytes = [
            200 => '200 B',
            800000 => '781.25 KB',
            0 => '0 B',
            10000000 => '9.54 MB',
            9999999999 => '9.31 GB',
            8888888888888 => '8.08 TB'
        ];

        foreach ($bytes as $byte => $result) {
            $this->assertEquals(\EMedia\PHPHelpers\Util\ConvertSizes::bytesToHumans($byte), $result);
        }
    }

    /**
     * @test
     */
    public function test_ConvertSizes_bytesToHumans_converts_to_whole_number()
    {
        $bytes = [
            200 => '200 B',
            0 => '0 B',
            10000000 => '10 MB',
            9999999999 => '9 GB',
            8888888888888 => '8 TB'
        ];

        foreach ($bytes as $byte => $result) {
            $this->assertEquals(\EMedia\PHPHelpers\Util\ConvertSizes::bytesToHumans($byte, 0), $result);
        }
    }

}