<?php
namespace TYPO3\Fluid\Core\Rendering;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Fluid".                 *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

class RenderingContext implements \TYPO3\Fluid\Core\Rendering\RenderingContextInterface {

	/**
	 * Template Variable Container. Contains all variables available through object accessors in the template
	 *
	 * @var \TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer
	 */
	protected $templateVariableContainer;

	/**
	 * ViewHelper Variable Container
	 *
	 * @var \TYPO3\Fluid\Core\ViewHelper\ViewHelperVariableContainer
	 */
	protected $viewHelperVariableContainer;

	/**
	 * Injects the template variable container containing all variables available through ObjectAccessors
	 * in the template
	 *
	 * @param \TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer $templateVariableContainer The template variable container to set
	 */
	public function injectTemplateVariableContainer(\TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer $templateVariableContainer) {
		$this->templateVariableContainer = $templateVariableContainer;
	}

	/**
	 * Get the template variable container
	 *
	 * @return \TYPO3\Fluid\Core\ViewHelper\TemplateVariableContainer The Template Variable Container
	 */
	public function getTemplateVariableContainer() {
		return $this->templateVariableContainer;
	}

	/**
	 * Set the ViewHelperVariableContainer
	 *
	 * @param \TYPO3\Fluid\Core\ViewHelper\ViewHelperVariableContainer $viewHelperVariableContainer
	 * @return void
	 */
	public function injectViewHelperVariableContainer(\TYPO3\Fluid\Core\ViewHelper\ViewHelperVariableContainer $viewHelperVariableContainer) {
		$this->viewHelperVariableContainer = $viewHelperVariableContainer;
	}

	/**
	 * Get the ViewHelperVariableContainer
	 *
	 * @return \TYPO3\Fluid\Core\ViewHelper\ViewHelperVariableContainer
	 */
	public function getViewHelperVariableContainer() {
		return $this->viewHelperVariableContainer;
	}
}

?>