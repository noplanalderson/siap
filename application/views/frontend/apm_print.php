		<!-- Page Content -->
		<div class="container py-3 px-5">
			<div class="row mb-3 text-center">

				<div class="col-12">
					<h1><?= $loket->counter_name ?></h1>
					<div class="card">
						<div class="card-body">
							<h4>Nomor Antrian</h4>
							<h1 style="font-size: 80pt;"><?= $antrian ?></h1>
						</div>
					</div>
				</div>

			</div>
			<div class="row mt-3">
			  <div class="col-12 text-center">
		  		<p style="margin-bottom: -1px;"><?= $this->app->site_name ?></p>
		  		<p style="margin-bottom: -1px;"><?= $this->app->site_address ?></p>
		  		<p>TELP: <?= $this->app->site_phone ?> &bull; EMAIL: <?= $this->app->site_email ?></p>
			  </div>
			</div>
		</div>