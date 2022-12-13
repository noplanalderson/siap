<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Widget {
	
	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('widget_m');
	}

	public function wg_sosmed()
	{
		return '
		<!-- Widget Area -->
        <div class="sidebar-widget-area">
            <h5 class="title">Ikuti Kami!</h5>
            <div class="widget-content">
                <div class="social-area d-flex justify-content-between">
                    <a href="'.$this->CI->app->facebook.'"><i class="fab fa-facebook-f"></i></a>
                    <a href="'.$this->CI->app->twitter.'"><i class="fab fa-twitter"></i></a>
                    <a href="'.$this->CI->app->youtube.'"><i class="fab fa-youtube"></i></a>
                    <a href="'.$this->CI->app->tiktok.'"><i class="fab fa-tiktok"></i></a>
                    <a href="'.$this->CI->app->instagram.'"><i class="fab fa-instagram"></i></a>
                    <a href="'.$this->CI->app->website.'"><i class="fas fa-globe"></i></a>
                </div>
            </div>
        </div>';
	}

	public function wg_pop_kategori()
	{
		return '
		<!-- Widget Area -->
        <div class="sidebar-widget-area">
            <h5 class="title">Kategori Populer</h5>
            <div class="widget-content">'.$this->CI->widget_m->getPopKategori().'
            </div>
        </div>';
	}

	public function wg_pop_tags()
	{
		return '
		<!-- Widget Area -->
        <div class="sidebar-widget-area">
            <h5 class="title">Tag Populer</h5>
            <div class="widget-content">'.$this->CI->widget_m->getPopTags().'
            </div>
        </div>';
	}

	public function wg_arsip()
	{
		return '
		<!-- Widget Area -->
        <div class="sidebar-widget-area">
            <h5 class="title">Arsip</h5>
            <div class="widget-content">
                <form action="index_submit" method="get" accept-charset="utf-8">
                    <div class="row">
                        <div class="col-12 p-1">
                            <select name="month" class="form-control" required>
                                <option value="">Bulan</option>
                                '.$this->CI->widget_m->getMonthlyArchive().'
                            </select>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>';
	}

	public function wg_video()
	{
		return '
		<!-- Widget Area -->
        <div class="sidebar-widget-area">
            <h5 class="title">Video Terakhir</h5>
            <div class="widget-content">
                '.$this->CI->widget_m->getLatestVideo().'
                
            </div>
        </div>';
	}
}