<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title">Transaksi Loket</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <div id="filter" class="row text-black-50 mb-5">
                        <div class="col-3">
                          <label for="counter_id">Loket</label>
                          <select name="counter_id" id="counter_id" class="form-control" required>
                            <option value="">Pilih Loket</option>
                            <?php foreach ($loket as $value) : ?>
                            
                            <option value="<?= $value['counter_id'] ?>"><?= $value['counter_name'] ?></option>
                            <?php endforeach;?>
                          
                          </select>
                        </div>
                        <div class="col-3">
                          <label for="start_date">Dari</label>
                          <input type="date" id="start_date" name="start_date" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-3">
                          <label for="end_date">Sampai</label>
                          <input type="date" id="end_date" name="end_date" class="form-control" placeholder="" required>
                        </div>
                        <div class="col-3 btn-group-vertical">
                          <button type="button" class="btn btn-md btn-primary submit_filter" id="submit_filter">Submit</button>
                        </div>
                      </div>
                      <table id="tbl_transaksi" class="table table-striped table-bordered w-100">
                        <thead>
                          <tr>
                            <th width="25%">ID Transaksi</th>
                            <th width="25%">Tanggal</th>
                            <th>Loket</th>
                            <th width="25%">Petugas</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>