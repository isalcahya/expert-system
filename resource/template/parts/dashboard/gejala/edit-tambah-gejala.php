<?php
use Models\Gejala;
if ( isset( $_GET['edit-gejala'] ) && ! empty( $_GET['edit-gejala'] ) ) {
	$id_gejala = $_GET['edit-gejala'];
	$gejala = Gejala::where( 'id_gejala', $id_gejala )->first();
}
?>

<div class="col-xl-6">
	<div class="card bg-neutral">
		 <div class="card-header bg-transparent">
		 	<div class="row align-items-center">
	          <div class="col">
	            <h5 class="h3 text-black mb-0"><?php _e( 'Tambah Gejala Baru', 'WPIC' ); ?></h5>
	          </div>
	        </div>
		</div>
		<div class="card-body">
			<form action="<?= url('gejala') ?>" method="POST">
				<input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
				<input type="hidden" name="_request_page" value="<?php echo ! isset($gejala) ? 'tambah_gejala' : 'edit_gejala' ?>">
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-username"><?php _e( 'Kode', 'wpic' ); ?></label>
					    <input type="text" id="input-username" class="form-control" placeholder="Kode xxx" name="gejala[kode_gejala]" value="<?php echo isset($gejala->id_gejala) ? sprintf('G%d', $gejala->id_gejala) : 'G..'?>">
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Gejala', 'wpic' ); ?></label>
					    <textarea type="text" id="input-first-name" class="form-control" placeholder="Name" name="gejala[nama_gejala]"><?php echo isset($gejala->nama_gejala) ? $gejala->nama_gejala : ''?></textarea>
					  </div>
					</div>
				</div>
				<?php
				/*
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Mb', 'wpic' ); ?></label>
					    <input type="number" step="0.01" id="input-first-name" class="form-control" placeholder="Name" name="gejala[mb]" value="<?php echo isset($gejala->mb) ? $gejala->mb : ''?>">
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					  <div class="form-group">
					    <label class="form-control-label" for="input-first-name"><?php _e( 'Md', 'wpic' ); ?></label>
					    <input type="number" step="0.01" id="input-first-name" class="form-control" placeholder="Name" name="gejala[md]" value="<?php echo isset($gejala->md) ? $gejala->md : ''?>">
					  </div>
					</div>
				</div>
				 */
				?>
				<div class="row">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-md btn-success"><?php _e( 'Submit', 'wpic' ); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>