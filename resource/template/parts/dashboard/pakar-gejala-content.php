<div class="container-fluid pt-3">
	<div class="row">
		<div class="col-xl-12">
	    <div class="card bg-neutral">
	      <div class="card-header bg-transparent">
	        <div class="row align-items-center">
	          <div class="col">
	            <h5 class="h3 text-black mb-0"><?php _e( 'Data Gejala / Kriteria', 'WPIC' ); ?></h5>
	          </div>
	          <div class="col d-flex" style="justify-content: flex-end;">
	          	<?php if ( isset( $_GET['tambah-gejala'] ) || isset( $_GET['edit-gejala'] ) ): ?>
	          		<a href="<?= request()->getHeader('redirect_url'); ?>" type="button" class="btn btn-primary"><?php _e( 'Kembali', 'WPIC' ); ?></a>
	          	<?php else: ?>
	          		<a href="<?= url( null, null, [ 'tambah-gejala' => true ] ) ?>" type="button" class="btn btn-primary"><?php _e( 'Tambah Data', 'WPIC' ); ?></a>
	          	<?php endif ?>
	          </div>
	        </div>
	      </div>
	      <div class="card-body">
			<?php
				if ( isset( $_GET['tambah-gejala'] ) || isset( $_GET['edit-gejala'] ) ){
					include( 'gejala/edit-tambah-gejala.php' );
				} else{
					include( 'gejala/main-content.php' );
				}
			?>
	      </div>
	    </div>
	  </div>
	</div>
</div>