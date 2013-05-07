<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

require JPATH_COMPONENT.DS.'helpers'.DS.'jea_export.php';
 
/**
 * Frees View
 */
class Jea_ExportViewFrees extends JView
{
        /**
         * Frees view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;
                
                // Adding the toolbar
                $this->addToolBar();
                
                Jea_ExportHelper::addSubmenu('free');
 
                // Display the template
                parent::display($tpl);
                
                // Set the document
                $this->setDocument();
        }
        
        /**
         * Setting the ToolBar
         */
        protected function addToolBar()
        {
        	JToolBarHelper::title(JText::_('COM_JEA_EXPORT_FREE_TITLE'), 'jea_export');
        	JToolBarHelper::custom('frees.exporter', 'purge', 'purge', 'Exporter', false);
        	JToolBarHelper::editList('free.edit');
        }
        
        /**
         * Method to return the document properties
         */
        protected function setDocument()
        {
        	$document = JFactory::getDocument();
        	$document->setTitle(JText::_('COM_JEA_EXPORT_ADMINISTRATION_FREE'));
        }
}