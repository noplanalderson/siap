<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
          <footer class="footer bg-white">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?= date('Y') ?> |  <?= $this->app->site_name . ' v'. APP_VERSION ?></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><?= $this->app->site_name ?></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- Password Modal-->
    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-grey-m1" id="exampleModalLabel">Change Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open('change-password', 'id="formGantiPwd" method="post"');?>
                    <div class="form-group">
                        <label for="user_password my-2">Password *</label>
                        <div class="input-group">
                            <input id="user_password" 
                                type="password" 
                                class="form-control" 
                                placeholder="********"
                                name="user_password" 
                                data-parsley-pattern="^(?=.*[0-9])(?=.*[a-zA-Z]).{8,32}$"
                                data-parsley-errors-container="#pwd-error"
                                required="required" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text show-btn-password"><i class="fa fa-eye password"></i></span>
                            </div>
                        </div>
                        <small class="text-danger">Password must contains alphabet and numeric min. 8 characters.</small>
                        <div id="pwd-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="user_password my-2">Repeat Password *</label>
                        <div class="input-group">
                            <input id="repeat_password" type="password" class="form-control" placeholder="********" name="repeat_password" data-parsley-equalto="#user_password" 
                                data-parsley-errors-container="#repeat-error" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text show-btn-repeat"><i class="fa fa-eye repeat"></i></span>
                            </div>
                        </div>
                        <div id="repeat-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input id="submitPassword" type="submit" class="btn btn-small btn-primary" name="submit" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-grey-m1" id="exampleModalLabel">Pengaturan Akun dan Profil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?= form_open_multipart('update-account', 'id="formAccount" method="post"');?>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="user_name">Username *</label>
                                <input id="user_name__account" type="text" class="form-control" name="user_name" placeholder="Username (ex: user_name)" data-parsley-pattern="^[A-Za-z0-9._]{3,15}$" required="required">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="user_email">Email *</label>
                                <input id="user_email__account" type="email"  class="form-control" name="user_email" placeholder="you@somewhere.com" required="required">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input id="submitAkun" type="submit" class="btn btn-small btn-primary" name="submit" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>