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
			<div class="row mt-1">
				<div class="col-md-7 col-sm-12">
					<div id="carouselExampleCaptions" class="carousel slide mt-2" data-bs-ride="carousel">

					  <div class="carousel-inner">
					  	<?php foreach ($slides as $key => $slide) :?>

					    <div class="carousel-item <?= ($key === 0) ? 'active' : ''; ?>" data-bs-interval="10000">
					      <img src="<?= site_url('_/uploads/slides/'.$slide->image) ?>" class="d-block rounded" width="100%" height="500px" alt="...">
					      <div class="carousel-caption d-block" style="background-color: rgba(31, 31, 31, 0.90);">
					        <h5 class="text-light"><?= $slide->slide_title ?></h5>
					        <p><?= $slide->slide_description ?></p>
					      </div>
					    </div>
						<?php endforeach;?>

					  </div>
					  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
					    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
					    <span class="visually-hidden">Previous</span>
					  </button>
					  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
					    <span class="carousel-control-next-icon" aria-hidden="true"></span>
					    <span class="visually-hidden">Next</span>
					  </button>
					</div>
				</div>
				<div class="col-md-5 col-sm-12 mt-sm-4 mt-lg-0">
					<div class="row text-center">
						<?php foreach ($loket as $value) :?>

						<div class="col-6 my-2">
							<div class="counter">
								<h2 id="count-<?= $value->counter_id ?>"><?= $this->home_m->nomorAntrian($value->counter_id) ?></h2>
								<p class="count-text"><?= $value->counter_name ?></p>
							</div>
						</div>

						<?php endforeach;?>
					</div>
					<!-- /.row -->
				</div>
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