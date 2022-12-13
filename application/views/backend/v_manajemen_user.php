<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title float-left">Manajemen User</h4>
                    <?= button($btn_tambah, TRUE, 'a', 'href="#" class="btn btn-md tambah-user btn-primary float-right" data-toggle="modal" data-target="#userModal"') ?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tbl_user" class="table table-striped table-bordered w-100">
                        <thead>
                          <tr>
                            <th>Petugas</th>
                            <th class="no-sort">Grup User</th>
                            <th class="no-sort">Status</th>
                            <th class="no-sort">Aksi</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" tabindex="-1" id="userModal" role="dialog" aria-labelledby="Manage User" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-grey-m1"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

              <?= form_open('', 'id="form_user" method="post"');?>

              <input type="hidden" id="user_id" name="user_id" value="<?= uniqidReal() ?>">

              <div class="form-group">  
                <label for="employee_name">Nama User *</label>
                <input id="employee_name" type="text" class="form-control" name="employee_name" placeholder="Nama User" required="required">
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <label for="username">Username *</label>
                    <input id="username" type="text" class="form-control" name="username" placeholder="Username (ex: user_name)" pattern="^[a-z0-9_]{3,15}$" required="required">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <label for="user_password my-2">Password *</label>
                    <div class="input-group">
                        <input id="user_password_emp" 
                            type="text" 
                            class="form-control" 
                            placeholder="********"
                            name="user_password" 
                            pattern="^(?=.*[0-9])(?=.*[a-zA-Z]).{8,32}$"
                            required="required" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text show-btn-password"><i class="fa fa-eye-slash hide-btn password"></i></span>
                        </div>
                    </div>
                    <small class="text-danger">Password harus mengandung alfanumerik min. 8 karakter.</small>
                  </div>

                  <div class="col-sm-12 col-md-6">
                    <label for="user_password my-2">Ulangi Password *</label>
                    <div class="input-group">
                        <input id="repeat_password_emp" type="text" class="form-control" placeholder="********" name="repeat_password" autocomplete="off">
                        <div class="input-group-prepend">
                            <span class="input-group-text show-btn-repeat"><i class="fa fa-eye-slash hide-btn repeat"></i></span>
                        </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 col-md-12">
                  <div class="custom-file">
                    <input type="file" class="form-control" name="foto" id="foto">
                  </div>
                </div>
              </div> 

              <div class="row mt-3">
                <div class="col-sm-12 col-md-4">
                  <div class="form-group">
                    <label for="group_id">User Group *</label>
                    <select id="group_id" class="form-control" name="group_id" required="required">
                      <option value="">Pilih Grup</option>
                      <?php foreach ($user_group as $ug) :?>
                      
                        <option value="<?= $ug->group_id ?>"><?= $ug->group_name ?></option>

                      <?php endforeach;?>

                    </select>
                  </div>
                </div>

                <div class="col-sm-12 col-md-4">
                  <div class="custom-control custom-switch mt-4">
                    <input type="checkbox" name="status" class="custom-control-input" id="status">
                    <label class="custom-control-label text-muted mt-2" for="status">Aktif</label>
                  </div>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button class="btn btn-secondary" type="reset" data-dismiss="modal"><i class="fas fa-sync"></i> Reset</button>
              <button id="submit" class="btn btn-primary" type="submit" name="submit"><i class="fas fa-save"></i> Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>