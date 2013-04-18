<?php
namespace TYPO3\Fluid\Utility;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * File and directory functions
 * 
 * Taken from TYPO3 Flow
 *
 */
class Files {

    /**
	 * Replacing backslashes and double slashes to slashes.
	 * It's needed to compare paths (especially on windows).
	 *
	 * @param string $path Path which should transformed to the Unix Style.
	 * @return string
	 */
	static public function getUnixStylePath($path) {
		if (strpos($path, ':') === FALSE) {
			return str_replace('//', '/', str_replace('\\', '/', $path));
		} else {
			return preg_replace('/^([a-z]{2,}):\//', '$1://', str_replace('//', '/', str_replace('\\', '/', $path)));
		}
	}
    
    /**
     * Creates a directory specified by $path. If the parent directories
	 * don't exist yet, they will be created as well.
	 *
	 * @param string $path Path to the directory which shall be created
	 * @return void
	 * @throws Exception
	 * @todo Make mode configurable / make umask configurable
	 */
	static public function createDirectoryRecursively($path) {
		if (substr($path, -2) === '/.') {
			$path = substr($path, 0, -1);
		}
		if (is_file($path)) {
			throw new \TYPO3\Fluid\Utility\Exception('Could not create directory "' . $path . '", because a file with that name exists!', 1349340620);
		}
		if (!is_dir($path) && strlen($path) > 0) {
			$oldMask = umask(000);
			mkdir($path, 0777, TRUE);
			umask($oldMask);
			if (!is_dir($path)) {
				throw new \TYPO3\Fluid\Utility\Exception('Could not create directory "' . $path . '"!', 1170251400);
			}
		}
	}
    
    /**
     * An enhanced version of file_get_contents which intercepts the warning
	 * issued by the original function if a file could not be loaded.
	 *
	 * @param string $pathAndFilename Path and name of the file to load
	 * @param integer $flags (optional) ORed flags using PHP's FILE_* constants (see manual of file_get_contents).
	 * @param resource $context (optional) A context resource created by stream_context_create()
	 * @param integer $offset (optional) Offset where reading of the file starts.
	 * @param integer $maximumLength (optional) Maximum length to read. Default is -1 (no limit)
	 * @return mixed The file content as a string or FALSE if the file could not be opened.
	 */
	static public function getFileContents($pathAndFilename, $flags = 0, $context = NULL, $offset = -1, $maximumLength = -1) {
		if ($flags === TRUE) {
			$flags = FILE_USE_INCLUDE_PATH;
		}
		try {
			if ($maximumLength > -1) {
				$content = file_get_contents($pathAndFilename, $flags, $context, $offset, $maximumLength);
			} else {
				$content = file_get_contents($pathAndFilename, $flags, $context, $offset);
			}
		} catch (\TYPO3\Flow\Error\Exception $ignoredException) {
			$content = FALSE;
		}
		return $content;
	}
    
}