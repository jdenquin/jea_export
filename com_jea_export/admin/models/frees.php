<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * FreeList Model
 */
class Jea_ExportModelFrees extends JModelList
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
                // Select some fields
                $query->select('id,name,code_agence,activated,last_export,nb_export,signup_link');
                // From the free table
                $query->from('#__jea_export_free');
                return $query;
        }
}