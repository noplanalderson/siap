<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title float-left">Grup User</h4>
                    <?= button($btn_tambah, TRUE, 'a', 'href="#" class="btn btn-md tambah-grup btn-primary float-right" data-toggle="modal" data-target="#grupModal"') ?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tbl_grup" class="table table-striped table-bordered w-100">
                        <thead>
                          <tr>
                            <th>Grup</th>
                            <th class="wrapok">Fitur</th>
                            <th>Index</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th colspan="3">Total Grup</th>
                            <th id="total"></th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" tabindex="-1" id="grupModal" role="dialog" aria-labelledby="Grup User" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-grey-m1"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

              <?= form_open('', 'id="form_grup" method="post"');?>

              <input type="hidden" id="group_id" name="group_id" value="">

              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="group_name">Nama Grup *</label>
                    <input id="group_name" type="text" class="form-control" name="group_name" placeholder="Nama Grup" required="required">
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="mode">Mode *</label>
                    <select id="mode" class="form-control" name="mode" required="required">
                      <option value="">Pilih Mode</option>
                      <option value="r">Baca Saja</option>
                      <option value="rw">Baca Tulis</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="fitur">Grup Fitur *</label>
                <select id="fitur" class="form-control" name="fitur" required="required" multiple=""></select>
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