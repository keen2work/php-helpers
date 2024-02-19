<?php


namespace EMedia\PHPHelpers\Files;


class Loader
{

	public static function includeAllFilesFromDir($dirPath)
	{
		$includedFiles = get_included_files();

		foreach (glob($dirPath . "/*.php") as $filename)
		{
			if (!in_array($filename, $includedFiles)) {
				include $filename;
			}
		}
	}

	public static function includeAllFilesFromDirRecursive($dirPath)
	{
		/** @var \SplFileInfo $filename */
		$filtered = [];
		foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dirPath)) as $file)
		{
			if (!in_array($file->getPathname(), get_included_files())) {
				if ($file->getExtension() === 'php') {
					$filtered[] = $file;
					include($file->getPathname());
				}
			}
		}
	}

}