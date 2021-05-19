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

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class modVinaCSS3ImageGalleryHelper
{
    public static function getSildes($slider)
	{
        switch($slider->src)
		{
			case "dir":
					$rows = self::getDataFromDirectory($slider);
                break;
			default:
					$rows = $slider->list;
				break;
		}
		return $rows;
    }
	
	public static function getDataFromDirectory($slider)
    {
        $dir = $slider->dir->path;
		
        if(strrpos($dir,'/') != strlen($dir) -1) $dir .= '/';
        
		$files 		= JFolder::files($dir);
        $accept 	= explode(',', strtolower($slider->dir->ext));
        $outFiles 	= array();
        $i = 0;
		
        if(count($files))
		{
            foreach($files as $file)
            {
                $lastDot 	= strrpos($file, '.');
                $ext 		= substr($file, $lastDot);
            
                if(in_array(strtolower($ext), $accept))
                {
                    $outFiles[$i] = new stdClass();
					$outFiles[$i]->img  = $dir . $file;
					$outFiles[$i]->name = $file;
					$outFiles[$i]->text = "";
                    $i++;
                }
            }
		}
		
        return $outFiles;
    }
}