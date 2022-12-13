<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row bg-white">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="sidebar-brand brand-logo-mini" href="<?= base_url() ?>">
              <img src="<?= site_url('_/uploads/sites/'.$this->app->site_logo) ?>" alt="<?= $this->app->site_name ?>" width="40px"/>
            </a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="fas fa-bars"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown">
                <div id="jam" class="float-right text-grey-m2"></div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="<?= site_url('_/uploads/users/'.$this->session->userdata('uid').'/'.$this->user->user_picture) ?>" alt="<?= $this->user->employee_name ?>">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name text-gray"><?= $this->user->employee_name ?></p>
                    <i class="ml-4 fas fa-chevron-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu bg-navy dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Akun</h6>
                  <div class="dropdown-divider mb-2"></div>
                  <small class="p-3 text-grey-m2">Login Terakhir: <?= $this->user->last_login ?> | From: <?= $this->user->last_ip ?></small>
                  <div class="dropdown-divider mt-2"></div>
                  <a id="account" href="#" data-toggle="modal" data-target="#accountModal" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="fas fa-cog text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Akun</p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item" id="password" href="#" data-toggle="modal" data-target="#passwordModal">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="fas fa-key text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Ganti Kata Sandi</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a id="logout" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="fas fa-sign-out-alt text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Keluar</p>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="fas fa-bars"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">