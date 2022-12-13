<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <!-- Meta Name -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SIAP (Sistem Informasi Antrian Pengunjung)">
    <meta name="author" content="Muhammad Ridwan Na'im">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Open Graph Data General -->
    <meta property="og:locale" content="id-ID"/>
    <meta property="og:site_name" content="<?= $this->app->site_name ?>" />

    <!-- Open Graph Data Page -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= $this->app->site_name ?>" />
    <meta property="og:url" content="<?= rtrim(base_url(), '/') ?>" />
    <meta property="og:description" content="SIAP (Sistem Informasi Antrian Pengunjung)" />
    <meta property="og:image" content="<?= site_url('_/uploads/sites/'.$this->app->site_logo) ?>" />
    <meta property="og:image:type" content="<?= mime_content_type(FCPATH.'_/uploads/sites/'.$this->app->site_logo);?>" />

    <meta name="X-CSRF-TOKEN" content="<?= $this->security->get_csrf_hash();?>">

    <title><?= $title ?></title>
    
    <!-- Favicons -->
    <?= show_image('sites/'.$this->app->site_logo, 'icon', 'type="'.mime_content_type(FCPATH.'_/uploads/sites/'.$this->app->site_logo).'" sizes="16x16"') ?>

    <link rel="apple-touch-icon" href="<?= site_url('_/uploads/sites/'.$this->app->site_logo)?>" sizes="32x32">

    <noscript><?= plugin('bootstrap/css/bootstrap.min','css'); ?></noscript>

    <link rel="preload" href="<?= site_url('_/vendors/bootstrap/css/bootstrap.min.css') ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">

    <?= css('custom') ?>

    <?php $this->_CI->load_css() ?>
    
    <?php $this->_CI->load_css_plugin() ?>

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