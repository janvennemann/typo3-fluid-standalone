<?php
namespace TYPO3\Fluid\Cache\Frontend;

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
 * A cache frontend tailored to PHP code.
 *
 * @api
 */
class PhpFrontend extends \TYPO3\Fluid\Cache\Frontend\StringFrontend {

    /**
	 * Constructs the cache
	 *
	 * @param string $identifier A identifier which describes this cache
	 * @param \TYPO3\Fluid\Cache\Backend\PhpCapableBackendInterface $backend Backend to be used for this cache
	 */
	public function __construct($identifier, \TYPO3\Fluid\Cache\Backend\PhpCapableBackendInterface $backend) {
		parent::__construct($identifier, $backend);
	}

	/**
	 * Saves the PHP source code in the cache.
	 *
	 * @param string $entryIdentifier An identifier used for this cache entry, for example the class name
	 * @param string $sourceCode PHP source code
	 * @param array $tags Tags to associate with this cache entry
	 * @param integer $lifetime Lifetime of this cache entry in seconds. If NULL is specified, the default lifetime is used. "0" means unlimited lifetime.
	 * @return void
	 * @throws \TYPO3\Fluid\Cache\Exception\InvalidDataException
	 * @throws \InvalidArgumentException
	 * @api
	 */
	public function set($entryIdentifier, $sourceCode, array $tags = array(), $lifetime = NULL) {
		if (!$this->isValidEntryIdentifier($entryIdentifier)) {
			throw new \InvalidArgumentException('"' . $entryIdentifier . '" is not a valid cache entry identifier.', 1264023823);
		}
		if (!is_string($sourceCode)) {
			throw new \TYPO3\Fluid\Cache\Exception\InvalidDataException('The given source code is not a valid string.', 1264023824);
		}
		foreach ($tags as $tag) {
			if (!$this->isValidTag($tag)) {
				throw new \InvalidArgumentException('"' . $tag . '" is not a valid tag for a cache entry.', 1264023825);
			}
		}
		$sourceCode = '<?php' . chr(10) . $sourceCode . chr(10) . '#';
		$this->backend->set($entryIdentifier, $sourceCode, $tags, $lifetime);
	}

	/**
	 * Loads PHP code from the cache and require_onces it right away.
	 *
	 * @param string $entryIdentifier An identifier which describes the cache entry to load
	 * @return mixed Potential return value from the include operation
	 * @api
	 */
	public function requireOnce($entryIdentifier) {
		return $this->backend->requireOnce($entryIdentifier);
	}

}
?>