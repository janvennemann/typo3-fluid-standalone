<?php
namespace TYPO3\Fluid\Core;

/**
 * Simple class loader for Fluid Standalone
 */
class ClassLoader {
    
    /**
     * Constructor
     */
    public function __construct() {
        spl_autoload_register(array($this, 'loadClass'));
    }
    
    /**
     * Loads classes stat start with 'TYPO3\Fluid'
     * 
     * @param $className The name of the class to load
     * @return boolean
     */
    function loadClass($className) {
          if (substr($className, 0, 11) === 'TYPO3\Fluid') {
          	require_once FLUID_ROOT_PATH . 'Classes/TYPO3/Fluid/' . str_replace('\\', '/', substr($className, 11)) . '.php';
      	    return TRUE;
      	}
	}
}

?>