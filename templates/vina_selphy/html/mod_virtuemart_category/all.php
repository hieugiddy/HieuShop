<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//Include Helix3 plugin
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';

$cat_cols = $helix3->getParam('vm_category_cols', 3);
$cat_max_items = $helix3->getParam('vm_category_maxItems', 3);
$vm_category_title = $helix3->getParam('vm_category_title', 1);
$vm_category_image = $helix3->getParam('vm_category_image', 1);
$vm_category_description = $helix3->getParam('vm_category_description', 1);
$vm_category_view = $helix3->getParam('vm_category_view', 1);
$vm_category_description_limit = $helix3->getParam('vm_category_description_limit', 60);

if (file_exists($helix3_path)) {
    require_once($helix3_path);
    $helix3 = helix3::getInstance();
} else {
    die('Please install and activate helix plugin');
}

/* ID for jQuery dropdown */
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));
$categoryModel->addImages($categories);

$catitem_class = ' class="category-item"';
if( !empty($cat_cols) && ( $cat_cols == 1 || $cat_cols == 2 || $cat_cols == 3 ) ) {
	$catitem_class = ' class="category-item col-sm-12 col-md-'.(12/$cat_cols).'"';
}elseif( $cat_cols == 4 || $cat_cols == 6 ){
	$catitem_class = ' class="category-item col-xs-12 col-sm-6 col-md-'.(12/$cat_cols).'"';
}else {
	$catitem_class = ' class="category-item" style="width:'.(100/$cat_cols).'%"';
}
?>

<ul class="category-custom<?php echo $class_sfx ?>" id="<?php echo "category-custom".$ID ?>" >
	<?php foreach ($categories as $key => $category) {
		if($key < $cat_max_items) {
			$active_menu = 'class="VmClose"';
			$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
			$cattext = $category->category_name;
			
			//var_dump($category);
			$category_description = $category->category_description;	
			if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'class="VmOpen"';
	?>
	
			<li <?php echo $catitem_class ?>>
				<div class="category-item-inner">
					<?php if($vm_category_image) : ?>
						<div class="category-image">					
							<?php echo $category->images[0]->displayMediaFull(); ?>
						</div>
					<?php endif; ?>
					
					<?php if( $vm_category_title || $category_description || $vm_category_view ) :?>
						<div class="category-content">
							<?php if($vm_category_title) : ?>
								<h3 class="category-title">
									<?php echo JHTML::link($caturl, $cattext); ?>
								</h3>
							<?php endif; ?>
							<?php if($category_description) : ?>
								<div class="category-description">
									<?php echo JHTML::_( 'string.truncate', $category_description, $vm_category_description_limit );?>
								</div>
							<?php endif; ?>
							
							<?php if($vm_category_view) : ?>
								<div class="caption-view">
									<i class="dot"></i>
									<a class="cat-view-link" href="<?php echo $caturl; ?>" title="<?php echo $cattext; ?>">
										<?php echo JText::_('VINA_VIEW_CATEGORY'); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					
					<?php if ($category->childs) { ?>
						<span class="VmArrowdown"> </span>
					<?php } ?>
				</div>
				<?php if ($category->childs) { ?>
					<ul class="menu<?php echo $class_sfx; ?>">
						<?php
						$categoryModel->addImages($category->childs);
						foreach ($category->childs as $child) {
							//var_dump($child);
							$active_child_menu = 'class="VmClose"';
							$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
							$cattext = vmText::_($child->category_name);
							$category_description = $child->category_description;
							if ($child->virtuemart_category_id == $active_category_id) $active_child_menu = 'class="VmOpen"';
						?>
						<li <?php echo $active_child_menu ?>>
							<li>
								<a href="<?php echo $caturl; ?>" title="<?php echo $cattext; ?>">
									<?php echo $child->images[0]->displayMediaThumb("",false); ?>
								</a>
								<div ><?php echo JHTML::link($caturl, $cattext); ?></div>
								<p class="category-description">
									<?php echo $category_description; ?>
								</p>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</li>
		<?php } ?>
	<?php } ?>
</ul>
