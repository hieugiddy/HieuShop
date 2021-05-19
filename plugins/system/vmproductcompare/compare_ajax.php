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



define('_JEXEC', 1);
$dir = dirname(__FILE__);
$location = preg_replace(array('/(\/plugins|\\\\plugins)/','/(\/system|\\\\system)/','/(\/vmproductcompare|\\\\vmproductcompare)/'), '', $dir);

define( 'DS', DIRECTORY_SEPARATOR );
define('JPATH_BASE', $location );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$mainframe =& JFactory::getApplication('site');
$mainframe->initialise();




$unique_id= $_POST['unique_id'];
$product_id= $_POST['product_id'];
$method= $_POST['method'];


$session = JFactory::getSession();

$session_product=$session->get($unique_id);


$sessionCompare = new stdClass();
if($method=='compare'){
	if($session_product==NULL){


	$sessionCompare->productid[0] = $product_id;
	$sessionCompare->productid[1] = '';
	$sessionCompare->productid[2] = '';
	$session->set( $unique_id , $sessionCompare );
	$session = JFactory::getSession();
	}
	else if($session_product->productid[1]=='' && $product_id!=$session_product->productid[0])
	{
	echo 'i am here ';
	echo $product_id;
	echo $session_product->productid[0];
	$sessionCompare->productid[0] = $session_product->productid[0];
	$sessionCompare->productid[1] = $product_id;
	$sessionCompare->productid[2] = '';
	//print_r($sessionCompare);
	$session->set( $unique_id , $sessionCompare );
	} else if($session_product->productid[2]=='' && $product_id!=$session_product->productid[1] && $product_id!=$session_product->productid[0] )
	{
	echo 'i am here 2 ';
	$sessionCompare->productid[0] = $session_product->productid[0];
	$sessionCompare->productid[1] = $session_product->productid[1];
	$sessionCompare->productid[2] = $product_id;
	//print_r($sessionCompare);
	$session->set( $unique_id , $sessionCompare );
	} else if($session_product->productid[0]=='' && $product_id!=$session_product->productid[1] && $product_id!=$session_product->productid[2] )
	{
	echo 'i am here 3 ';
	$sessionCompare->productid[0] = $product_id;
	$sessionCompare->productid[1] = $session_product->productid[1];
	$sessionCompare->productid[2] = $session_product->productid[2];
	//print_r($sessionCompare);
	$session->set( $unique_id , $sessionCompare );
	}
}

if($method=='remove'){
if ($session_product->productid[0]==$product_id){
$sessionCompare->productid[0] = '';
	$sessionCompare->productid[1] = $session_product->productid[1];
	$sessionCompare->productid[2] = $session_product->productid[2];
	//print_r($sessionCompare);
	$session->set( $unique_id , $sessionCompare );
} else if($session_product->productid[1]==$product_id) {

$sessionCompare->productid[0] = $session_product->productid[0];
	$sessionCompare->productid[1] = '';
	$sessionCompare->productid[2] = $session_product->productid[2];
	//print_r($sessionCompare);
	$session->set( $unique_id , $sessionCompare );

} else if($session_product->productid[2]==$product_id) {

$sessionCompare->productid[0] = $session_product->productid[0];
	$sessionCompare->productid[1] = $session_product->productid[1];
	$sessionCompare->productid[2] = '';
	//print_r($sessionCompare);
	$session->set( $unique_id , $sessionCompare );
}





} ?>