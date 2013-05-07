<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

require JPATH_COMPONENT.DS.'helpers'.DS.'jea_export.php';
 
/**
 * Pays View
 */
class Jea_ExportViewPays extends JView
{
        /**
         * Pays view display method
         * @return void
         */
        function display($tpl = null) 
        {              
                // Adding the toolbar
                $this->addToolBar();
                
                Jea_ExportHelper::addSubmenu('pay');
 
                // Display the template
                parent::display($tpl);
        }
        
        /**
         * Setting the ToolBar
         */
        protected function addToolBar()
        {
        	JToolBarHelper::title(JText::_('COM_JEA_EXPORT_PAY_TITLE'));
        	//JToolBarHelper::editList('pay.edit');
        }
}