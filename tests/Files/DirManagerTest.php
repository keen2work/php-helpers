<?php


use EMedia\PHPHelpers\Files\DirManager;
use PHPUnit\Framework\TestCase;

class DirManagerTest extends TestCase
{
    private static $testDirName = "_test_dir";

    protected function tearDown()
    {
        if (is_dir(static::$testDirName)) {
            rmdir(static::$testDirName);
        }
        parent::tearDown();

    }

    /**
     * @test
     * @throws \EMedia\PHPHelpers\Exceptions\FIleSystem\DirectoryNotCreatedException
     */
    public function test_DirManager_makeDirectoryIfNotExists_skips_an_existing_directory()
    {
        if (!is_dir(static::$testDirName)) {
            mkdir(static::$testDirName);
        }

        $success = DirManager::makeDirectoryIfNotExists(static::$testDirName);
        $this->assertTrue($success);
    }

    /**
     * @test
     * @throws \EMedia\PHPHelpers\Exceptions\FIleSystem\DirectoryNotCreatedException
     */
    public function test_DirManager_makeDirectoryIfNotExists_creates_a_new_directory()
    {

        if (is_dir(static::$testDirName)) {
            rmdir(static::$testDirName);
        }

        $success = DirManager::makeDirectoryIfNotExists(static::$testDirName);

        $this->assertTrue($success);
        $this->assertTrue(is_dir(static::$testDirName));
    }

    /**
     * @test
     */
    public function test_DirManager_deleteDirectory_throws_exception_if_missing()
    {
        $this->expectException(\EMedia\PHPHelpers\Exceptions\FileSystem\DirectoryMissingException::class);
        DirManager::deleteDirectory("missing");
    }

    /**
     * @test
     */
    public function test_DirManager_deleteDirectory_deletes_a_file()
    {
        $file = ".dir-manager-test.test.txt";
        file_put_contents($file, "foo");
        $this->assertFileExists($file);
        DirManager::deleteDirectory($file);
        $this->assertFileNotExists($file);
    }

    public function test_DirManager_deleteDirectory_deletes_a_directory()
    {
        $dir = ".dir-manager-test";
        mkdir($dir);
        mkdir("{$dir}/child");
        file_put_contents("{$dir}/test.txt", "foo");
        file_put_contents("{$dir}/child/test.txt", "foo");
        $this->assertFileExists($dir);
        DirManager::deleteDirectory($dir);
        $this->assertFileNotExists($dir);
    }

}