<?php
/**
* @package Helix Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

function modChrome_sp_xhtml($module, $params, $attribs) {

	$moduleTag     	= $params->get('module_tag', 'div');
	$bootstrapSize 	= (int) $params->get('bootstrap_size', 0);
	$moduleClass   	= $bootstrapSize != 0 ? ' col-sm-' . $bootstrapSize : '';
	$headerTag     	= htmlspecialchars($params->get('header_tag', 'h3'));
	$icon_sfx 		= "";
	if(strpos($params->get('header_class'), '@')===false){
		$headerClass   	= htmlspecialchars($params->get('header_class', 'sp-module-title'));
	}else{
		$headerClass 	= explode("@", htmlspecialchars($params->get('header_class')));
		$icon_sfx 		= '<i class="fa fa-'.trim($headerClass[1]) . '"></i>';
		$headerClass 	= $headerClass[0] ? trim($headerClass[0]) : 'sp-module-title';
	}
	
	if ($module->content) {
		echo '<' . $moduleTag . ' class="sp-module' . htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass . '">';

			if ($module->showtitle)
			{	
				if ($icon_sfx ){
					echo '<div class="' . $headerClass . '"><' . $headerTag . ' class="modtitle" ><span class="title">' . $icon_sfx . '</span></' . $headerTag . '></div>';
					
				}else{
					echo '<div class="' . $headerClass . '"><' . $headerTag . ' class="modtitle" ><span class="title">' . str_replace(array('{','}'), array('<span class="word-small">','</span>'), str_replace(array('[',']'), array('<em style="display: none;">','</em>'), $module->title)) . '</span></' . $headerTag . '></div>';
				}
			}

			echo '<div class="sp-module-content">';
			echo $module->content;
			echo '</div>';

		echo '</' . $moduleTag . '>';
	}
}