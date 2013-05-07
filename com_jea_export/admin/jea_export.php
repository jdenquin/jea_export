<?php 
// no direct access to this file
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-48-jea_export {background-image: url(../media/com_jea_export/images/logo-48x48.png);}');

// require helper file
JLoader::register('Jea_ExportHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'jea_export.php');

// impor the Joomla controller library
jimport('joomla.application.component.controller');

if (JRequest::getCmd('task') == '') {
	// In order to define controllers/default.php as default controller
	JRequest::setVar('task', 'default.display');
}

// Get an instance of the controller prefixed by Free
$controller = JController::getInstance('jea_export');
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
?>