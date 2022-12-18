<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card shadow">
                  <div class="card-header">
                    <h4 class="card-title float-left"><?= $loket['counter_name'] ?></h4>
                  </div>
                  <div class="card-body">
                    <input type="hidden" id="counter_id" value="<?= $loket['counter_id'] ?>">
                    <div id="msg"></div>
                    <audio id="audiobell" src="<?= site_url('_/audio/Airport_Bell.mp3') ?>" class="d-none"></audio>
                    <input type="hidden" id="counter_seq" value="<?= $loket['counter_sequence'] ?>">
                    <div class="row mb-4  text-center">
                      <div class="col-12">
                        
                        <div class="card">
                          <div class="card-body text-black-50 font-weight-bold">
                            <h4>Nomor Antrian</h4>
                            <h1 style="font-size: 50pt;" id="queue"><?= ($last_queue['queue_num'] ?? '-') ?></h1>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-3">
                        <button type="button" class="btn btn-block btn-danger py-4" data-id="<?= $loket['counter_id'] ?>" id="close"><i class="fas fa-times-circle"></i> Tutup</button>
                        
                      </div>
                      <div class="col-3">
                        <button type="button" class="btn btn-block btn-info py-4" id="refresh"><i class="fas fa-sync"></i> Refresh</button>
                      </div>
                      <div class="col-3">
                        <button type="button" class="btn btn-block btn-warning py-4" id="call" <?php if(empty($last_queue['transaction_id'])) : ?> disabled="disabled" <?php endif;?>><i class="fas fa-volume-up"></i> Panggil</button>
                      </div>
                      <div class="col-3">
                        
                        <button type="button" class="btn btn-block btn-primary py-4" data-queue="<?= ($last_queue['transaction_id'] ?? '') ?>" data-id="<?= $loket['counter_id'] ?>" id="next" <?php if(empty($last_queue['transaction_id'])) : ?> disabled="disabled" <?php endif;?>><i class="fas fa-forward"></i> Selanjutnya</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>