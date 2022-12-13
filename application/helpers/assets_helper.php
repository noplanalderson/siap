<?php
/*--------------------------------------------------------
 | Assets Helper
 |--------------------------------------------------------
 |
 | Used to called needed assets such css, js, and image
 | 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('css'))
{
	function css($str = '', $ext = 'css', $attr = 'rel="stylesheet"')
	{
		return '<link href="'.site_url(CSS_PATH.$str.'.'.$ext).'" '.$attr.'/>';		
	}
}

if (! function_exists('js'))
{
	function js($str = '', $ext = 'js', $attr = NULL)
	{
		return '<script src="'.site_url(JS_PATH.$str.'.'.$ext).'" '.$attr.'></script>';		
	}
}

if (! function_exists('show_image'))
{
	function show_image($str = '', $type = 'image', $attr = 'alt="image"')
	{
		switch ($type) {
			case 'icon':
				return '<link rel="shortcut icon" href="'.site_url(UPLOAD_PATH . $str).'" '.$attr.'>';
			break;
			
			default:
				return '<img src="'.site_url(UPLOAD_PATH . $str).'" '.$attr.'>';	
			break;
		}
	}
}

if (! function_exists('plugin'))
{
	function plugin($str = '', $type = 'css', $attr = NULL)
	{
		switch ($type) {
			case 'css':
				return '<link rel="stylesheet" href="'.site_url(PLUGIN_PATH.$str.'.'.$type).'" '.$attr.'/>';
			break;
			
			default:
				return '<script src="'.site_url(PLUGIN_PATH.$str.'.'.$type).'" '.$attr.'></script>';
			break;
		}		
	}
}

function backgrounds()
{
	$images = array();
	    
    $directory = array_filter(glob(FCPATH . "_/images/sites/backgrounds/*"), 'is_file');

    foreach($directory as $image)
    {
        $images[] = pathinfo($image, PATHINFO_BASENAME);
    }

    $picked = rand(0,count($images)-1);

    return site_url('_/images/sites/backgrounds/' . $images[$picked]);
}

function login_backgrounds()
{
	$images = array();
	    
    $directory = array_filter(glob(FCPATH . "_/images/sites/bg-login/*"), 'is_file');

    foreach($directory as $image)
    {
        $images[] = pathinfo($image, PATHINFO_BASENAME);
    }

    $picked = rand(0,count($images)-1);

    return site_url('_/images/sites/bg-login/' . $images[$picked]);
}