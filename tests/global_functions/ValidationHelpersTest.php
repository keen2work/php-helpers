<?php


class ValidationHelpersTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function test__validation_helpers__check_all_present__throws_if_null()
    {
        $this->expectException(InvalidArgumentException::class);
        check_all_present("foo", null);
    }

    /**
     * @test
     */
    public function test__validation_helpers__check_all_present__throws_if_empty_array()
    {
        $this->expectException(InvalidArgumentException::class);
        check_all_present("foo", []);
    }

    /**
     * @test
     */
    public function test__validation_helpers__check_all_present__throws_if_blank_string()
    {
        $this->expectException(InvalidArgumentException::class);
        check_all_present("foo", "");
    }

    /**
     * @test
     */
    public function test__validation_helpers__check_all_present__throws_if_false()
    {
        $this->expectException(InvalidArgumentException::class);
        check_all_present("foo", "", false);
    }

    /**
     * @test
     */
    public function test__validation_helpers__check_all_present__does_not_throw()
    {
        check_all_present("foo", 1, true, ["foo" => "bar"]);
        $this->assertTrue(true);
    }
}