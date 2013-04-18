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
 * Abstraction methods which return system environment variables.
 *
 * @api
 */
class Environment {
    
    static protected $instance;
    
    static public function getInstance() {
        if(!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Sets the base path of the temporary directory
	 *
	 * @param string $temporaryDirectoryBase Base path of the temporary directory, with trailing slash
	 * @return void
	 */
	public function setTemporaryDirectoryBase($temporaryDirectoryBase) {
		$this->temporaryDirectoryBase = $temporaryDirectoryBase;
		$this->temporaryDirectory = NULL;
	}
    
    /**
     * Returns the full path to Flow's temporary directory.
	 *
	 * @return string Path to PHP's temporary directory
	 * @api
	 */
	public function getPathToTemporaryDirectory() {
		if ($this->temporaryDirectory !== NULL) {
			return $this->temporaryDirectory;
		}

		$this->temporaryDirectory = $this->createTemporaryDirectory($this->temporaryDirectoryBase);

		return $this->temporaryDirectory;
	}
    
    /**
     * Retrieves the maximum path lenght that is valid in the current environment.
	 *
	 * @return integer The maximum available path length
	 */
	public function getMaximumPathLength() {
		return PHP_MAXPATHLEN;
	}
    
    /**
     * Creates Fluid's temporary directory - or at least asserts that it exists and is
	 * writable.
	 *
	 * @param string $temporaryDirectoryBase Full path to the base for the temporary directory
	 * @return string The full path to the temporary directory
	 * @throws \TYPO3\Fluid\Utility\Exception if the temporary directory could not be created or is not writable
	 */
	protected function createTemporaryDirectory($temporaryDirectoryBase) {
		$temporaryDirectoryBase = \TYPO3\Fluid\Utility\Files::getUnixStylePath($temporaryDirectoryBase);
		if (substr($temporaryDirectoryBase, -1, 1) !== '/') {
			$temporaryDirectoryBase .= '/';
		}
		$temporaryDirectory = $temporaryDirectoryBase . str_replace('/', '/SubContext', (string)$this->context) . '/';

		if (!is_dir($temporaryDirectory) && !is_link($temporaryDirectory)) {
			try {
				\TYPO3\Fluid\Utility\Files::createDirectoryRecursively($temporaryDirectory);
			} catch (\TYPO3\Flow\Error\Exception $exception) {
				throw new \TYPO3\Flow\Utility\Exception('The temporary directory "' . $temporaryDirectory . '" could not be created. Please make sure permissions are correct for this path or define another temporary directory in your Settings.yaml with the path "TYPO3.Flow.utility.environment.temporaryDirectoryBase".', 1335382361);
			}
		}

		if (!is_writable($temporaryDirectory)) {
			throw new \TYPO3\Fluid\Utility\Exception('The temporary directory "' . $temporaryDirectory . '" is not writable. Please make this directory writable or define another temporary directory in your Settings.yaml with the path "TYPO3.Flow.utility.environment.temporaryDirectoryBase".', 1216287176);
		}

		return $temporaryDirectory;
	}
    
}