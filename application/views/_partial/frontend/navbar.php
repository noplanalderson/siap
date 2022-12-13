		<!-- Navigation -->
		<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #264653;">
			<div class="container">
				<a class="navbar-brand" href="<?= base_url() ?>">
					<img src="_/uploads/sites/icon.png" width="50" alt="Icon">
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-bs-controls="navbarResponsive" aria-bs-expanded="false" aria-bs-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarResponsive">
					<ul class="navbar-nav ml-auto float-md-end float-sm-start">
						<li class="nav-item active">
							<a class="nav-link text-white fw-bold" href="<?= base_url() ?>">Home
								<span class="sr-only"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-white fw-bold" href="<?= base_url('atm') ?>">ATM
								<span class="sr-only"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-white fw-bold" href="<?= base_url('portaladmin') ?>">Login</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>