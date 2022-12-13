<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title float-left">Operator</h4>
                    <?= button($btn_tambah, TRUE, 'a', 'href="#" class="btn btn-md tambah-operator btn-primary float-right" data-toggle="modal" data-target="#operatorModal"') ?>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tbl_operator" class="table table-striped table-bordered w-100">
                        <thead>
                          <tr>
                            <th>Nama Petugas</th>
                            <th>Loket</th>
                            <th class="wrapok">Aksi</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

      <div class="modal fade" tabindex="-1" id="operatorModal" role="dialog" aria-labelledby="Running Text" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-grey-m1"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

              <?= form_open('', 'id="operatorForm" method="post"');?>

              <input type="hidden" id="operator_id" name="operator_id" value="">

              <div class="form-group">
                <label for="user_id">Petugas *</label>
                <select class="form-control" id="user_id" name="user_id" required>
                  <option value="">Pilih Petugas</option>
                  <?php foreach ($users as $user) :?>
                    <option value="<?= $user->user_id ?>"><?= $user->employee_name?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="counter_id">Loket</label>
                <select class="form-control" id="counter_id" name="counter_id" required>
                  <option value="">Pilih Loket</option>
                  <?php foreach ($counters as $loket) :?>
                    <option value="<?= $loket->counter_id ?>"><?= $loket->counter_name?></option>
                  <?php endforeach; ?>
                </select>
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