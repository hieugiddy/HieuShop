<?php

defined ('_JEXEC') or die('resticted aceess');

AddonParser::addAddon('sp_testimonialpro','sp_testimonialpro_addon');
AddonParser::addAddon('sp_testimonialpro_item','sp_testimonialpro_item_addon');

function sp_testimonialpro_addon($atts, $content){

	extract(spAddonAtts(array(
		'autoplay'=>'',
		'arrows'=>'',
		"class"=>'',
		), $atts));

	$carousel_autoplay = ($autoplay)?'data-sppb-ride="sppb-carousel"':'';

	$output  = '<div class="sppb-carousel sppb-testimonial-pro sppb-slide ' . $class . ' sppb-text-center" ' . $carousel_autoplay . '>';
	
	$output .= '<div class="sppb-carousel-inner">';
	$output .= AddonParser::spDoAddon($content);
	$output	.= '</div>';

	if($arrows) {
		$output	.= '<div class="sppb-carousel-controls"><a class="left sppb-carousel-control" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>';
		$output	.= '<a class="right sppb-carousel-control" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a></div>';
	}
	
	$output .= '</div>';

	return $output;

}

function sp_testimonialpro_item_addon( $atts ){

	extract(spAddonAtts(array(
		"title"=>'',
		"avatar"=>'',
		"avatar_style"=>'',
		"position"=>'',
		'message'=>'',
		"url"=>'',
		), $atts));
		
	if($title) $title = '<strong class="pro-client-name">'. $title .'</strong>';
	if($url) $title .= ' <span class="pro-client-url">'. $url .'</span>';
	$output   = '<div class="sppb-item">';
	if($title) $output .= '<div class="sppb-testimonial-client">' . $title . '</div>';
	
	if($avatar && $position == 'before' ) $output .= '<img class="sppb-img-responsive sppb-avatar '. $avatar_style .'" src="'. $avatar .'" alt="">';
	$output  .= '<div class="sppb-testimonial-message"><div class="sppb-testimonial-message-inner">' . $message . '</div></div>';
	if($avatar && $position == 'after' ) $output .= '<img class="sppb-img-responsive sppb-avatar '. $avatar_style .'" src="'. $avatar .'" alt="">';
	
	
	$output  .= '</div>';

	return $output;

}