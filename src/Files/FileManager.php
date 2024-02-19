<?php


namespace EMedia\PHPHelpers\Files;


use EMedia\PHPHelpers\Exceptions\FileSystem\FileNotFoundException;

class FileManager
{

	/**
	 *
	 * Check if a string exists in a file. (Don't use to check on large files)
	 *
	 * @param      $filePath
	 * @param      $string
	 * @param bool $caseSensitive
	 *
	 * @return bool
	 * @throws FileNotFoundException
	 */
	public static function isTextInFile($filePath, $string, $caseSensitive = true)
	{
		if (!file_exists($filePath)) throw new FileNotFoundException("File $filePath not found");

		$command = ($caseSensitive)? 'strpos': 'stripos';

		return $command(file_get_contents($filePath), $string) !== false;
	}


	/**
	 *
	 * Check if two files are identical in content
	 *
	 * @param $path1
	 * @param $path2
	 *
	 * @return bool
	 * @throws FileNotFoundException
	 */
	public static function areFilesSimilar($path1, $path2)
	{
		if (!file_exists($path1) || !file_exists($path2)) {
			throw new FileNotFoundException("At least one of the requested files not found. {$path1}, {$path2}");
		}

		return ((filesize($path1) == filesize($path2)) && (md5_file($path1) == md5_file($path2)));
	}

	/**
	 *
	 * Returns the first line from an existing file.
	 *
	 * @param $filePath
	 *
	 * @return bool|string
	 */
	public static function readFirstLine($filePath, $trim = true)
	{
		$f = fopen($filePath, 'rb');
		$line = fgets($f);
		fclose($f);

		if ($trim) return trim($line);

		return $line;
	}

}