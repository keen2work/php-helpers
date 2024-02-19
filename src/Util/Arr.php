<?php


namespace EMedia\PHPHelpers\Util;


class Arr
{


	/**
	 *
	 * Is the array an associative array?
	 *
	 * @param array $arr
	 *
	 * @return bool
	 */
	public static function isAssocArray(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}


	/**
	 *
	 * Find matching structure on a nested array recursively
	 *
	 * @param       $subset
	 * @param       $array
	 * @param array $results
	 *
	 * @return array
	 */
	public static function intersectRecursive($array, $subset, $results = [])
	{
		$isAssocArray = self::isAssocArray($subset);

		if ($isAssocArray) {
			// loop each row of array
			// iterating through parents
			foreach ($subset as $key => $value) {
				if ($key) {
					if (isset($array[$key])) {
						$filteredSource = $array[$key];

						//if the value is array, it will do the recursive
						if (is_array($value)) {
							$loopResults = self::intersectRecursive($filteredSource, $subset[$key], $results);
							$results[$key] = $loopResults;
						}
					}
				}
			}
		} else {
			// iterate through final leaf nodes
			foreach ($subset as $subsetRow) {
				foreach ($array as $sourceRow) {
					$subsetRow = self::removeChildArrays($subsetRow);
					$sourceRow = self::removeChildArrays($sourceRow);
					if (array_intersect($subsetRow, $sourceRow) == $subsetRow) {
						$results[] = $subsetRow;
					}
				}
			}
		}

		return $results;
	}


	public static function removeChildArrays($array)
	{
		$response = [];
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$response[$key] = json_encode($value);
			} else {
				$response[$key] = $value;
			}
		}
		return $response;
	}


}
