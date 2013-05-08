<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Frees Controller
*/
class Jea_ExportControllerFrees extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */
	public function getModel($name = 'Free', $prefix = 'Jea_ExportModel', $config = Array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}	
	
	public function exportByPasserelle($annoncesArray, $infos, $pasrl_ref)
	{
		if(!empty($annoncesArray))
		{
			//verify if the export dir exist
			!file_exists('exports') ? mkdir('exports') : '';
			!file_exists('./exports/'.$pasrl_ref) ? mkdir('./exports/'.$pasrl_ref) : '';
			
			$info = $infos[0];
			
			switch ($info->method)
			{
				case 'poliris':
					require './components/com_jea_export/pasrlprocess/' . $info->method . '.php';
					poliris($pasrl_ref, $info, $annoncesArray);
					break;
					
				case 'webimmo':
					require './components/com_jea_export/pasrlprocess/' . $info->method . '.php';
					webimmo($pasrl_ref, $info, $annoncesArray);
					break;
					
				case 'trovit':
					require './components/com_jea_export/pasrlprocess/' . $info->method . '.php';
					trovit($pasrl_ref, $info, $annoncesArray);
					break;
			}
		}	
		return count($annoncesArray);
	}
	
	/**
	 * Method to export data
	 */
	public function exporter()
	{
		// set the toolbar title
		JToolBarHelper::title(JText::_('COM_JEA_EXPORT_IN_PROGRESS'));
		
		// print the message
		echo '<h2>' . JText::_('COM_JEA_EXPORT_IN_PROGRESS') . '</h2>';
		$this->display();
		
		// get the model
		$model = $this->getModel();
		
		// call the model function getPasserellesActives
		$passerelles = $model->getPasserellesActives();
		
		$msg_retour = '';
		
		// get the annonce list activated for the passerelle
		foreach ($passerelles AS $passerelle)
		{
			//get the pasrl ref
			$pasrl_ref = $passerelle->pasrl_ref;
		
			// function to export
			$nb_annonces = $this->exportByPasserelle(
					// get the annonces activated to this passerelle
					$annonces = $model->getAnnoncesByPasserelle($pasrl_ref),
					// get the infos of this passerelle (method, ftp,...)
					$model->getInfosFree($pasrl_ref),
					$pasrl_ref
			);
			
			if ($nb_annonces != 0)
			{
				//increment nb_export and date_last_export
				$model->updateExport($passerelle->id);
				$msg_retour .= "$nb_annonces biens ont ete exportes vers " . $passerelle->name . "<br/>";
			}			
		}
		
		// redirect to the view Frees
 		$this->setRedirect(JRoute::_('index.php?option=com_jea_export&view=frees', false), $msg_retour);
	}
}