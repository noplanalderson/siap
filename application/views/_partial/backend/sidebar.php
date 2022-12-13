<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <div class="container-scroller">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas bg-secondary" id="sidebar">
          <div class="sidebar-brand-wrapper bg-secondary d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo text-white text-center mr-4 text-decoration-none" href="<?= base_url() ?>">
              <h3 class="text-white"><?= $this->app->site_name ?></h3>
            </a>
            <a class="sidebar-brand brand-logo-mini" href="<?= base_url() ?>"><img src="<?= site_url('_/uploads/sites/'.$this->app->site_logo) ?>" class="w-75 h-75" alt="Logo" /></a>
          </div>
          <ul class="nav active">
            <li class="nav-item profile">
              <div class="profile-desc">
                <div class="profile-pic">
                  <div class="count-indicator">
                    <img class="img-xs rounded-circle " src="<?= site_url('_/uploads/users/'.$this->session->userdata('uid').'/'.$this->user->user_picture) ?>" alt="<?= $this->user->employee_name ?>">
                    <span class="count bg-success"></span>
                  </div>
                  <div class="profile-name">
                    <h5 class="mb-0 font-weight-normal"><?= $this->user->employee_name ?></h5>
                    <span class="text-metro"><?= $this->user->group_name ?></span>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item nav-category">
              <span class="nav-link">Navigasi</span>
            </li>
            <?php 
              foreach ($this->menus as $menu) :

              $submenus = $this->app_m->getSubMenu($menu->grup_fitur);
              if(empty($submenus)) {
            ?>

            <li class="nav-item menu-items">
              <a class="nav-link" href="<?= base_url('admin/'.$menu->slug_menu) ?>">
                <span class="menu-icon">
                  <i class="<?= $menu->icon_menu ?>"></i>
                </span>
                <span class="menu-title"><?= $menu->label_menu ?></span>
              </a>
            </li>
            <?php } else { ?>

            <li class="nav-item menu-items">
              <a class="nav-link" data-toggle="collapse" href="<?= $menu->slug_menu ?>" aria-expanded="false" aria-controls="<?= ltrim($menu->slug_menu, '#') ?>">
                <span class="menu-icon">
                  <i class="<?= $menu->icon_menu ?>"></i>
                </span>
                <span class="menu-title"><?= $menu->label_menu ?></span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="<?= ltrim($menu->slug_menu, '#') ?>">
                <ul class="nav flex-column sub-menu">
                  <?php foreach ($submenus as $submenu): ?>

                  <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/'.$submenu->slug_menu) ?>">
                      <i class="<?= $submenu->icon_menu ?> text-white mr-1"></i>
                      <span class="text-white"><?= $submenu->label_menu ?></span>
                    </a>
                  </li>
                  <?php endforeach; ?>

                </ul>
              </div>
            </li>
            <?php } endforeach;?>
            <li class="nav-item menu-items">
              <a class="nav-link" href="<?= base_url('admin/logout') ?>">
                <span class="menu-icon">
                  <i class="fas fa-sign-out-alt"></i>
                </span>
                <span class="menu-title">Keluar</span>
              </a>
            </li>
          </ul>
        </nav>