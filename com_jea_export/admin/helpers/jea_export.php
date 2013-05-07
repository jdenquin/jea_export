<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * Jea_Export component helper.
 */
abstract class Jea_ExportHelper
{
        /**
         * Configure the Linkbar.
         */
        public static function addSubmenu($submenu) 
        {
                JSubMenuHelper::addEntry(JText::_('COM_JEA_EXPORT_SUBMENU_FREE'),
                                         'index.php?option=com_jea_export', $submenu == 'free');
                //JSubMenuHelper::addEntry(JText::_('COM_JEA_EXPORT_SUBMENU_PAY'),
                //                        'index.php?option=com_jea_export&controller=pay&view=pays',
                //                         $submenu == 'pay');
                JSubMenuHelper::addEntry(JText::_('COM_JEA_EXPORT_SUBMENU_ANNONCE'),
                						 'index.php?option=com_jea_export&controller=annonce&view=annonces',
                						 $submenu == 'annonce');
                JSubMenuHelper::addEntry(JText::_('COM_JEA_EXPORT_SUBMENU_ABOUT'),
                						'index.php?option=com_jea_export&controller=about&view=about',
                						 $submenu == 'about');
        }
}