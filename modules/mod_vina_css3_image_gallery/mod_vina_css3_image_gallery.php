<?php
/*
# ------------------------------------------------------------------------
# Vina CSS3 Image Gallery for Joomla 3
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

// load json code
$slider = json_decode($params->get('slides', ''));

// load data
$slides = modVinaCSS3ImageGalleryHelper::getSildes($slider);

// check if don't have any image
if(empty($slides)) {
	echo "You don't have any image!";
	return;
}

// module config
$moduleWidth 	= $params->get('moduleWidth', '100%');
$moduleHeight 	= $params->get('moduleHeight', '100%');
$overflow 		= $params->get('overflow', 'hidden');
$modulePadding 	= $params->get('modulePadding', '0px 0px 0px 0px');
$moduleMargin 	= $params->get('moduleMargin', '0px 0px 0px 0px');
$bgImage 		= $params->get('bgImage', null);
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}
$isBgColor 		= $params->get('isBgColor', 0);
$bgColor 		= $params->get('bgColor', '#ffffff');
$maxItemRow 	= $params->get('maxItemRow', 4);
$itemMaxWidth	= $params->get('itemMaxWidth', 400);
$itemMinWidth	= $params->get('itemMinWidth', 250);
$isItemBgColor 	= $params->get('isItemBgColor', 1);
$itemBgColor 	= $params->get('itemBgColor', '#f5f5f5');
$textBlock		= $params->get('textBlock', 1);
$itemTextColor 	= $params->get('itemTextColor', '#333333');
$itemLinkColor 	= $params->get('itemLinkColor', '#0088cc');
$itemPadding 	= $params->get('itemPadding', '10px 10px 4px 10px');
$categoryFilter = $params->get('categoryFilter', 0);
$filterPosition = $params->get('filterPosition', 'center');
$buttonColor	= $params->get('buttonColor', '#f5f5f5');
$textColor		= $params->get('textColor', '#333333');
$buttonAColor	= $params->get('buttonActiveColor', '#f5f5f5');
$textAColor		= $params->get('textActiveColor', '#0088cc');
$buttonsPadding	= $params->get('buttonsPadding', '10px 25px 10px 25px');
$buttonsMargin	= $params->get('buttonsMargin', '0 5px 15px 0');
$draggable 		= $params->get('draggable', 1);
$animate 		= $params->get('animate', 1);
$moduleCache 	= $params->get('moduleCache', 0);
$delay 			= $params->get('delay', 0);
$fixSize 		= $params->get('fixSize', 'null');
$gutterX 		= $params->get('gutterX', 10);
$gutterY 		= $params->get('gutterY', 10);
$rightToLeft	= $params->get('rightToLeft', 0);
$bottomToTop	= $params->get('bottomToTop', 0);
$resizeImage	= $params->get('resizeImage', 1);
$imageWidth		= $params->get('imageWidth', 400);
$imageHeight	= $params->get('imageHeight', 250);
$imageInPage    = $params->get('maxItemPage', 0);
$pageNumber		= ($imageInPage) ? ceil(count($slides)/$imageInPage) : 1;

// CSS3 Image Gallery
$single		= $params->get('single', 0);
$loop		= $params->get('loop', 1);
$thumbs		= $params->get('thumbs', 1);
$title		= $params->get('title', 1);
$autoplay	= $params->get('autoplay', 0);
$time		= $params->get('time', 3000);
$history	= $params->get('history', 1);
$zoomable	= $params->get('zoomable', 1);
$wNextPrev	= $params->get('wheelNextPrev', 1);

// display layout
require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));