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
 * Provides methods to call appropriate getter/setter on an object given the
 * property name. It does this following these rules:
 * - if the target object is an instance of ArrayAccess, it gets/sets the property
 * - if public getter/setter method exists, call it.
 * - if public property exists, return/set the value of it.
 * - else, throw exception
 *
 * Some methods support arrays as well, most notably getProperty() and
 * getPropertyPath().
 *
 */
class ObjectAccess {
    
    /**
     * Get a property of a given object or array.
	 *
	 * Tries to get the property the following ways:
	 * - if the target is an array, and has this property, we return it.
	 * - if public getter method exists, call it.
	 * - if the target object is an instance of ArrayAccess, it gets the property
	 *   on it if it exists.
	 * - if public property exists, return the value of it.
	 * - else, throw exception
	 *
	 * @param mixed $subject Object or array to get the property from
	 * @param string|integer $propertyName Name or index of the property to retrieve
	 * @param boolean $forceDirectAccess Directly access property using reflection(!)
	 * @return mixed Value of the property
	 * @throws \InvalidArgumentException in case $subject was not an object or $propertyName was not a string
	 * @throws \TYPO3\Flow\Reflection\Exception\PropertyNotAccessibleException if the property was not accessible
	 */
	static public function getProperty($subject, $propertyName, $forceDirectAccess = FALSE) {
        if (!is_object($subject) && !is_array($subject)) {
    		throw new \InvalidArgumentException('$subject must be an object or array, ' . gettype($subject). ' given.', 1237301367);
		}
		if (!is_string($propertyName) && !is_integer($propertyName)) {
			throw new \InvalidArgumentException('Given property name/index is not of type string or integer.', 1231178303);
		}
        
        $propertyExists = FALSE;
    	$propertyValue = self::getPropertyInternal($subject, $propertyName, FALSE, $propertyExists);
		if ($propertyExists === TRUE) {
			return $propertyValue;
		}
        throw new \TYPO3\Fluid\Utility\Exception('The property "' . $propertyName . '" on the subject was not accessible.', 1263391473);
	}
    
    /**
     * Gets a property of a given object or array.
	 * This is an internal method that does only limited type checking for performance reasons.
	 * If you can't make sure that $subject is either of type array or object and $propertyName of type string you should use getProperty() instead.
	 *
	 * @param mixed $subject Object or array to get the property from
	 * @param string $propertyName name of the property to retrieve
	 * @param boolean $forceDirectAccess directly access property using reflection(!)
	 * @param boolean $propertyExists (by reference) will be set to TRUE if the specified property exists and is gettable
	 * @return mixed Value of the property
	 * @throws \TYPO3\Flow\Reflection\Exception\PropertyNotAccessibleException
	 * @see getProperty()
	 */
	static protected function getPropertyInternal($subject, $propertyName, $forceDirectAccess, &$propertyExists) {
		if ($subject === NULL) {
			return NULL;
		}
		$propertyExists = TRUE;
		if (is_array($subject)) {
			if (array_key_exists($propertyName, $subject)) {
				return $subject[$propertyName];
			}
			$propertyExists = FALSE;
			return NULL;
		}
        /*
         * Direct access is disabled due to the lack of the reflection service
         *
		if ($forceDirectAccess === TRUE) {
			if (property_exists(get_class($subject), $propertyName)) {
				$propertyReflection = new \TYPO3\Flow\Reflection\PropertyReflection(get_class($subject), $propertyName);
				return $propertyReflection->getValue($subject);
			} elseif (property_exists($subject, $propertyName)) {
				return $subject->$propertyName;
			} else {
				throw new \TYPO3\Flow\Reflection\Exception\PropertyNotAccessibleException('The property "' . $propertyName . '" on the subject does not exist.', 1302855001);
			}
		}
        */
		if ($subject instanceof \ArrayAccess && isset($subject[$propertyName])) {
			return $subject[$propertyName];
		}
		$getterMethodName = 'get' . ucfirst($propertyName);
		if (is_callable(array($subject, $getterMethodName))) {
			return $subject->$getterMethodName();
		}
		$getterMethodName = 'is' . ucfirst($propertyName);
		if (is_callable(array($subject, $getterMethodName))) {
			return $subject->$getterMethodName();
		}
		if (is_object($subject) && array_key_exists($propertyName, get_object_vars($subject))) {
			return $subject->$propertyName;
		}
		$propertyExists = FALSE;
		return NULL;
	}
    
}