<div class="container-fluid pt-3">
	<div class="row">
		<div class="col-xl-12">
	    <div class="card bg-neutral">
	      <div class="card-header bg-transparent">
	        <div class="row align-items-center">
	          <div class="col">
	            <h5 class="h3 text-black mb-0"><?php _e( 'Relasi Gejala & Kerusakan', 'WPIC' ); ?></h5>
	          </div>
	          <div class="col d-flex" style="justify-content: flex-end;">
	          	<?php if ( isset( $_GET['part'] ) ): ?>
	          		<a href="<?= request()->getHeader('redirect_url'); ?>" type="button" class="btn btn-primary"><?php _e( 'Kembali', 'WPIC' ); ?></a>
	          	<?php else: ?>
	          		<a href="<?= url( null, null, [ 'part' => 'basis-data' ] ) ?>" type="button" class="btn btn-sm btn-light"><?php _e( 'Lihat Basis Data', 'WPIC' ); ?></a>
	          	<?php endif ?>
	          </div>
	        </div>
	      </div>
	      <div class="card-body">
			<?php
				$part = isset($_GET['part']) ? $_GET['part'] : '';
				switch (strtolower($part)) {
					case 'lihat-kriteria':
						include( 'relasi-kerusakan/kriteria.php' );
						break;
					case 'lihat-alternatif':
						include( 'relasi-kerusakan/alternatif.php' );
						break;
					case 'edit-relasi':
						include( 'relasi-kerusakan/edit-relasi.php' );
						break;
					case 'basis-data':
						include( 'basis-pengetahuan/main-content.php' );
						break;
					default:
						include( 'relasi-kerusakan/main-content.php' );
						break;
				}
			?>
	      </div>
	    </div>
	  </div>
	</div>
</div>