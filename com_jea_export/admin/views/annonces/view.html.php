<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

require JPATH_COMPONENT.DS.'helpers'.DS.'jea_export.php';
 
/**
 * Annonces View
 */
class Jea_ExportViewAnnonces extends JView
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
                
                Jea_ExportHelper::addSubmenu('annonce');
 
                // Display the template
                parent::display($tpl);
                
				//set the document
				$this->setDocument();
        }
        
        /**
         * Setting the ToolBar
         */
        protected function addToolBar()
        {
        	JToolBarHelper::title(JText::_('COM_JEA_EXPORT_ANNONCE_TITLE'), 'jea_export');
        	JToolBarHelper::custom('annonce.ajouter', 'new', 'new', 'Ajouter', false);
        	JToolBarHelper::editList('annonce.edit');
        }
        
        /**
         * Method to return the document properties
         */
        protected function setDocument()
        {
        	$document = JFactory::getDocument();
        	$document->setTitle(JText::_('COM_JEA_EXPORT_ADMINISTRATION_ANNONCE'));
        }
}