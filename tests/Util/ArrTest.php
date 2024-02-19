<?php


use EMedia\PHPHelpers\Util\Arr;

class ArrTest extends \PHPUnit\Framework\TestCase
{

	public function test_Arr_intersectRecursive_simple_subset_match_1()
	{
		$input = [
			'payload' => [
				[
					'item' => 'item 1',
					'desc' => 'desc',
				]
			]
		];

		$subset = [
			'payload' => [
				[
					'item' => 'item 1',
					'desc' => 'desc',
				]
			]
		];

		$response = Arr::intersectRecursive($input, $subset);

		self::assertTrue($response == $subset);
	}

	public function test_Arr_intersectRecursive_simple_subset_match_2()
	{
		$input = [
			'payload' => [
				[
					'item' => 'item 1',
					'desc' => 'desc',
				],
				[
					'item' => 'item 2',
					'desc' => 'desc',
				],
				[
					'item' => 'item 3',
					'desc' => 'desc',
				]
			]
		];

		$subset = [
			'payload' => [
				[
					'item' => 'item 2',
					'desc' => 'desc',
				],
			]
		];

		$response = Arr::intersectRecursive($input, $subset);

		self::assertTrue($response == $subset);
	}

	public function test_Arr_intersectRecursive_simple_subset_match_3()
	{
		$input = [
			'payload' => [
				[
					'item' => 'item 1',
					'desc' => 'desc',
				],
				[
					'item' => 'item 2',
					'desc' => 'desc',
				],
				[
					'item' => 'item 3',
					'desc' => 'desc',
				]
			]
		];

		$subset = [
			'payload' => [
				[
					'item' => 'item 2',
				],
			]
		];

		$response = Arr::intersectRecursive($input, $subset);
		self::assertTrue($response == $subset);
	}

	public function test_Arr_intersectRecursive_simple_subset_match_4()
	{
		$input = [
			'payload' => [
				[
					'item' => 'item 1',
					'desc' => 'desc',
					'is_read' => true,
				],
				[
					'item' => 'SENT_SINGLE_DEVICE_SEED_NOTIFICATION_2',
					'is_read' => false,
					'badge_count' => '',
				],
				[
					'item' => 'item 3',
					'desc' => 'desc',
				]
			]
		];

		$subset = [
			'payload' => [
				[
					'item' => 'SENT_SINGLE_DEVICE_SEED_NOTIFICATION_2',
					'is_read' => true,
				],
			]
		];

		$response = Arr::intersectRecursive($input, $subset);

		self::assertFalse($response == $subset);
	}

	public function test_isAssocArray_detects_assoc_array()
	{
		$array = [
			'one' => 1,
			'two' => 2,
		];
		$result = Arr::isAssocArray($array);

		self::assertTrue($result);

		$array = [
			1, 2, 4
		];
		$result = Arr::isAssocArray($array);

		self::assertFalse($result);
	}
	
	/** 
	 * @test
	 */
	public function test_Arr_intersectRecursive_checks_single_key()
	{
        $arr = [
            [
                "name" => "john",
            ]
        ];

        $subset = [
            [
                "name" => "john",
            ],
            [
                "name" => "jane"
            ]
        ];

        $result = Arr::intersectRecursive($arr, $subset);

        $this->assertEquals($arr, $result);
	}

    /**
     * @test
     */
    public function test_Arr_intersectRecursive_checks_multiple_keys()
    {
        $arr = [
            [
                "name" => "john",
                "age" => 10
            ]
        ];

        $subset = [
            [
                "name" => "john",
                "age" => 10
            ],
            [
                "name" => "john",
                "age" => 45
            ],
            [
                "name" => "jane"
            ]
        ];

        $result = Arr::intersectRecursive($arr, $subset);

        $this->assertEquals($arr, $result);
    }

    /**
     * @test
     */
    public function test_Arr_intersectRecursive_checks_nested_keys()
    {
        $arr = [
            [
                "name" => "john",
                "hobbies" => [
                    ["name" => "Reading"],
                    ["name" => "Watching Movies"]
                ]
            ]
        ];

        $subset = [
            [
                "name" => "john",
                "hobbies" => [
                    ["name" => "Reading"],
                    ["name" => "Watching Movies"]
                ]
            ],
            [
                "name" => "john",
                "hobbies" => [
                    ["name" => "Reading"],
                ]
            ],
            [
                "name" => "jane"
            ]
        ];

        $result = Arr::intersectRecursive($arr, $subset);
        $arr[0] = Arr::removeChildArrays($arr[0]);
        $this->assertEquals($arr, $result);
    }
}
