<?php

/*------------------------------------------------------------------------
# component_Marketplace - Marketplace 

# ------------------------------------------------------------------------
# author    WebKul software private limited 
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://webkul.com
# Technical Support:  Forum - http://webkul.com/index.php?Itemid=86&option=com_kunena
-------------------------------------------------------------------------*/
// no direct access
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.form.formfield');

class JFormFieldCountry extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	public $type = 'Country';
	public function getInput() {
		$db =& JFactory::getDBO();
		$query = 'SELECT lang_code as value, title as text'
		. ' FROM #__languages'		
		. ' ORDER BY title';

		$db->setQuery( $query );

		$country_list = $db->loadObjectList();
		$countries = $db->loadObjectList();

		foreach($country_list as $key=> $country){

			$countries[$key]->text=$country->text;					
			$countries[$key]->value=strtolower(str_replace('-', '_', $country->value));
		}

		$javascript = '';	
		$options = array();
		$options[] = JHTML::_('select.option', '', '- '.JText::_('select Country').' -');
		$options = array_merge($options, $countries);	

		return JHtml::_('select.genericlist', $options, $this->name, null, 'value', 'text', $this->value, $this->id);	

	}
}
