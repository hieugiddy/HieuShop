<?php
/*------------------------------------------------------------------------
# plg_vmproductcompare - Virtuemart Product Compare 
# ------------------------------------------------------------------------
# author    WebKul software private limited 
# copyright Copyright (C) 2010 webkul.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://webkul.com
# Technical Support:  Forum - http://webkul.com/index.php?Itemid=86&option=com_kunena
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.session.session' );
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'plugins/system/vmproductcompare/css/addtocompare.css');
class plgSystemVmproductcompare extends JPlugin
{
	function plgSystemVmproductcompare(& $subject, $config) {
      parent :: __construct($subject, $config);
    }
	function onAfterRender() {
	    $app = JFactory::getApplication();	
      	if (!$app->isAdmin()) {					
				$document = JFactory::getDocument();
				$body_compare = JResponse::getBody();
				$view = JRequest::getCmd('view');	
				$product_id = JRequest::getCmd('virtuemart_product_id');				
				$plugin = JPluginHelper::getPlugin('system', 'vmproductcompare');				  
				$params = new JRegistry($plugin->params);
				$wk_comp_jquery=$params->get('jquery');
				$country=$params->get('country');
				$wk_compare_attach_class=$params->get('wk_compare_attach_class');
				$content = '';
				$content_jquery = '';
				if($view =="productdetails") {
				 
				$session = JFactory::getSession();				
				$unique_id=$session->get( 'unique_id');
				$session_product=$session->get($unique_id);
				
				if($unique_id==NULL){			
				$unique_id=uniqid();
					$session->set( 'unique_id', $unique_id );
					$unique_id=$session->get( 'unique_id');
				}
					$unique_id=$session->get( 'unique_id');
				
				$db = JFactory::getDBO();
				
				if($country) {
				$query = 'SELECT vpm.virtuemart_media_id, vpe.product_name
						FROM #__virtuemart_product_medias As vpm
						LEFT JOIN #__virtuemart_products_'.$country.' AS vpe ON vpe.virtuemart_product_id = vpm.virtuemart_product_id 
						WHERE vpm.virtuemart_product_id ='.$product_id;
				$db->setQuery($query);
				$virtuemart_media_data = $db->loadObjectlist();
				$virtuemart_media_id=$virtuemart_media_data[0]->virtuemart_media_id;
				$virtuemart_product_name=$virtuemart_media_data[0]->product_name;
			
				$query1 = 'SELECT file_url
						FROM #__virtuemart_medias WHERE virtuemart_media_id ='.$virtuemart_media_id;
				$db->setQuery($query1);
				$virtuemart_products = $db->loadResult();
				//print_r($virtuemart_products);
				}
				 $mycss ='';				
				 $mycss ='<style type="text/css">
						#vmcompare {
							display: block;
							padding-left: 15px;
							padding-top: 15px;
						}	
						
						#vmcompare a{
						  
							border: 1px solid #095197;
							border-radius: 4px 4px 4px 4px;
							
							cursor: pointer;
							font-size: 14px;
							height: 34px;
							letter-spacing: 0;
							padding: 5px 10px;
							text-align: center;
							text-decoration: none;
							width: 120px;
						}
						
						
						#vmcompare a:hover{						
						  
						}	
				</style>';
				
				if($wk_comp_jquery == 'Head'){
					$content_jquery .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>';
					}
				else if($wk_comp_jquery == 'Inline'){	
					$content .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>';
					}
			$arr = array($session_product);	
			$error_msg= "<div class='cmp_title'>".jtext::_('THE_PRODUCT_HAS_BEEN_ADDED_TO_YOUR_COMPARISION_LIST')."</div>";
			$counter = 0;
			  if($session_product){    		
				
				foreach($session_product->productid as $result)
				    {				    
				      if($result)
					{				    
					$counter++;
					}
					
				      
				    }
				 
				
				if (in_array($product_id, $session_product->productid)) {
				
					$error_msg="<div class='cmp_title_addmsg'>".jtext::_('THIS_PRODUCT_IS_ALREADY_ADDED_TO_YOUR_ADD_TO_COMPARE_CART')."</div>";
					}
					else if($counter == '3')
					{
					$error_msg="<div class=\'cmp_title_addmsg\' style='background:#e67e22; border: 1px solid #e67e22;'>".jtext::_('YOUR_ADD_TO_COMPARE_CART_IS_FULL_NEED_TO_REMOVE_ANY_ONE_PRODUCT_TO_ADD_NEW_ONE')."</div>"; ?>
					<style>
					.remove
					{
					display:none;
					}
					</style>
					
				<?php	} else
					{
					$error_msg= "<div class=\'cmp_title\'>".jtext::_('THE_PRODUCT_HAS_BEEN_ADDED_TO_YOUR_COMPARISION_LIST')."</div>";
					}
				
				}  
				    
				   if($counter<3)
				   { 			    
				   
				$content .='<script type="text/javascript">jQuery.noConflict(); jQuery(document).ready(function(){ jQuery("#vmcompare").remove();jQuery("'.$wk_compare_attach_class.'").after("<div id=vmcompare><a href=javascript:void(0);>'.jtext::_("ADD_TO_COMPARE").'</a></div><div id=wk_compare><div class=modal-header><span class=wk-close></span><div class=comp_head><div class=compare_image><img src='.juri::root().$virtuemart_products.' class=compare_image></div><div class=compare_heading>'.$virtuemart_product_name.'</div><div class=remove>x '.jtext::_("REMOVE").'</div></div>'.$error_msg.'<div class=cmp_title_remove>'.jtext::_("THE_PRODUCT_HAS_BEEN_DELETED_SUCCESSFULLY").'</div><div class=comp_buttons><div class=add_continue style=float:left;><a href=javascript:void(0);>'.jtext::_("CONTINUE_SHOPPING").'</a></div><div  class=add_compare><a href='.JURI::Base().'index.php?option=com_virtuemartproductcompare&view=productcompare&product_id='.$product_id.'&unique_id='.$unique_id.'>'.jtext::_("GO_TO_COMPARE").'</a></div></div><span style=clear:both;></span></div></div>");';
					
					$content .='jQuery("#vmcompare").click(function(){				  
				      jQuery.ajax({
					    url:"'.JURI::root().'plugins/system/vmproductcompare/compare_ajax.php'.'",
					    datatype:"JSONP",
					    data:{"product_id":'.$product_id.',"unique_id":"'.$unique_id.'","method":"compare"},
					    type:"post",
					    success:function(data){
					     jQuery(".cmp_title").show();
					    jQuery(".cmp_title_remove").hide();   
					    
					    },
					    error: function(){
						   
					    }
				    });
				    
				     jQuery(".remove").click(function(){				  
				      jQuery.ajax({
					    url:"'.JURI::root().'plugins/system/vmproductcompare/compare_ajax.php'.'",
					    datatype:"JSONP",
					    data:{"product_id":'.$product_id.',"unique_id":"'.$unique_id.'","method":"remove"},
					    type:"post",
					    success:function(data){
					    jQuery(".cmp_title").hide();
					     jQuery(".cmp_title_addmsg").hide();
					    jQuery(".cmp_title_remove").show();
					   
					    },
					    error: function(){
					
					    }
				    });
				    
				    });
				   
				      jQuery("#wk_compare").show();
				      jQuery("#vmproductcompare_overlay").show();
				    
				  });
				  jQuery(".wk-close").click(function(){				  
				     
				      jQuery("#wk_compare").hide();
				      jQuery("#vmproductcompare_overlay").hide();
				      location.reload();
				  });
				  jQuery(".add_continue").click(function(){				  
				     
				       jQuery("#wk_compare").hide();
				      jQuery("#vmproductcompare_overlay").hide();
				       location.reload();
				
				  });
				  
				  
				  });
				</script>';  
				   
				  
				 } else if($counter=='3') { 
				   
				   
				   $content .='<script type="text/javascript">jQuery.noConflict();jQuery(document).ready(function(){jQuery("#vmcompare").remove();jQuery("'.$wk_compare_attach_class.'").after("<div id=vmcompare><a href=javascript:void(0);>'.jtext::_('ADD_TO_COMPARE').'</a></div><div id=wk_compare><div class=modal-header><span class=wk-close></span><div class=comp_head><div class=compare_image><img src='.juri::root().$virtuemart_products.' class=compare_image></div><div class=compare_heading>'.htmlspecialchars($virtuemart_product_name).'</div><div class=remove>x '.jtext::_("REMOVE").'</div></div>'.$error_msg.'<div class=cmp_title_remove>'.jtext::_("THE_PRODUCT_HAS_BEEN_DELETED_SUCCESSFULLY").'</div><div class=comp_buttons><div class=add_continue style=float:left;><a href=javascript:void(0);>'.jtext::_("CONTINUE_SHOPPING").'</a></div><div  class=add_compare><a href='.JURI::Base().'index.php?option=com_virtuemartproductcompare&view=productcompare&product_id='.$product_id.'&unique_id='.$unique_id.'>'.jtext::_("GO_TO_COMPARE").'</a></div></div><span style=clear:both></span></div></div>");'; 
				 
				$content .='jQuery("#vmcompare").click(function(){
							jQuery(".cmp_title_addmsg").show(); 
							jQuery(".cmp_title_remove").hide();';
				  $content .=' jQuery(".remove").click(function(){				  
				      jQuery.ajax({
					    url:"'.JURI::root().'plugins/system/vmproductcompare/compare_ajax.php'.'",
					    datatype:"JSONP",
					    data:{"product_id":'.$product_id.',"unique_id":"'.$unique_id.'","method":"remove"},
					    type:"post",
					    success:function(data){
					    jQuery(".cmp_title_addmsg").hide();
					    jQuery(".cmp_title_remove").show(); 					    
					    },
					    error: function(){
						   
					    }
				    });
				    
				    });
				  
				      jQuery("#wk_compare").show();
				      jQuery("#vmproductcompare_overlay").show();
				      
				  });
				  jQuery(".wk-close").click(function(){				  
				     
				      jQuery("#wk_compare").hide();
				      jQuery("#vmproductcompare_overlay").hide();
				      location.reload();
				  });
				   jQuery(".add_continue").click(function(){				  
				     
				      jQuery("#wk_compare").hide();
				      jQuery("#vmproductcompare_overlay").hide();
				       location.reload();
				      
				  });
				  
				  
				  });
				</script>';	   
				  	 
			 }
			 	//$content = htmlspecialchars($content);
				$vmproductcompare_overlay ='<div id="vmproductcompare_overlay"></div></body>';
				$body_compare = preg_replace ('/<\/body>/', $vmproductcompare_overlay, $body_compare ); 
				$body_compare = preg_replace ('/<head>/', '<head>'.$content_jquery, $body_compare );   
				$body_compare = preg_replace ('/<\/body>/', $content.'</body>', $body_compare );
				$body_compare = preg_replace ('/<\/head>/', $mycss.'</head>', $body_compare );                     
				JResponse::setBody($body_compare);
			}			
		}	
		
	}
}
?>