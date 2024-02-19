<?php


class ArrayHelpersTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function test__array_helpers__replace_array_key__replaces_a_key()
    {
        $oldKey = "old_key";
        $valueKey = "name";
        $value = 'the_value';
        $newKey = "new_key";

        $arr = [
            [
                $oldKey => [
                    [
                        $oldKey => [
                            [
                                $valueKey => $value
                            ]
                        ],
                    ]
                ],
            ]
        ];

        $newArr = replace_array_key($arr, $oldKey, $newKey);
        $this->assertEquals($value, $newArr[0][$newKey][0][$oldKey][0][$valueKey]);
    }

    /**
     * @test
     */
    public function test__array_helpers__replace_array_key__replaces_a_key_recursively()
    {
        $oldKey = "old_key";
        $valueKey = "name";
        $value = 'the_value';
        $newKey = "new_key";

        $arr = [
            [
                $oldKey => [
                    [
                        $oldKey => [
                            [
                                $valueKey => $value
                            ]
                        ],
                    ]
                ],
            ]
        ];

        $newArr = replace_array_key($arr, $oldKey, $newKey, true);
        $this->assertEquals($value, $newArr[0][$newKey][0][$newKey][0][$valueKey]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function test__array_helpers__array_key_by__converts_to_assoc_array_with_value_for_key()
    {
        $arr = [
            ['name' => 'john', 'age' => 45],
            ['name' => 'jane', 'age' => 32],
        ];

        $key = 'name';

        $result = array_key_by($arr, $key);

        foreach($arr as $index => $original) {
            $newKey = $arr[$index][$key];
            $this->assertEquals($result[$newKey][0]["age"], $arr[$index]["age"]);
        }
    }
}