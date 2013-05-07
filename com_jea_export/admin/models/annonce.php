<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 
/**
 * Annonce Model
 */
class Jea_ExportModelAnnonce extends JModelAdmin
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
        public function getTable($type = 'Annonce', $prefix = 'Jea_ExportTable', $config = array()) 
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
                $form = $this->loadForm('com_jea_export.annonce', 'annonce',
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
                $data = JFactory::getApplication()->getUserState('com_jea_export.edit.annonce.data', array());
                if (empty($data)) 
                {
                        $data = $this->getItem();
                }
                return $data;
        }
        
        /**
         * Method enregistrer
         */
        public function enregistrer($pks_array)
        {
        	$pks_jform = $pks_array['jform'];
        	// Create a new query object
        	$db = JFactory::getDBO();
        	$query = $db->getQuery(true);
        	
        	// format the pasrl_id value
        	$pasrl = '';
        	if (isset($pks_array['boom_immo']))
        		$pasrl .= 'boomimmo,';
        	if (isset($pks_array['web_immo']))
        		$pasrl .= 'webimmo,';
        	if (isset($pks_array['trovit']))
        		$pasrl .= 'trovit,';
        
        	// set the fields
        	$fields = array(
        		'cook=\'' . $pks_jform['cook'] . '\'',
        		'seller_name=\'' . $pks_jform['seller_name'] . '\'',
        		'phone=\'' . $pks_jform['phone'] . '\'',
        		'manda_date=\'' . $pks_jform['manda_date'] . '\'',
        		'pasrl_id=\'' . $pasrl . '\''	
        	);
       
        	// set the conditions
        	$conditions = array(
        		'id=\'' . $pks_jform['id'] . '\'',	
        	);
        	
        	// set the query
        	$query->update($db->quoteName('#__jea_export_annonce'))->set($fields)->where($conditions);
        	$db->setQuery($query);
        	
        	try{
        		$result = $db->query();
        	}catch(Exception $e){
        	}
        	
        	return $result;
        }
        
        /**
         * Method ajouter
         */
        public function ajouter()
        {
        	// Create a new query object
        	$db = JFactory::getDBO();
        	$db->setQuery(true);
        	
        	// Ajoute les annonces non présentes dans la table jea_export_annonce
        	$query = 'INSERT IGNORE INTO #__jea_export_annonce (id, ref) SELECT id, ref FROM #__jea_properties WHERE `published` = 1';
        	
        	$db->setQuery($query);
        	
        	try{
        		$result = $db->query();
        		$nb = $db->getAffectedRows();
        	}catch(Exception $e){
        	}
        	
        	return $nb;
        }
}