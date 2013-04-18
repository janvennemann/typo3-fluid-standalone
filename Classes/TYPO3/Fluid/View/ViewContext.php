<?php
namespace TYPO3\Fluid\View;

/**
 * This class acts as a replacement for the ControllerContext
 */
class ViewContext {
    
    protected $controllerName = 'Standard';
    
    protected $controllerActionName = 'index';
    
    protected $format = 'html';
    
    public function getControllerName() {
        return $this->controllerName;
    }
    
    public function setControllerName($controllerName) {
        $this->controllerName = $controllerName;
    }
    
    public function getControllerActionName() {
        return $this->controllerActionName;
    }
    
    public function setControllerActionName($controllerActionName) {
        $this->controllerActionName = $controllerActionName;
    }
    
    public function getFormat() {
        return $this->format;
    }
    
    public function setFormat($format) {
        $this->format = $format;
    }
    
}


?>