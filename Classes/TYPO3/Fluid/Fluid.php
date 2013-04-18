<?php
namespace TYPO3\Fluid;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Fluid".                 *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Settings class which is a holder for constants specific to Fluid on v5 and v4.
 * 
 * Also holds the resources path in this standalone version
 */
class Fluid {

	/**
	 * PHP Namespace separator. Backslash in v5, and _ in v4.
	 */
	const NAMESPACE_SEPARATOR = '\\';

	/**
	 * Can be used to enable the verbose mode of Fluid.
	 *
	 * This enables the following things:
	 * - ViewHelper argument descriptions are being parsed from the PHPDoc
	 *
	 * This is NO PUBLIC API and the way this mode is enabled might change without
	 * notice in the future.
	 *
	 * @var boolean
	 */
	public static $debugMode = FALSE;
    
    /**
     * Can be used to define the path to the Fluid Standalone resources directory
     */
    static public $resourcesPath = NULL;
    
    /**
     * Initializes Fluid Standalone
     */
    static public function initialize() {
        require_once(FLUID_ROOT_PATH . 'Classes/TYPO3/Fluid/Core/ClassLoader.php');
    	$classLoader = new \TYPO3\Fluid\Core\ClassLoader();
		spl_autoload_register(array($classLoader, 'loadClass'), TRUE, TRUE);
        
        \TYPO3\Fluid\Utility\Environment::getInstance()->setTemporaryDirectoryBase(FLUID_ROOT_PATH . 'Data/');
        self::$resourcesPath = FLUID_ROOT_PATH . 'Resources/';
    }

}

?>