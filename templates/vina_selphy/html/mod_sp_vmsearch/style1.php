<?php

    /*
    * VirtueMart Categories Module
    */

?>
<div class="<?php echo $moduleclass_sfx; ?> sp-vmsearch sp-vmsearch-slideToggle " id="sp-vmsearch-<?php echo $module_id ?>">
	<div class="slideToggle-open"><i class="fa fa-search"></i></div>

    <form class="sp-vmsearch-content" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0' ); ?>" method="get">
		
        <div class="sp-vmsearch-categorybox">
            <div class="cat-button dropdown-toggle sp-vmsearch-category-name">
                <div class="category-name-wrapper">
                    <span class="category-name"><?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?></span>
                </div>
                <i class="fa fa-caret-down">&nbsp;</i>
            </div>

            <select name="virtuemart_category_id" class="sp-vmsearch-categories">
                <option value="0" data-name="<?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?>"><?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?></option>
                <?php
                    echo $modSPVMSearchHelper->getTree();
                ?>
            </select>
        </div>

        <input type="hidden" name="limitstart" value="0" />
        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="category" />
        <div class="search-button-wrapper">
            <button type="submit" class="search-button"><i class="fa fa-search"></i><span><?php echo JText::_('SP_VMSEARCH_SEARCH_BUTTON') ?></span></button>
        </div>            
        <div class="search-input-wrapper">
            <input type="text" name="keyword" autocomplete="off" class="sp-vmsearch-box" value="<?php echo JRequest:: getVar('keyword') ?>" placeholder="<?php echo JText::_('LANG_SEARCH');?>"/>
        </div>
		
    </form>
	<?php /* <div class="slideToggle-open slideToggle-close"><i class="fa fa-close"></i></div>  */ ?>
</div>

<script type="text/javascript">
    jQuery(function($){
            
            // change event
            $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-categories').on('change', function(event){
                    var $name = $(this).find(':selected').attr('data-name');
                    $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-category-name .category-name').text($name);

            });


            // typeahed
            $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-box').typeahead({
                    items  : '<?php echo $max_search_suggest; ?>',
                    source : (function(query, process){
                            return $.post('<?php echo JURI::current() ?>', 
                                { 
                                    'module_id': '<?php echo $module_id; ?>',
                                    'char': query,
                                    'category': $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-categories').val()
                                }, 
                                function (data) {
                                    return process(data);
                                },'json');
                    }),
            }); 
    });
    </script>