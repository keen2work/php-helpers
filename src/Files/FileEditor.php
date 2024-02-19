<?php


namespace EMedia\PHPHelpers\Files;


use EMedia\PHPHelpers\Exceptions\FileSystem\FileNotFoundException;
use EMedia\PHPHelpers\Exceptions\FileSystem\SectionAlreadyExistsException;


class FileEditor
{


	/**
	 *
	 * Check if a section exists, and if not, append contents
	 *
	 * @param      $filePath
	 * @param      $stubPath
	 * @param      $sectionStartString
	 * @param null $sectionEndString
	 * @param bool $throwEx				Returns the number of bytes written or FALSE on failure
	 *
	 * @return bool|int
	 * @throws SectionAlreadyExistsException
	 * @throws FileNotFoundException
	 */
	public static function appendStubIfSectionNotFound($filePath, $stubPath, $sectionStartString = null, $sectionEndString = null, $throwEx = false)
	{
		if (!file_exists($filePath)) throw new FileNotFoundException("File {$filePath} not found");
		if (!file_exists($stubPath)) throw new FileNotFoundException("File {$stubPath} not found");

		// by default, we use the first line of the stub as the section start line
		if(empty($sectionStartString)) {
			$sectionStartString = FileManager::readFirstLine($stubPath);
		}

		if (empty($sectionStartString)) {
			throw new \InvalidArgumentException("A section start string is required.");
		}

		// check if the routes file mentions anything about the $sectionStartString
		// if so, it might already be there. Ask the user to confirm.
		if (FileManager::isTextInFile($filePath, $sectionStartString, false)) {
			if ($throwEx) throw new SectionAlreadyExistsException();
		}

		return self::appendStub($filePath, $stubPath, false);
	}

	/**
	 *
	 * Append a stub to an existing file
	 *
	 * @param $filePath
	 * @param $stubPath
	 *
	 * @return bool|int
	 * @throws FileNotFoundException
	 */
	public static function appendStub($filePath, $stubPath, $verifyPathsExists = true)
	{
		if ($verifyPathsExists) {
			if (!file_exists($filePath)) throw new FileNotFoundException("File {$filePath} not found");
			if (!file_exists($stubPath)) throw new FileNotFoundException("File {$stubPath} not found");
		}

		// get contents and update the file
		$contents = file_get_contents($stubPath);

		$contents = "\r\n" . $contents;

		return file_put_contents($filePath, $contents, FILE_APPEND);
	}


	/**
	 * Inject given variable values to a file
	 *
	 * @param $filePath
	 * @param array $fields
	 * @param bool $outputPath
	 * @return bool|int
	 * @throws FileNotFoundException
	 */
	public function addPropertyValuesToFile($filePath, $fields = [], $outputPath = false)
	{
		if ( ! file_exists($filePath)) throw new FileNotFoundException();

		if (empty($fields)) return false;
		if (empty($outputPath)) $outputPath = $filePath;

		$contents = file_get_contents($filePath);
		foreach ($fields as $field)
		{
			$results = $this->addPropertyValue($contents, $field['name'], $field['value']);
			if ($results) $contents = $results;
		}

		return file_put_contents($outputPath, $contents);
	}

	public function addPropertyValue($content, $propertyName, $value)
	{
		$regex = '/(\$' . $propertyName . ')\s?=\s?\[(.*)\];/Us';

		preg_match_all($regex, $content, $matches);
		if (is_countable($matches) && count($matches) === 3) {
			$elementBlock = $matches[2][0];
			$newContent = $elementBlock . '    ' . $value . ',' . PHP_EOL . "    ";
			$newContent = str_replace($elementBlock, $newContent, $content);

			if (strlen($newContent)) return $newContent;
		}

		return false;
	}

	/**
	 * Add given values to an array
	 *
	 * Example:
	 * $f->addArrayValuesToFile($path, [['name' => 'web', 'value' => 'somethingHere']]);
	 *
	 * Will change the file as below:
	 * protected $middlewareGroups = [
	'web' => [
	\App\Http\Middleware\VerifyCsrfToken::class,
	\somethingHere,
	],
	 * @param $filePath
	 * @param array $fields
	 * @param bool|false $ouputPath
	 * @return bool|int
	 * @throws FileNotFoundException
	 */
	public function addArrayValuesToFile($filePath, $fields = [], $ouputPath = false)
	{
		if ( ! file_exists($filePath)) throw new FileNotFoundException();

		if (empty($fields)) return false;
		if (empty($ouputPath)) $ouputPath = $filePath;

		$contents = file_get_contents($filePath);
		foreach ($fields as $field)
		{
			$results = $this->addArrayValue($contents, $field['name'], $field['value']);
			if ($results) $contents = $results;
		}

		return file_put_contents($ouputPath, $contents);
	}

	public function addArrayValue($content, $propertyName, $value)
	{
		$regex = "/('" . $propertyName . "')\s?=>\s?\[(.*)\]/Us";

		preg_match_all($regex, $content, $matches);
		if (is_countable($matches) && count($matches) === 3) {
			$elementBlock = $matches[2][0];
			$newContent = $elementBlock . '    ' . $value . ',' . PHP_EOL . "    ";
			$newContent = str_replace($elementBlock, $newContent, $content);

			if (strlen($newContent)) return $newContent;
		}

		return false;
	}

}
