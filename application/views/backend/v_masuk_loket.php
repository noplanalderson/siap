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
                    <audio id="audiobell" src="<?= site_url('_/audio/Airport_Bell.mp3') ?>" class="d-none"></audio>
                    <div class="row mb-4  text-center">
                      <div class="col-12">
                        
                        <div class="card">
                          <div class="card-body text-black-50 font-weight-bold">
                            <h4>Nomor Selanjutnya</h4>
                            <h1 style="font-size: 50pt;" id="queue"><?= $next_queue ?></h1>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button type="button" class="btn btn-block btn-secondary" data-id="<?= $loket['counter_id'] ?>" id="close"><i class="fas fa-times-circle"></i> Tutup</button>
                        
                      </div>
                      <div class="col-6">
                        
                        <button type="button" class="btn btn-block btn-primary" data-id="<?= $loket['counter_id'] ?>" id="call"><i class="fas fa-volume-up"></i> Panggil</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
