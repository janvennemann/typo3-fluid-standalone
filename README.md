TYPO3 Fluid Standalone
======================

A standalone version of Fluid, the template engine of the TYPO3 Flow PHP Framework. Based on the current TYPO3 Flow 2.0 Beta 1

Setup
-----

Fluid is ready to use in a few simple steps. As a start it is eneugh to use the following piece of code:

```php
require_once __DIR__ . '/Scripts/fluid.php';

$view = new \TYPO3\Fluid\View\StandaloneView();
$view->assign('foos', array(
    'bar', 'baz'
));
echo $view->render();
```

This would result in rendering the template file ```/path/to/Fluid/Resources/Templates/Standard/Index.html```, which is the default if you do not specify anything else. You can change the template that will be rendered in two different ways.

### Dynamik template resolving

The above example uses the dynamic template resolving. This means that the template files are resolved dynamically using a specific path and file name pattern. All Templates, Layouts and Partials have to be under the directory ```Resources```. The directory and file structure is almost the same as the one used in a TYPO3 Flow Package, except that you can ommit the Private subfolder.

<table>
  <tr>
    <th>Directory</th><th>Content</th>
  </tr>
  <tr>
    <td>Resources/Layouts</td><td>Layouts</td>
  </tr>
  <tr>
    <td>Resources/Partials</td><td>Partials</td>
  </tr>
  <tr>
    <td>Resources/Templates</td><td>Templates</td>
  </tr>
</table>

In TYPO3 Flow the actions controller chooses the right template automatically according to the current package, controller and action. Since we do not have these information in our standalone version of Fluid, we need to set them ourself. This is done by using the class ViewContext which provides the methods ```setControllerName```, ```setControllerActionName``` and ```setFormat```.

```php
require_once __DIR__ . '/Scripts/fluid.php';

$view = new \TYPO3\Fluid\View\StandaloneView();
$view->getViewContext()->setControllerName('Blog');
$view->getViewContext()->setControllerActionName('index');
$view->getViewContext()->setFormat('html');
echo $view->render();
```
The pattern to match the template files is ```Resources/Templates/{controller}/{action}.{format}``` and for this example this would resolve to the path ```Resources/Templates/Blog/Index.html```. If you do not change these values they fall back to their defaults, which are *Standard* for the controller name, *index* for the action name and *html* as the format

### Static template resolving

You can also specify the template file you want to render directly. To do this, just use the methods ```setTemplatePathAndFilename``` and ```setLayoutPathAndFilename```.

```php
require_once __DIR__ . '/Scripts/fluid.php';

$view = new \TYPO3\Fluid\View\StandaloneView();
$view->setTemplatePathAndFilename('/path/to/your/template.html');
echo $view->render();
```

Unsupported View Helpers
------------------------

Due to the lack of TYPO3 Flow there are a few ViewHelpers that are not available:

* f:debug
* f:form.*
* f:format.identifier
* f:link.action
* f:link.widget
* f:widget.*
* f:renderChildren
* f:security
* f:uri.action
* f:uri.resource


Official Manual
---------------

To learn more about Fluid visit the official documention:

[Views in TYPO3 Flow using Fluid](http://docs.typo3.org/flow/TYPO3FlowDocumentation/TheDefinitiveGuide/PartII/View.html)  
[Fluid ViewHelper Reference](http://docs.typo3.org/flow/TYPO3FlowDocumentation/TheDefinitiveGuide/PartV/FluidViewHelperReference.html)