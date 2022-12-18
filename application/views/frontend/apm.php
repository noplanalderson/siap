		<!-- Page Content -->
		<div class="container py-5">
			<div class="row mt-5">
			  <div class="col-12">
			  	<div class="card text-light rounded-3" style="background-color: #264653;">
			  		<div class="card-header pt-3 pb-n2">
			  			
			  			<marquee>
			  				<span class="card-title fs-5 fw-bold">
			  				<?php foreach ($running_text as $txt) :?>
			  					<?= $txt->text ?> &bull;
			  				<?php endforeach;?>
			  				</span>
			  			</marquee>
			  		</div>
			  	</div>
			  </div>
			</div>
			<div class="row mt-3 text-center">
				<?php foreach ($loket as $value) :?>

				<div class="col-6 my-2">
					<div id="<?= $value->counter_id ?>" class="card">
						<div class="card-body counter">
							<h2 id="queue-<?= $value->counter_id ?>"><?= $this->home_m->nomorAntrian($value->counter_id) + 1?></h2>
							<p class="count-text "><?= $value->counter_name ?></p>
						</div>
					  	<a href="#" class="btn-print" data-id="<?= $value->counter_id ?>" title="<?= $value->counter_name ?>">
							<div class="card-footer text-center">
								<strong><i class="fas fa-print"></i> Cetak Nomor</strong>
							</div>
					  	</a>
					</div>
				</div>

				<?php endforeach;?>
			</div>
			<div class="row mt-3">
			  <div class="col-12">
			  	<div class="card text-light rounded-3 p-3 text-center" style="background-color: #264653;">
			  		<small><?= $this->app->site_name ?></small>
			  		<small><?= $this->app->site_address ?></small>
			  		<small>TELP: <?= $this->app->site_phone ?> &bull; EMAIL: <?= $this->app->site_email ?></small>
			  	</div>
			  </div>
			</div>
		</div>