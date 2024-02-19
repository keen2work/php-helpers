<?php


namespace EMedia\PHPHelpers\Files;


use EMedia\PHPHelpers\Exceptions\FileSystem\DirectoryMissingException;
use EMedia\PHPHelpers\Exceptions\FIleSystem\DirectoryNotCreatedException;

class DirManager
{

    /**
     * Create a directory if it doesn't exist
     *
     * @param      $dirPath
     * @param int $permissions
     * @param bool $recursive
     *
     * @return bool
     * @throws DirectoryNotCreatedException
     */
	public static function makeDirectoryIfNotExists($dirPath, $permissions = 0775, $recursive = true)
	{
		if (is_dir($dirPath) ) {
			return true;
		}

		if (!mkdir($dirPath, $permissions, $recursive) && !is_dir($dirPath)) {
			throw new DirectoryNotCreatedException(sprintf('Directory "%s" was not created', $dirPath));
		}

		if (is_dir($dirPath)) return true;

		return false;
	}

    /**
     * @param $dirPath
     * @return bool
     * @throws DirectoryMissingException
     */
    public static function deleteDirectory($dirPath)
    {
        $invalidDirecotry = !is_readable($dirPath);
        if ($invalidDirecotry) {
            throw new DirectoryMissingException(sprintf("Directory '%s' does not exist or is not readable", $dirPath));
        }

        $isFile = !is_dir($dirPath);
        if($isFile) {
            return unlink($dirPath);
        }

        $isEmpty = count(scandir($dirPath)) === 0;
        if ($isEmpty) {
            return rmdir($dirPath);
        }

        foreach (scandir($dirPath) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!static::deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dirPath);
    }
}