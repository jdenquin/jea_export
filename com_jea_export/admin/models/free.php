<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

/**
 * Free Model
*/
class Jea_ExportModelFree extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param       type    The table type to instantiate
	 * @param       string  A prefix for the table class name. Optional.
	 * @param       array   Configuration array for model. Optional.
	 * @return      JTable  A database object
	 * @since       2.5
	 */
	public function getTable($type = 'Free', $prefix = 'Jea_ExportTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param       array   $data           Data for the form.
	 * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
	 * @return      mixed   A JForm object on success, false on failure
	 * @since       2.5
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_jea_export.free', 'free',
				array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return      mixed   The data for the form.
	 * @since       2.5
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_jea_export.edit.free.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	/**
	 * Method to export
	 */
	public function exporter()
	{
		//nothing
		return true;
	}
	
	/**
	 * Method to return the PasserellesActives List
	 *
	 * @return 		array	Passerelles List
	 */
	public function getPasserellesActives()
	{
		// Create a new query object
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		 
		// Select some fields
		$query->select('pasrl_ref, id, name');
		// from the free table
		$query->from('#__jea_export_free');
		// where active is 1
		$query->where('activated=\'1\'');
		$db->setQuery($query);
		 
		try{
			$results = $db->loadObjectList();
		}catch(Exception $e){
			return $e;
		}
		 
		// return the stdClass Object
		return $results;
	}
	
	/**
	 * Method to return the Annonces List
	 */
	public function getAnnoncesByPasserelle($pasrl_ref)
	{
		// Create a new query object
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$results = false;
		
		// Select some fields
		//switch($pasrl_ref)
		//{
			//case 'boomimmo':
				$query->select('
						a.id,
						a.cook, 
						a.seller_name, 
						a.phone, 
						a.manda_date
						');
				$query->from('#__jea_export_annonce AS a');
				$query->where('pasrl_id LIKE \'%' . $pasrl_ref . '%\' AND a.id IN (SELECT pties.id from #__jea_properties pties)');
				
				$query->select('
						p.ref, 
						p.title, 
						p.transaction_type, 
						p.type_id as type, 
						p.price, 
						p.fees,
						p.living_space,
						p.land_space,
						p.availability, 
						p.rooms,
						p.bedrooms, 
						p.description,
						p.alias,
						p.address,
						p.floor,
						p.floors_number,
						p.bathrooms,
						p.toilets,
						p.heating_type,
						p.amenities,
						p.images, 
						p.address,
						p.latitude,
						p.longitude, 
						p.town_id as town, 
						p.zip_code, 
						p.dpe_energy, 
						p.dpe_ges
						');
				$query->join('LEFT', '#__jea_properties AS p ON p.id=a.id');
				
				$query->select('t.value as town, t.department_id');
				$query->join('LEFT', '#__jea_towns AS t ON t.id=p.town_id');
				
				$query->select('d.value as department');
				$query->join('LEFT', '#__jea_departments AS d ON d.id=t.department_id');
				
				$query->select('type.value as type');
				$query->join('LEFT', '#__jea_types AS type ON type.id=p.type_id');
				
				$query->select('u.name as nom, u.email');
				$query->join('LEFT', '#__users AS u ON u.id=p.created_by');
								
				$db->setQuery($query);
				
				$results = $db->loadObjectList();
				//break;
		//}
		
		// return the stdClass Object
		return $results;
	}
	
	
	/**
	 * Method to get passerelle infos
	 */
	public function getInfosFree($pasrl_ref)
	{
		// Create a new query object
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// Select some fields
		$query->select('name, code_agence, num_boutique, ftp_account, ftp_password, ftp_address, method');
		$query->from('#__jea_export_free');
		$query->where('pasrl_ref LIKE \''.$pasrl_ref.'\'');
		$db->setQuery($query);
		
		try{
			$results = $db->loadObjectList();
		}catch(Exception $e){
			return $e;
		}
		
		// return the stdClass Object
		return $results;
	}
	
	/**
	 * Method to update info passerelle
	 */
	public function updateExport($id)
	{
		// Create a new query object
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$date= date("Y-m-j H:i:s");
		
		//update
		$query->update('#__jea_export_free');
		$query->set('nb_export=nb_export+1, last_export=\'' . $date . '\'');
		$query->where('id=\'' . $id . '\'');
		
		$db->setQuery($query);
		
		try{
			$results = $db->query();
		}catch(Exception $e){
			return $e;
		}
		
	}
}