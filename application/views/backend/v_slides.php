<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title float-left">Slide Gambar</h4>
                    <?= button($btn_tambah, TRUE, 'a', 'href="#" class="btn btn-md tambah-gambar btn-primary float-right" data-toggle="modal" data-target="#slideModal"') ?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tbl_slide" class="table table-striped table-bordered w-100">
                        <thead>
                          <tr>
                            <th>Gambar</th>
                            <th class="wrapok">Judul</th>
                            <th class="wrapok">Deskripsi</th>
                            <th>Pengunggah</th>
                            <th>Tgl. Diunggah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" id="slideModal" tabindex="-1" role="dialog" aria-labelledby="Slide" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <?= form_open('', 'id="slideForm" method="post"');?>
                <div class="form-group">
                  <label for="slide_title">Judul *</label>
                  <input type="hidden" name="slide_id" id="slide_id" value="">
                  <input type="text" class="form-control" name="slide_title" id="slide_title" placeholder="Judul" required>
                </div>
                <div class="form-group">
                  <label for="slide_title">Deskripsi *</label>
                  <textarea name="slide_description" id="slide_description" class="form-control" row="50" placeholder="Deskripsi" required></textarea>
                </div>
                <input type="hidden" id="old_image" name="old_image" value="">
                <div class="custom-file">
                  <input type="file" class="form-control" name="image" id="image">
                </div>
                <div class="custom-control custom-switch mt-4">
                  <input type="checkbox" name="status" class="custom-control-input" id="status">
                  <label class="custom-control-label text-muted mt-2" for="status">Tampilkan</label>
                </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
              <button id="submit" class="btn btn-primary" type="submit" name="submit"><i class="fas fa-save"></i> Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>