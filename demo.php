<?php

require_once __DIR__ . '/Scripts/fluid.php';

$view = new \TYPO3\Fluid\View\StandaloneView();
$view->assign('foos', array(
    'bar', 'baz'
));
echo $view->render();

?>