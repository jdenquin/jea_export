<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * Annonce Controller
 */
class Jea_ExportControllerAnnonce extends JControllerForm
{
	protected $default_view = 'annonces';

	/**
	 * Method Enregistrer
	 */
	public function enregistrer()
	{
		
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks_array = $input->getArray($_POST);
		
	
		// Get the model
		$model = $this->getModel();
	
		$return = $model->enregistrer($pks_array);
			
		//Redirect to the list screen
		$this->setRedirect(JRoute::_('index.php?option=com_jea_export&view=annonces', false) ,JText::_('COM_JEA_EXPORT_ANNONCE_EDIT_SUCCESS'));
	}
	
	/**
	 * Method Ajouter
	 */
	public function ajouter()
	{
		// Get the model
		$model = $this->getModel();
		
		//supprimer les annonces non presentes dans la table properties
		$model->cleanOld();
		
		// ajouter les annonces non présentes dans jea export
		$return = $model->ajouter();
		
		//Redirect to the list screen
		$this->setRedirect(JRoute::_('index.php?option=com_jea_export&controller=annonce&view=annonces', false), $return . ' bien(s) ont été ajoutés avec succès!');
	}
}