<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Portal Admin <?= $this->app->site_name ?>">
    <meta name="author" content="Muhammad Ridwan Na'im, Saidul Gofar">
    <meta name="X-CSRF-TOKEN" content="<?= $this->security->get_csrf_hash();?>">
    
		<title><?= $title ?></title>

    <!-- Favicons -->
    <?= show_image('sites/'.$this->app->site_logo, 'icon', 'type="'.mime_content_type(FCPATH.'_/uploads/sites/'.$this->app->site_logo).'" sizes="16x16"') ?>

    <link rel="apple-touch-icon" href="<?= site_url('_/uploads/sites/'.$this->app->site_logo)?>">

		<!-- Core -->
		<?= css('admin_style') ?>
			
		<?php $this->_CI->load_css() ?>
		
		<?php $this->_CI->load_css_plugin() ?>

		<?php $this->_CI->load_external_css() ?>

		<?= plugin('select2/select2.min');?>

		<?= plugin('fontawesome/css/all.min');?>

		<?= plugin('mdi/css/materialdesignicons.min');?>

		<?= plugin('sweetalert2/dist/sweetalert2.min'); ?>

		<?= css('app-dev') ?>

		<?= css('custom') ?>

    <script nonce="<?= NONCE ?>">
      let baseURI = '<?= base_url() ?>';
    </script>
	</head>
	<body>
	<noscript>
			<div class="modal d-flex fade-in" tabindex="-1" role="dialog" aria-hidden="false">
	        <div class="modal-dialog modal-md" role="document">
	            <div class="modal-content h-75">
	                <div class="modal-header">
	                    <h3 class="modal-title" id="judul_memo">PERHATIAN!</h3>
	                </div>
	                <div class="modal-body text-center p-5">
	                    <h5>Peramban anda mencekal penggunaan javascript!</h5>
	                    <small class="text-danger">Mencekal penggunaan javascript akan membuat aplikasi tidak berjalan dengan baik. Izinkan javascript berjalan lalu muat ulang kembali halaman ini.</small>
	                </div>
	            </div>
	        </div>
	    </div>
	</noscript>