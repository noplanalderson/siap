<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    
                    <h4 class="card-title mt-2">Pengaturan Website</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                          <?= form_open('', 'id="formSetting" class="form-sample"');?>
                          <div class="form-group">
                            <label for="site_name">Nama Instansi *</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Nama Instansi" value="<?= $this->app->site_name ?>" required="required">
                            <small class="text-danger">Nama instansi digunakan sebagai judul utama website</small>
                          </div>
                          <div class="form-group">
                            <label for="site_tagline">Tagline</label>
                            <input type="text" class="form-control" id="site_tagline" name="site_tagline" placeholder="Tagline" value="<?= $this->app->site_tagline ?>">
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-6">
                                <label for="site_email">Email Instansi *</label>
                                <input type="email" class="form-control" id="site_email" name="site_email" placeholder="Email Instansi" value="<?= $this->app->site_email ?>" required="required">
                                
                              </div>
                              <div class="col-6">
                                <label for="site_phone">No. Telepon</label>
                                <input type="text" class="form-control" id="site_phone" name="site_phone" placeholder="No. Telepon (Contoh: +62xxxx / 021xxx)" value="<?= $this->app->site_phone ?>">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="site_address">Alamat *</label>
                            <textarea class="form-control" id="site_address" name="site_address" rows="4" required><?= $this->app->site_address ?></textarea>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-6 col-sm-12">
                                <label>Logo Instansi</label>
                                <input type="file" name="site_logo" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Cari...</button>
                                  </span>
                                </div>
                                <small class="text-danger">Logo ini digunakan sebagai icon website</small>
                              </div>
                              <div class="col-md-6 col-sm-12">

                                <label>Logo Instansi (alt)</label>
                                <input type="file" name="site_logo_alt" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Unggah Gambar">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Cari...</button>
                                  </span>
                                </div>
                                <small class="text-danger">Logo ini digunakan sebagai banner pada sidebar admin dan footer halaman utama</small>
                              </div>
                            </div>
                          </div>
                          <button type="submit" id="btnSave" class="btn btn-primary p-md-2 float-right"><i id="saveIcon" class="fas fa-save"></i><i id="loadingIcon" class="fa fa-spinner fa-spin fa-fw d-none"></i><span class="sr-only">Loading...</span> Simpan</button>
                          <button type="reset" class="btn btn-dark p-md-2 mr-2 float-right"><i class="fas fa-redo"></i>Reset</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>