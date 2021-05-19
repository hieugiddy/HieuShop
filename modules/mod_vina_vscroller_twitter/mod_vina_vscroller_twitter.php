<?php
/*
# ------------------------------------------------------------------------
# Vina Vertical Scroller for Tweeter for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum:    http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once dirname(__FILE__) . '/helper.php';
    
//Get Parameters
$username			= $params->get('username', 'vnwebsolutions');
$showUsername		= $params->get('showUsername', 1);
$showAvatar			= $params->get('avatar', 1);
$avatarWidth		= $params->get('avatarWidth', 1);
$linkedAvatar		= $params->get('linkedAvatar', 1);
$linkedSearch		= $params->get('linkedSearch', 1);
$linkedMention		= $params->get('linkedMention', 1);
$emailLinked		= $params->get('emailLinked', 1);
$tweetTime			= $params->get('tweetTime', 1);
$tweetTimeLinked	= $params->get('tweetTimeLinked', 1);
$tweetSource		= $params->get('tweetSource', 1);
$followUs			= $params->get('followUs', 1);
$target				= $params->get('target', '_blank');
$target				= 'target="'.$target.'"';
$moduleID      		= $module->id;

$moduleWidth	= $params->get('moduleWidth', '300px');
$moduleHeight	= $params->get('moduleHeight', 'auto');
$bgImage		 = $params->get('bgImage', NULL);
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}
$isBgColor		= $params->get('isBgColor', 1);
$bgColor		= $params->get('bgColor', '#43609C');
$modulePadding	= $params->get('modulePadding', '10px');

$headerBlock	= $params->get('headerBlock', 1);
$headerText		= $params->get('headerText', '');
$headerColor	= $params->get('headerTextColor', '#FFFFFF');
$controlButtons	= $params->get('controlButtons', 1);

$isItemBgColor	= $params->get('isItemBgColor', 1);
$itemBgColor	= $params->get('itemBgColor', '#FFFFFF');
$itemPadding	= $params->get('itemPadding', '10px');
$itemTextColor	= $params->get('itemTextColor', '#141823');
$itemLinkColor	= $params->get('itemLinkColor', '#3B5998');

$enableScroller	= $params->get('enableScroller', 1);
$direction		= $params->get('direction', 'up');
$easing			= $params->get('easing', 'jswing');
$speed			= $params->get('speed', 'slow');
$interval		= $params->get('interval', 5000);
$visible		= $params->get('visible', 2);
$mousePause		= $params->get('mousePause', 1);

// Load Data
$helper = new modVinaVScrollerTwitter($params, $moduleID);
$data	= $helper->tweets();

// include layout
require(JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default')));