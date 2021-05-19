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
?>
<?php foreach($slides as $key => $slide) : 
	if($imageInPage && ($key == $max)) return false;
	if($imageInPage && ($key < $min)) continue;
	$title = $slide->name;
	$image = $slide->img;
	$desc  = $slide->text;
	$image = (strpos($image, 'http://') === false) ? JURI::base() . $image : $image;
	$thumb = ($resizeImage) ? $timthumb . '&amp;w=' . $imageWidth . '&amp;h=' . $imageHeight . '&amp;src=' . $image : $image;
?>
<div class="brick item">
	<!-- Image Block  -->
	<div class="image-block">		<a class="vina-gallery" href="<?php echo $image; ?>">
			<img src="<?php echo $thumb; ?>" alt="<?php echo $desc; ?>" title="<?php echo $title; ?>">			<div class="zoom-icon"></div>
		</a>
	</div>	
	<!-- Text Block  -->
	<?php if((!empty($title) || !empty($desc)) && $textBlock) : ?>
	<div class="text-block">
		<!-- Show/hide title of image -->
		<?php if(!empty($title)) : ?>
		<h3 class="title"><?php echo $title; ?></h3>
		<?php endif; ?>
		<!-- Show/hide description of image -->
		<?php if(!empty($desc)) : ?>
		<div class="introtext"><?php echo $desc; ?></div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
<div style="clear: both;"></div>