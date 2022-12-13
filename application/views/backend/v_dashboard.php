<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

          <div class="content-wrapper">
            <div class="row" id="row_satu">
              <div class="col-12 text-center">
                <h1 class="py-3"><i class="fas fa-lg fa-fw fa-spinner fa-spin text-muted"></i></h1>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title mt-2 float-left">Pengunjung Setahun Terakhir</h4>
                    <button id="btn-download" class="btn btn-md btn-success mt-2 float-right"><i class="fas fa-download"></i> Unduh</button>
                  </div>
                  <div class="card-body">
                    <canvas id="grafik-investor"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>