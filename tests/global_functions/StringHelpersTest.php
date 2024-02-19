<?php


class StringHelpersTest extends \PHPUnit\Framework\TestCase
{
    /** 
     * @test
     */
    public function test__string_helpers__reverse_snake_case__separates_into_words()
    {
        $strings = [
            'foo' => 'foo',
            'foo_bar' => 'foo bar',
            'Bar_Baz' => 'Bar Baz',
            '_quex' => ' quex',
            0 => '0',
            null => ''
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals(reverse_snake_case($string), $result);
        }
    }

    /**
     * @test
     */
    public function test__string_helpers__random_unambiguous__generates_string_of_length()
    {
        $lengths = [0, 10, 16];

        foreach ($lengths as $length) {
            $this->assertEquals(strlen(random_unambiguous($length)), $length);
        }
    }

    /**
     * @test
     */
    public function test__string_helpers__random_unambiguous__generates_a_billion_unique_strings()
    {
        $loop = 1000000000;
        $results = [];
        for ($i = 0; $i < $loop; $i++) {
            $i = random_unambiguous("8");
            $this->assertNotContains($i, $results);
            $results[] = $i;
        }
    }

    /**
     * @test
     */
    public function test__string_helpers__str_with_trailing_slash__appends_a_slash()
    {
        $strings = [
            'foo' => 'foo/',
            'bar/' => 'bar/',
            '/baz/fizz.' => '/baz/fizz./',
            '' => '/'
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals($result, str_with_trailing_slash($string));
        }
    }

    /**
     * @test
     */
    public function test__string_helpers__str_without_trailing_slash__removes_a_trailing_slash()
    {
        $strings = [
            'foo' => 'foo',
            'bar/' => 'bar',
            '/baz/fizz' => '/baz/fizz',
            '/' => ''
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals($result, str_without_trailing_slash($string));
        }
    }

    /**
     * @test
     */
    public function test__string_helpers__str_without_trailing_slash__removes_a_leading_slash()
    {
        $strings = [
            'foo' => 'foo',
            '/bar/' => 'bar/',
            '/baz/fizz' => 'baz/fizz',
            '/' => ''
        ];

        foreach ($strings as $string => $result) {
            $this->assertEquals($result, str_without_leading_slash($string));
        }
    }


}