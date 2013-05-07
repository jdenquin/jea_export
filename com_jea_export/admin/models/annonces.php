<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * AnnonceList Model
*/
class Jea_ExportModelAnnonces extends JModelList
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// select annonce infos
		$query->select('p.id, p.ref, p.pasrl_id');
		$query->from('#__jea_export_annonce AS p');
		
		// properties join
		$query->select('pties.title, pties.town_id, pties.images');
		$query->join('LEFT', '#__jea_properties AS pties ON pties.id = p.id');
		
		// town join
		$query->select('town.value AS `town`');
		$query->join('LEFT', '#__jea_towns AS town ON town.id = pties.town_id');
		
		return $query;
	}
}