## PHP Helper Functions

A library of common PHP helper functions and classes. Supports PHP 6 and 7.

Only add Non-laravel functions to this package. For Laravel dependent code, refer to [Laravel Helpers](https://bitbucket.org/elegantmedia/laravel-helpers/src) library.

### Installation Instructions

Add the repository to `composer.json`
```
"repositories": [
	{
	    "type":"vcs",
	    "url":"git@bitbucket.org:elegantmedia/php-helpers.git"
	}
]
```

```
composer require emedia/php-helpers
```

### Available Commands

#### Date/Time Functions
```
// Get formatted microtimestamp. Example: `2008_07_14_010813.98232`
Timing::microTimestamp()

// Convert a time string to a MySQL compatible date/time format.
Timing::convertToDbTime($string)

// Convert a UTC timestring to current server's timezone
Timing::toServerTimezone($UTCTimeString, $onlyDate = false)
```

#### File/Directory Handling
```
// Create a directory if it doesn't exist
DirManager::makeDirectoryIfNotExists($dirPath, $permissions = 0775, $recursive = true)

// Append a stub to a file, identified by the unique first line
FileEditor::appendStubIfSectionNotFound($filePath, $stubPath)

// Append a stub to a file
FileEditor::appendStub($filePath, $stubPath, $verifyPathsExists = true)

// Check if a string is in file
FileManager::isTextInFile($filePath, $string, $caseSensitive = true)

// Check if two files are similar (by size and hash)
FileManager::areFilesSimilar($path1, $path2)

// Read the first line from a file
FileManager::readFirstLine($filePath, $trim = true)
```

#### Load Classes

```
// Load (include) all php files from a given directory
Loader::includeAllFilesFromDir($dirPath)
```

#### Array Helpers
```
// Replace an existing key of an array with a new one
replace_array_key($array = [], $existingKey, $newKey, $recursive = false)

// Convert camelCase type array keys to snake case
array_keys_snake_case(&$mixed, $recursive = true)

// Convert array keys to camelCase
array_keys_camel_case(&$mixed, $recursive = true)
```

```
// Get an array and key it by a given key
array_key_by($array, $keyBy)

Example:
[
       [ 'name' => 'john', 'age' => 45 ],
       [ 'name' => 'jane', 'age', => 32 ],
]
*
becomes
[
       'john' => [ 'age' => 45 ],
       'jane' => [ 'age' => 32 ],
]
```

###### Recursive Intersection

```
// get matching subset of array. Similar to `array_intersect`, but does recursively.
\EMedia\PHPHelpers\Util\Arr::intersectRecursiveintersectRecursiveintersectRecursive($source, $subset);
```

###### Is an associative array?

```
// Check if an array is an associative array
\EMedia\PHPHelpers\Util\Arr::isAssocArray($array);
```


#### String Helpers

```
// Convert an 'existing_snake_case' to 'existing snake case'
reverse_snake_case($string)

// Generate a random string without any ambiguous characters
random_unambiguous($length = 16)

// Add or remove slashes to strings (if it doesn't exist)
str_with_trailing_slash($path)
str_without_trailing_slash($path)
str_without_leading_slash($path)

// Convert a block of text and split it into lines
Str::textToLinesArray($text, $delimiters = null)
Example:
one, two,   three
four
five

Returns:
['one', 'two', 'three', 'four', 'five']
```

#### Validation Helpers

```
// Check all values are !empty. Throws an exception if at least one value is empty
check_all_present()

Example: check_all_present($var1, $var2, $var5)
```

#### Conversions

```
// Convert bytes to a human readble format
ConvertSizes::bytesToHumans($bytes, $precision = 2)
// Example output: '200 KB', '1 MB', '3 TB' etc

// Converts a string with numbers to a full number
TypeCast::convertToInteger($string)

// Convert a string numeric to a float
TypeCast::convertToFloat($value)
Example: 1,232.12 -> becomes -> (float) 1232.12
```
