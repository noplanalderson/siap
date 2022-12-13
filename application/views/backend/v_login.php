<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 col-md-8 mx-auto rounded">
              <div class="card-body px-4 py-4">
                <div class="text-center">
                  <img src="<?= site_url('_/uploads/sites/'.$this->app->site_logo) ?>" width="150">
                  <h4 class="text-black-50 mt-3 font-weight-bold"><?= $this->app->site_name ?></h4>
                </div>
                <div id="alert" class="alert pt-2 pb-1"></div>
                <?= form_open('portaladmin/auth', 'id="formMasuk"');?>
                  <div class="form-group">
                    <input type="text" id="user_name" class="form-control bg-light text-dark border-0" placeholder="Username" required="required" autocomplete="off" autofocus>
                  </div>
                  <div class="form-group">
                    <input type="password" id="user_password" class="form-control bg-light text-dark border-0" placeholder="********" required="required" autocomplete="off">
                  </div>
                  <div class="text-center">
                    <button type="submit" id="submit" name="masuk" class="btn btn-primary btn-block pt-2 pb-2 mt-2"><i class="fas fa-sign-in-alt"></i>Login</button>
                  </div>
                  <div class="text-center text-black-50 mt-3">
                    <small>Copyright &copy; <?= date('Y') .' <br/> '. $this->app->site_name ?> v<?= APP_VERSION ?></small>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->