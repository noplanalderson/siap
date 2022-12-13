<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title float-left">Running Teks</h4>
                    <?= button($btn_tambah, TRUE, 'a', 'href="#" class="btn btn-md tambah-teks btn-primary float-right" data-toggle="modal" data-target="#textModal"') ?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tbl_text" class="table table-striped table-bordered w-100">
                        <thead>
                          <tr>
                            <th class="wrapok">Teks</th>
                            <th>Tgl. Dibuat</th>
                            <th>Dibuat oleh</th>
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

      <div class="modal fade" tabindex="-1" id="textModal" role="dialog" aria-labelledby="Running Text" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-grey-m1"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

              <?= form_open('', 'id="textForm" method="post"');?>

              <input type="hidden" id="text_id" name="text_id" value="">

              <div class="form-group">
                <label for="text">Isi Teks *</label>
                <textarea class="form-control" id="text" name="text" placeholder="Isi Teks" rows="10" required></textarea>
                <small class="text-danger">Karakter yang diizinkan [a-zA-Z0-9 /-_,.&@?()]</small>
              </div>

              <div class="custom-control custom-switch mt-4">
                <input type="checkbox" name="status" class="custom-control-input" id="status">
                <label class="custom-control-label text-muted mt-2" for="status">Tampilkan</label>
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